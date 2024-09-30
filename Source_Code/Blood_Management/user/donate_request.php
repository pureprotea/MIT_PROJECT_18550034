<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Donation Event';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Donation System <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
<script  type="text/javascript">
	function validate_form(){
		validateDate(document.getElementById('SDATE'), document.getElementById('SDATE_help'));
		validateDate(document.getElementById('EDATE'), document.getElementById('EDATE_help'));
		validateNonEmpty(document.getElementById('LOCATION'), document.getElementById('LOCATION_help'));

	}
	</script>
</head>
<body <?php if (isset($_POST['submit'])) echo 'onload="validate_form()"' ?>>

  <?php
  require_once('heading.php');
  
  //require_once('appvars.php');
  require_once('db_con_vars.php');

  // Show the navigation menu
  require_once('navmenu.php');
  
  // Show body common content
  require_once('body.php');
	
$userid=strtoupper($_SESSION['user_id']);

		 if (!empty($_GET['req_id'])){
			 		$req_id =  $_GET['req_id'];
					
		
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$query = "SELECT a.*,b.R_CRE_TIME,b.R_CRE_USER_ID,b.L_CHG_TIME,b.L_CHG_USER_ID FROM pending_request_view a,blood_request_tbl b  
				where a.request_id='$req_id' and a.request_id=b.request_id";
									//echo "<DIV CLASS='debug'>$query</DIV>";

		$result=mysqli_query($dbc, $query);
		if (mysqli_num_rows($result)==1){

		while($row=mysqli_fetch_array($result)){
		$req_id=$row['request_id'];
		$req_date=$row['request_date'];
		$urgency = $row['urgency'];
		$blood_group = $row['BLOOD_GROUP'];

		$user_id = $row['user_id'];
		$name = $row['first_name'];
		$mobile_no = $row['mobile_no'];
		$email_address = $row['email_Address'];
		$city = $row['CITY'];

		$r_cre_time = $row['R_CRE_TIME'];
		$r_cre_user_id = $row['R_CRE_USER_ID'];
		$l_chg_time = $row['L_CHG_TIME'];
		$l_chg_user_id = $row['L_CHG_USER_ID'];
												}
												
															
			}
			//if invalid id no keyed in through url redirects to host_campaign.php
			else{
				 $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
				  '/donate_request.php';
				  header('Location: ' . $url);
				}
				
				mysqli_close($dbc);			

		 }
    if (isset($_POST['submit'])) {
	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());		

		// Grab the POST data
$req_id = mysqli_real_escape_string($dbc, trim($_POST['REQ_ID']));
$user_id = mysqli_real_escape_string($dbc, trim($_POST['USER_ID']));
$name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['NAME'])));
$city = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['CITY'])));
$urgency = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['URGENCY'])));
$blood_group = mysqli_real_escape_string($dbc, trim($_POST['BLOOD_GROUP']));
$email_address = mysqli_real_escape_string($dbc, trim($_POST['EMAIL_ADDRESS']));
$mobile_no = mysqli_real_escape_string($dbc, trim($_POST['MOBILE_NO']));


$r_cre_time = mysqli_real_escape_string($dbc, trim($_POST['R_CRE_TIME_HIDDEN_ID']));
$r_cre_user_id = mysqli_real_escape_string($dbc, trim($_POST['R_CRE_USER_ID_HIDDEN_ID']));
$l_chg_time = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_TIME_HIDDEN_ID']));
$l_chg_user_id = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_USER_ID_HIDDEN_ID']));
		
		
		$query_eligibility = "SELECT * FROM blood_management.eligible_donors_view where USER_ID='$userid'";
									//echo "<DIV CLASS='debug'>$query_eligibility</DIV>";

		$result_eligibility=mysqli_query($dbc, $query_eligibility);
		if (mysqli_num_rows($result_eligibility)==1){
			

// Check wheteher all mandatory data keyed in
if(!empty($req_id))
{

	begin($dbc);
	
		// insert to the blood_donation_campaign_tbl
	$query1 = "select DONATION_ID from  `blood_management`.`donation_event_tbl`  where DONOR_ID='$userid' and status='P' limit 1";
	
										//echo "<DIV CLASS='debug'>$query1</DIV>";
	$result1=mysqli_query($dbc, $query1);
									//echo "<DIV CLASS='debug'>$result1</DIV>";
									
									
	while ($row = mysqli_fetch_array($result1)){
	$don_id=$row['DONATION_ID'];  }

	  
	  if (empty($don_id)) {

	// insert to the blood_donation_campaign_tbl
	$query2 = "INSERT INTO `blood_management`.`donation_event_tbl`
			(`DONOR_ID`,`REQUEST_DATE`,`ORG_REQ_ID`,`STATUS`,`R_CRE_USER_ID`,`L_CHG_USER_ID`)
			VALUES('$userid',sysdate(),'$req_id','P','$userid','$userid')";
	
										//echo "<DIV CLASS='debug'>$query2</DIV>";
 $result2=mysqli_query($dbc, $query2);
									//echo "<DIV CLASS='debug'>$result2</DIV>";
									
  $donation_id = mysqli_insert_id($dbc);
									
									//echo "<DIV CLASS='debug'>$donation_id</DIV>";

	
if ($result1) {
    commit($dbc);
    $msg = 'Donation ID: ' . $donation_id.' \n Donation event details have been successfully updated.';
    echo '<script>';
    echo 'alert("' . $msg . '");'; // Display an alert box with the success message
    echo 'window.location.href = "http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/active_campaigns.php";'; 
    echo '</script>';
    exit; // exit the script after redirection
	}
	else {
    rollback($dbc);
    $err_msg = 'Oops! Something went wrong. Please try again later or contact support for assistance.';
}

} 
else {
        // Count is  greater than 1
        $err_msg='Already Pending Donation ID Exists Under :'. $don_id;
    }
	
}
else {
            $err_msg='Validation Failed';
			   }
}
else {
            $err_msg='Donor is Not Eligible';
			   }
			   
		mysqli_close($dbc);  
	}
	
	
?>
		
    <form name="donate_requestform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	
  <div class="left" style="width:60%">
	 <h2>Request Details</h2>
      <div class="field">
        <label for="REQ_ID">Request ID:</label>
        <input id="REQ_ID" name="REQ_ID" type="text" size="17" value="<?php if (!empty($req_id)) echo $req_id; ?>"
          onblur="validateNonEmpty(this, document.getElementById('REQ_ID_help'))" readonly="readonly"/>
        <span id="REQ_ID_help" class="help"></span>
      </div>
	  
	  
	  <div class="field">
        <label for="USER_ID">User ID:</label>
        <input id="USER_ID" name="USER_ID" type="text" size="17" value="<?php if (!empty($user_id)) echo $user_id; ?>"
          onblur="validateNonEmpty(this, document.getElementById('USER_ID_help'))" readonly="readonly"/>
        <span id="USER_ID_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="NAME">Name:</label>
        <input id="NAME" name="NAME" type="text" size="45" value="<?php if (!empty($name)) echo $name; ?>" readonly="readonly" />
      </div>
	  
	  
	  <div class="field">
        <label for="CITY">City:</label>
        <input id="CITY" name="CITY" type="text" size="45" value="<?php if (!empty($city)) echo $city; ?>" readonly="readonly" />
      </div>

	  
	  <div class="field">
        <label for="URGENCY">Urgency:</label>
      <input id="URGENCY" name="URGENCY" type="text" size="60" value="<?php if (!empty($urgency)) echo $urgency; ?>" readonly="readonly" />
	  	<span id="URGENCY_help" class="help"></span>
      </div>
	 
	 <div class="field">
        <label for="BLOOD_GROUP">Blood Group:</label>
      <input id="BLOOD_GROUP" name="BLOOD_GROUP" type="text" size="60" value="<?php if (!empty($blood_group)) echo $blood_group; ?>" readonly="readonly" />
	  	<span id="BLOOD_GROUP_help" class="help"></span>
      </div> 	  
	  
	
	 <div class="field">
        <label for="EMAIL_ADDRESS">Email Address:</label>
        <input id="EMAIL_ADDRESS" name="EMAIL_ADDRESS" type="text" size="30" value="<?php if (!empty($email_address)) echo $email_address; ?>"
           onblur="validateEmail(this, document.getElementById('EMAIL_ADDRESS_help'))" readonly="readonly" /> 
        <span id="EMAIL_ADDRESS_help" class="help"></span>
      </div>
		  
		  
		<div class="field">
        <label for="MOBILE_NO">Mobile Number:</label>
        <input id="MOBILE_NO" name="MOBILE_NO" type="text" size="20" value="<?php if (!empty($mobile_no)) echo $mobile_no; ?>"
			onblur="validatePhone(this, document.getElementById('MOBILE_NO_help'))" readonly="readonly" /> 
        <span id="MOBILE_NO_help" class="help"></span>
      </div>
	  
	  <br/>
	  <br/>
	  <br/>
	  
	  <div class="button">
		<input type="submit" class="sumbit" value="Donation Request" name="submit" />
	  </div>
	  
  </div>	
  
<div class="right" style="width:40%">
	 <h3><em>Record History</em></h3>
	  <div class="field">
        <label for="R_CRE_TIME">Record Created Time:</label>
        <input id="disabled" name="R_CRE_TIME" type="text" size="20" 
		value="<?php if (!empty($r_cre_time)) echo $r_cre_time; ?>"  disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="R_CRE_TIME_HIDDEN_ID" name="R_CRE_TIME_HIDDEN_ID" type="hidden" size="20" 
		value="<?php if (!empty($r_cre_time)) echo $r_cre_time; ?>" />
		
	  
	        <div class="field">
        <label for="R_CRE_USER_ID">Record Created User:</label>
        <input id="disabled" name="R_CRE_USER_ID" type="text" size="20" 
		value="<?php if (!empty($r_cre_user_id)) echo $r_cre_user_id; ?>"  disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="R_CRE_USER_ID_HIDDEN_ID" name="R_CRE_USER_ID_HIDDEN_ID" type="hidden" size="20" 
		value="<?php if (!empty($r_cre_user_id)) echo $r_cre_user_id; ?>" />
		
		
	        <div class="field">
        <label for="L_CHG_TIME">Last Modified Time:</label>
        <input id="disabled" name="L_CHG_TIME" type="text" size="20" 
		value="<?php if (!empty($l_chg_time)) echo $l_chg_time; ?>"  disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="L_CHG_TIME_HIDDEN_ID" name="L_CHG_TIME_HIDDEN_ID" type="hidden" size="20" 
		value="<?php if (!empty($l_chg_time)) echo $l_chg_time; ?>" />
		
	  
	        <div class="field">
        <label for="L_CHG_USER_ID">Last Modified User:</label>
        <input id="disabled" name="L_CHG_USER_ID" type="text" size="20" 
		value="<?php if (!empty($l_chg_user_id)) echo $l_chg_user_id; ?>"  disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="L_CHG_USER_ID_HIDDEN_ID" name="L_CHG_USER_ID_HIDDEN_ID" type="hidden" size="20" 
		value="<?php if (!empty($l_chg_user_id)) echo $l_chg_user_id; ?>" />
		

	<div>
		<a href='req_pending.php' style="display: inline-block; margin-top: 130px;float:right;width:46.5px;padding-left:30px;padding-right:30px;">
			<img id='button_right' src='images/back.png' alt='BACK'/>
		</a>
	</div>

</div>

    </form>

<?php
  // Insert the page footer
  require_once('footer.php');
    	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>