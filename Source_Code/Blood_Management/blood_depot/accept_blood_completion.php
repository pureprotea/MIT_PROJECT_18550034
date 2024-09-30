<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Accept Blood!';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
</head>
<body>
  
<?php  
  require_once('heading.php');
  
  //require_once('appvars.php');
  require_once('db_con_vars.php');

  // Show the navigation menu
  require_once('navmenu.php');
  
  // Show body common content
  require_once('body.php');
  
  
      if (!empty($_POST['DON_HIDDEN_ID'])) {
		  		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$don_id =  strtoupper(mysqli_real_escape_string($dbc, trim($_POST['DON_HIDDEN_ID'])));
		$user_id=strtoupper(($_SESSION['bd_id']));
		$bd_id=strtoupper(($_SESSION['bd_id']));

			begin($dbc);
			
	// Update to the donation_event_tbl
	$query = "update blood_management.donation_event_tbl set STATUS='A',L_CHG_USER_ID='$user_id', BD_ID='$bd_id', DONATION_DATE=sysdate()
				where DONATION_ID='$don_id'";
	
										//echo "<DIV CLASS='debug'>$query</DIV>";
 $result=mysqli_query($dbc, $query);
									//echo "<DIV CLASS='debug'>$result</DIV>";


	// Update to the donor_tbl
	$query1 = "update donor_tbl set LAST_DONATION_DATE=sysdate()
			where DONOR_ID IN (SELECT DONOR_ID FROM blood_management.donation_event_tbl WHERE DONATION_ID='$don_id')";
	
										//echo "<DIV CLASS='debug'>$query1</DIV>";
 $result1=mysqli_query($dbc, $query1);
									//echo "<DIV CLASS='debug'>$result1</DIV>";


	// Update to the donor_tbl
	$query2 = "INSERT INTO `blood_management`.`blood_inventory_tbl`
				(`BD_ID`,`DONATION_ID`,`EXPIRY_DATE`,`STATUS`,`R_CRE_USER_ID`,`L_CHG_USER_ID`)
				VALUES('$bd_id','$don_id',(SYSDATE() + INTERVAL 42 DAY),'U','$user_id','$user_id');";
	
										//echo "<DIV CLASS='debug'>$query2</DIV>";
 $result2=mysqli_query($dbc, $query2);
									//echo "<DIV CLASS='debug'>$result2</DIV>";


	// Insert to the reward_tran_tbl
$query3 = "INSERT INTO `blood_management`.`reward_tran_tbl` (USER_ID, TRAN_TYPE, REMARK, TRAN_AMOUNT, CR_DR_IND, R_CRE_USER_ID, L_CHG_USER_ID)
            VALUES((SELECT DONOR_ID FROM blood_management.donation_event_tbl WHERE DONATION_ID='$don_id'),
            'DONATION', 'Donation ID: $don_id', 90.00,'CR','$user_id','$user_id')";
										//echo "<DIV CLASS='debug'>$query3</DIV>";
 $result3=mysqli_query($dbc, $query3);
									//echo "<DIV CLASS='debug'>$result3</DIV>";
									
	  $tran_id = mysqli_insert_id($dbc);								
									
									
	// Update to the reward_balance_tbl
$query4 = "update blood_management.reward_balance_tbl set REWARD_POINT_BALANCE=REWARD_POINT_BALANCE+90, LAST_TRAN_ID='$tran_id'
			where USER_ID=(SELECT DONOR_ID FROM blood_management.donation_event_tbl WHERE DONATION_ID='$don_id')";
										
										//echo "<DIV CLASS='debug'>$query3</DIV>";
 $result4=mysqli_query($dbc, $query4);
									//echo "<DIV CLASS='debug'>$result3</DIV>";



	
if ($result && $result1 && $result2 && $result3&& $result4) {
    commit($dbc);
	$msg = 'DONATION ID:  ' . $don_id . ' has been Accepted by BD.';
    echo '<script>';
    echo 'alert("' . $msg . '");'; // Display an alert box with the success message
    echo 'window.location.href = "http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/accept_blood.php";'; 
    echo '</script>';
    exit; // exit the script after redirection
	}
	else {
    rollback($dbc);
	$err_msg = 'Oops! Something went wrong while trying to Accepting ' . $don_id . ' by the Donor. Please try again later or contact support for assistance.';
}
	mysqli_close($dbc);  

}
else {
            $err_msg='Oops! Something Went Wrong';
			

			   }
			   

?>


    <h1>Health Assessment Questionnaire</h1>
    <form action="#">
        <table>
            <tr>
                <th>Question</th>
                <th>Yes</th>
                <th>No</th>
            </tr>
            <tr>
                <td>1.1 Are you feeling well and in good health today?</td>
                <td><input type="radio" name="q1_1" value="Yes"></td>
                <td><input type="radio" name="q1_1" value="No"></td>
            </tr>
            <tr>
                <td>1.2 In the last 4 hours, have you had a meal or snack?</td>
                <td><input type="radio" name="q1_2" value="Yes"></td>
                <td><input type="radio" name="q1_2" value="No"></td>
            </tr>
            <tr>
                <td>1.3 Have you already given blood in the last 16 weeks?</td>
                <td><input type="radio" name="q1_3" value="Yes"></td>
                <td><input type="radio" name="q1_3" value="No"></td>
            </tr>
            <tr>
                <td>1.4 Have you got a chesty cough, sore throat, or active cold sore?</td>
                <td><input type="radio" name="q1_4" value="Yes"></td>
                <td><input type="radio" name="q1_4" value="No"></td>
            </tr>
            <tr>
                <td>1.5 Are you pregnant or breastfeeding?</td>
                <td><input type="radio" name="q1_5" value="Yes"></td>
                <td><input type="radio" name="q1_5" value="No"></td>
            </tr>
            <tr>
                <td>1.6 Do you have or have you ever had:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>a) Chest pains, heart disease/surgery or a stroke?</td>
                <td><input type="radio" name="q1_6_a" value="Yes"></td>
                <td><input type="radio" name="q1_6_a" value="No"></td>
            </tr>
            <tr>
                <td>b) Lung disease, tuberculosis or asthma?</td>
                <td><input type="radio" name="q1_6_b" value="Yes"></td>
                <td><input type="radio" name="q1_6_b" value="No"></td>
            </tr>
            <tr>
                <td>c) Cancer, a blood disease, an abnormal bleeding disorder, or a bleeding gastric ulcer or duodenal ulcer?</td>
                <td><input type="radio" name="q1_6_c" value="Yes"></td>
                <td><input type="radio" name="q1_6_c" value="No"></td>
            </tr>
            <tr>
                <td>d) Diabetes, thyroid disease, kidney disease, epilepsy (fits)?</td>
                <td><input type="radio" name="q1_6_d" value="Yes"></td>
                <td><input type="radio" name="q1_6_d" value="No"></td>
            </tr>
            <tr>
                <td>e) Chagas disease, babesiosis, HTLVI/II or any other chronic infectious disease?</td>
                <td><input type="radio" name="q1_6_e" value="Yes"></td>
                <td><input type="radio" name="q1_6_e" value="No"></td>
            </tr>
            <tr>
                <td>1.7 In the last 7 days, have you seen a doctor, dentist, or any other healthcare professional or are you waiting to see one (except for routine screening appointments)?</td>
                <td><input type="radio" name="q1_7" value="Yes"></td>
                <td><input type="radio" name="q1_7" value="No"></td>
            </tr>
            <tr>
                <td>1.8 In the past 12 months:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>a) Have you been ill, received any treatment or taken any medication?</td>
                <td><input type="radio" name="q1_8_a" value="Yes"></td>
                <td><input type="radio" name="q1_8_a" value="No"></td>
            </tr>
            <tr>
                <td>b) Have you been under a doctor’s care, undergone surgery, or a diagnostic procedure, suffered a major illness, or been involved in a serious accident?</td>
                <td><input type="radio" name="q1_8_b" value="Yes"></td>
                <td><input type="radio" name="q1_8_b" value="No"></td>
            </tr>
            <tr>
                <td>1.9 Have you ever had yellow jaundice (excluding jaundice at birth), hepatitis or liver disease or a positive test for hepatitis?</td>
                <td><input type="radio" name="q1_9" value="Yes"></td>
                <td><input type="radio" name="q1_9" value="No"></td>
            </tr>
            <tr>
                <td>a) In the past 12 months, have you had close contact with a person with yellow jaundice or viral hepatitis, or have you been given a hepatitis B vaccination?</td>
                <td><input type="radio" name="q1_9_a" value="Yes"></td>
                <td><input type="radio" name="q1_9_a" value="No"></td>
            </tr>
            <tr>
                <td>b) Have you ever had hepatitis B or hepatitis C or think you may have hepatitis now?</td>
                <td><input type="radio" name="q1_9_b" value="Yes"></td>
                <td><input type="radio" name="q1_9_b" value="No"></td>
            </tr>
            <tr>
                <td>c) In the past 12 months, have you been tattooed, had ear or body piercing, acupuncture, circumcision or scarification, cosmetic treatment?</td>
                <td><input type="radio" name="q1_9_c" value="Yes"></td>
                <td><input type="radio" name="q1_9_c" value="No"></td>
            </tr>
            <tr>
                <td>1.10 In the past 12 months, have you or your sexual partner received a blood transfusion?</td>
                <td><input type="radio" name="q1_10" value="Yes"></td>
                <td><input type="radio" name="q1_10" value="No"></td>
            </tr>
            <tr>
                <td>1.11 Have you or your sexual partner been treated with human or animal blood products or clotting factors?</td>
                <td><input type="radio" name="q1_11" value="Yes"></td>
                <td><input type="radio" name="q1_11" value="No"></td>
            </tr>
            <tr>
                <td>1.12 Have you ever had injections of human pituitary growth hormone, pituitary gonadotrophin (fertility medicine) or seen a neurosurgeon or neurologist?</td>
                <td><input type="radio" name="q1_12" value="Yes"></td>
                <td><input type="radio" name="q1_12" value="No"></td>
            </tr>
            <tr>
                <td>1.13 Have you or close relatives had an unexplained neurological condition or been diagnosed with Creutzfeldt-Jacob Disease or ‘mad cow disease’?</td>
                <td><input type="radio" name="q1_13" value="Yes"></td>
                <td><input type="radio" name="q1_13" value="No"></td>
            </tr>
            <tr>
                <td>1.14 Have you:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>a) Ever had malaria or an unexplained fever associated with travel?</td>
                <td><input type="radio" name="q1_14_a" value="Yes"></td>
                <td><input type="radio" name="q1_14_a" value="No"></td>
            </tr>
            <tr>
                <td>b) Visited any malarial area in the last 12 months?</td>
                <td><input type="radio" name="q1_14_b" value="Yes"></td>
                <td><input type="radio" name="q1_14_b" value="No"></td>
            </tr>
            <tr>
                <td>1.15 When did you last travel to another region or _________________ country (in months / years)?</td>
                <td><input type="text" name="q1_15"></td>
                <td></td>
            </tr>
        </table>

        <h1>Risk Assessment Questionnaire</h1>
        <table>
            <tr>
                <th>Question</th>
                <th>Yes</th>
                <th>No</th>
            </tr>
            <tr>
                <td>2.1 Is your reason for donating blood to undergo an HIV test?</td>
                <td><input type="radio" name="q2_1" value="Yes"></td>
                <td><input type="radio" name="q2_1" value="No"></td>
            </tr>
            <tr>
                <td>2.2 Have you ever been tested for HIV?</td>
                <td><input type="radio" name="q2_2" value="Yes"></td>
                <td><input type="radio" name="q2_2" value="No"></td>
            </tr>
            <tr>
                <td>2.3 If ‘‘Yes’’ what was the reason? Voluntary Employment Insurance Medical advice Other: <input type="text" name="q2_3"></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2.4 Have you ever had casual, oral or anal sex with someone whose background you do not know, with or without a condom?</td>
                <td><input type="radio" name="q2_4" value="Yes"></td>
                <td><input type="radio" name="q2_4" value="No"></td>
            </tr>
            <tr>
                <td>2.5 Have you ever exchanged money, drugs, goods or favours in return for sex?</td>
                <td><input type="radio" name="q2_5" value="Yes"></td>
                <td><input type="radio" name="q2_5" value="No"></td>
            </tr>
            <tr>
                <td>2.6 Have you suffered from a sexually transmitted disease (STD): e.g. syphilis, gonorrhoea, genital herpes, genital ulcer, VD, or ‘drop’?</td>
                <td><input type="radio" name="q2_6" value="Yes"></td>
                <td><input type="radio" name="q2_6" value="No"></td>
            </tr>
            <tr>
                <td>2.7 In the past 12 months:</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>a) Has there been any change in your marital status?</td>
                <td><input type="radio" name="q2_7_a" value="Yes"></td>
                <td><input type="radio" name="q2_7_a" value="No"></td>
            </tr>
            <tr>
                <td>b) If sexually active, do you think any of the above questions (2.1-----2.6) may be true for your sexual partner?</td>
                <td><input type="radio" name="q2_7_b" value="Yes"></td>
                <td><input type="radio" name="q2_7_b" value="No"></td>
            </tr>
            <tr>
                <td>c) Have you been a victim of sexual abuse?</td>
                <td><input type="radio" name="q2_7_c" value="Yes"></td>
                <td><input type="radio" name="q2_7_c" value="No"></td>
            </tr>
            <tr>
                <td>2.8 Have you or your sexual partner suffered from night sweats, unintentional weight loss, diarrhea or swollen glands?</td>
                <td><input type="radio" name="q2_8" value="Yes"></td>
                <td><input type="radio" name="q2_8" value="No"></td>
            </tr>
            <tr>
                <td>2.9 Have you ever injected yourself or been injected with illegal or non-prescribed drugs including body-building drugs or cosmetics (even if this was only once or a long time ago)?</td>
                <td><input type="radio" name="q2_9" value="Yes"></td>
                <td><input type="radio" name="q2_9" value="No"></td>
            </tr>
            <tr>
                <td>2.10 Have you been in contact with anyone with an infectious disease or in the last 12 months have you had any immunizations, vaccinations or jabs?</td>
                <td><input type="radio" name="q2_10" value="Yes"></td>
                <td><input type="radio" name="q2_10" value="No"></td>
            </tr>
            <tr>
                <td>2.11 Have you ever been refused as a blood donor, or told not to donate blood?</td>
                <td><input type="radio" name="q2_11" value="Yes"></td>
                <td><input type="radio" name="q2_11" value="No"></td>
            </tr>
        </table>

        <div class="declaration">
            <h1>Declaration</h1>
            <p>
                <label><input type="checkbox" name="declaration[]" value="a"> I confirm that, to the best of my knowledge, I have answered all the questions accurately and I consider my blood safe for transfusion to a patient.</label><br>
                <label><input type="checkbox" name="declaration[]" value="b"> I understand that any wilful misrepresentation of facts could endanger my health or that of patients receiving my blood and may lead to litigation. I am aware that my blood will be screened for, among others, HIV, hepatitis B, hepatitis C and syphilis. I understand that these screening tests are not diagnostic and may yield false-positive results. If any of the tests give a reactive result, I will be contacted using the information I have provided, and offered counselling.</label><br>
                <label><input type="checkbox" name="declaration[]" value="c"> I understand the blood donation process, and I have been counseled regarding the importance of safe blood donation.</label><br>
                <label><input type="checkbox" name="declaration[]" value="d"> I confirm that I am over the age of 18 years.</label><br>
                <label><input type="checkbox" name="declaration[]" value="e"> I undertake that should there be any reason for my blood to be deemed unsafe for use at any stage, I will inform the Blood Transfusion Service.</label>
            </p>
        </div>

        <button type="submit">Submit</button>
		
		   <!-- Last Donation Date field -->
            <div class="form-group">
                <label for="lastDonationDate">Last Donation Date:</label>
                <input type="date" id="lastDonationDate" name="lastDonationDate" class="form-control">
            </div>
		
    </form>
	
	
	    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	 <script>
        function validateForm() {
            // Check if any radio button is unchecked
            var uncheckedRadio = document.querySelectorAll('input[type="radio"]:not(:checked)');
            if (uncheckedRadio.length > 0) {
                alert('Please answer all questions.');
                return false; // Prevent form submission
            }

            // Check if any text input is empty (if you have any)
            var textInputs = document.querySelectorAll('input[type="text"]');
            for (var i = 0; i < textInputs.length; i++) {
                if (textInputs[i].value.trim() === '') {
                    alert('Please fill in all fields.');
                    return false; // Prevent form submission
                }
            }

            // Check if at least one declaration checkbox is checked
            var declarationCheckboxes = document.querySelectorAll('input[name="declaration[]"]:checked');
            if (declarationCheckboxes.length === 0) {
                alert('Please agree to the declaration.');
                return false; // Prevent form submission
            }

            return true; // Submit the form if all validations pass
        }
    </script>
	
<?php 

  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>