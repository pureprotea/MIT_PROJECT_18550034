<?php
  // Start the session if cookie var available assign them to session var
  //require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'User Registration!';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
	<script  type="text/javascript">
	function validate_form(){
		validateNonEmpty(document.getElementById('FIRST_NAME'), document.getElementById('FIRST_NAME_help'));
		validateNonEmpty(document.getElementById('LAST_NAME'), document.getElementById('LAST_NAME_help'));
		validateDate(document.getElementById('DOB'), document.getElementById('DOB_help'));
		validateNIC(document.getElementById('ID_NUM'), document.getElementById('ID_NUM_help'));
		validateNonEmpty(document.getElementById('ADDRESS1'), document.getElementById('ADDRESS1_help'));
		validateNonEmpty(document.getElementById('ADDRESS2'), document.getElementById('ADDRESS2_help'));
		validateNonEmpty(document.getElementById('CITY'), document.getElementById('CITY_help'));
		validateNonEmpty(document.getElementById('OCCUPATION'), document.getElementById('OCCUPATION_help'));
		validateEmail(document.getElementById('EMAIL_ADDRESS'), document.getElementById('EMAIL_ADDRESS_help'));	
		validatePhone(document.getElementById('TP_NO'), document.getElementById('TP_NO_help'));
		validatePhone(document.getElementById('MOBILE_NO'), document.getElementById('MOBILE_NO_help'));
	}

		</script>
<style>
	input[type=text], input[type=password], select {
    width: 40%;
    padding: 5px ;
    margin: 0px 0;
    display: inline-block;

    border-radius: 4px;
    box-sizing: border-box;
	background-color: #dce1ff;
}
</style>
</head>
<body <?php if (isset($_POST['submit'])) echo 'onload="validate_form()"' ?>>
  
<?php  
  require_once('heading.php');
  
  //require_once('appvars.php');
  require_once('db_con_vars.php');

  // Show the navigation menu
  //require_once('navmenu.php');
  
  // Show body common content
  require_once('body.php');
  


  
    if (isset($_POST['submit'])) {
		 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
			
// Grab the POST data
$title = mysqli_real_escape_string($dbc, trim($_POST['TITLE']));
$first_name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['FIRST_NAME'])));
$last_name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['LAST_NAME'])));
$id_type = mysqli_real_escape_string($dbc, trim($_POST['ID_TYPE']));
$id_num = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ID_NUM'])));
$dob = mysqli_real_escape_string($dbc, trim($_POST['DOB']));
$blood_group = mysqli_real_escape_string($dbc, trim($_POST['BLOOD_GROUP']));
$address1 = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ADDRESS1'])));
$address2 = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ADDRESS2'])));
$city = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['CITY'])));
$province = mysqli_real_escape_string($dbc, trim($_POST['PROVINCE']));
$district = mysqli_real_escape_string($dbc, trim($_POST['DISTRICT']));

$occupation = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['OCCUPATION'])));
$email_address = mysqli_real_escape_string($dbc, trim($_POST['EMAIL_ADDRESS']));
$tp_no = mysqli_real_escape_string($dbc, trim($_POST['TP_NO']));
$mobile_no = mysqli_real_escape_string($dbc, trim($_POST['MOBILE_NO']));

$donor_flg = ''; // Initialize the variable

//if checked POST variable is not empty, Thus Value will be set to Y else N
if (isset($_POST['DONOR'])){
$donor="Y";
}
else{
$donor="N";
}

//$user=strtoupper(($_SESSION['admin_id']));


//Check ID already exists
$NIC_DUP_query = "SELECT * from user_master_tbl WHERE id_num='$id_num' and del_flg='N'";
			
									//echo "<DIV CLASS='debug'>$NIC_DUP_query</DIV>";
		
$NIC_DUP_result=mysqli_query($dbc, $NIC_DUP_query);
if (mysqli_num_rows($NIC_DUP_result)==0){


// Check wheteher all mandatory data keyed in
if(!empty($title))
	{
		  require_once('validation.php');
		  
		  //Field Validations- NIC, DATE, PHONE NO, EMAIL
		  if (email_validation($email_address)&& phone_validation($tp_no)&& phone_validation($mobile_no)
			 &&  date_validation($dob) && NIC_validation($id_type,$id_num)){

//Age Calculation Before Insert	  
$query_age = "select datediff(curdate(),STR_TO_DATE('$dob','%Y-%m-%d' ))/365 as AGE from dual";
 $result_age=mysqli_query($dbc, $query_age);
	$row=mysqli_fetch_array($result_age);
	$age=$row['AGE'];
	if ($age>=18){
		 
$password = "";
//random generate password
  for ($i = 0; $i < 8; $i++) {
    $password.= chr(rand(97, 122));
  }

		 
//insert statements begins here		  
	begin($dbc);
// insert to the user_master_tbl
$query = "INSERT INTO user_master_tbl(TITLE, FIRST_NAME, LAST_NAME, ID_TYPE, ID_NUM, DOB,DONOR_FLG,DONOR_STATUS, BLOOD_GROUP,  ADDRESS1, ADDRESS2, CITY, PROVINCE, OCCUPATION, 
			 EMAIL_ADDRESS, TP_NO, MOBILE_NO, R_CRE_TIME, R_CRE_USER_ID, L_CHG_TIME, L_CHG_USER_ID) values (
			'$title' ,'$first_name' ,'$last_name' ,'$id_type' ,'$id_num' ,STR_TO_DATE('$dob','%Y-%m-%d'),'$donor', 'NE' ,'$blood_group' ,'$address1' ,'$address2' ,'$city' ,
			 '$province' , '$occupation' ,
			'$email_address', '$tp_no', '$mobile_no', now(), 'SYSTEM', now(), 'SYSTEM')";
									echo "<DIV CLASS='debug'>$query</DIV>";
									
 $result=mysqli_query($dbc, $query);
									echo "<DIV CLASS='debug'>$result</DIV>";
									

if($result){
	  
		  //get newly created membership id
$query1 = "SELECT USER_ID from user_master_tbl WHERE id_num='$id_num' and del_flg='N'";
								echo "<DIV CLASS='debug'>$query1</DIV>";
 $result1=mysqli_query($dbc, $query1);
  while ($row = mysqli_fetch_array($result1)){
	  $user_id=$row['USER_ID'];  }
	  
	 
	  
//Write into Login Table
if (!empty($user_id)){
	$query1 = "INSERT INTO user_login_tbl (USER_ID, USER_PWD, NO_OF_ATTEMPTS, R_CRE_TIME, R_CRE_USER_ID)
			values ('$user_id', sha(CONCAT(UPPER('$user_id'),'$password')), '0',now(), 'SYSTEM')";
			 
			 
									//echo "<DIV CLASS='debug'>$query1</DIV>";
		
$result1=mysqli_query($dbc, $query1);


$query2 = "INSERT INTO donor_tbl (DONOR_ID,R_CRE_USER_ID,L_CHG_USER_ID) VALUES('$user_id', 'SYSTEM', 'SYSTEM')";
			 
			 
									//echo "<DIV CLASS='debug'>$query2</DIV>";
		
$result2=mysqli_query($dbc, $query2);



	// Insert to the reward_tran_tbl
$query3 = "INSERT INTO `blood_management`.`reward_tran_tbl` (USER_ID, TRAN_TYPE, REMARK, TRAN_AMOUNT, CR_DR_IND, R_CRE_USER_ID, L_CHG_USER_ID)
            VALUES('$user_id','SIGNUP','Initial Topup',  500.00,'CR','$user_id','$user_id')";
										
										//echo "<DIV CLASS='debug'>$query3</DIV>";
										
										
 $result3=mysqli_query($dbc, $query3);
									//echo "<DIV CLASS='debug'>$result3</DIV>";

$query4 = "INSERT INTO reward_balance_tbl (USER_ID, REWARD_POINT_BALANCE) VALUES ('$user_id', 500)";
			 
			 
									//echo "<DIV CLASS='debug'>$query4</DIV>";
									//echo "<DIV CLASS='debug'>$result4</DIV>";
		
$result4=mysqli_query($dbc, $query4);

	if($result1 && $result2 && $result3 && $result4){
		commit($dbc);
		
	  $err_msg="User Successfully Activated. Login Password sent to $email_address";
		
	  $from = 'systembloodmanagement@gmail.com';
	  $subject = "Web Based Blood Management System User Account Login Details";
      $msg = "Dear $first_name $last_name,

Your Web Based Blood Management System User Registration Completed and User Account is Created.
Please use following credentials to login.
	  
User id is - $user_id .
and Password is  - $password.";
	  
      mail($email_address, $subject, $msg, 'From:' . $from);
	
				//transaction is complete here. so load sucess page.
		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  "/add_user_sucess.php?id_num=" . $id_num ."&id_type=". $id_type;
          header('Location: ' . $url);
		  			}
	//when Login Table Insert Failed
		else {
				rollback($dbc);
				$err_msg='FATAL ERROR:- Login Table Insert Failed.';
			}						
		}	
		//when User ID is not Returned
		else {
				rollback($dbc);
				$err_msg='FATAL ERROR:- User Not Added Sucessfully. User ID not Returned';
			}					
				
		}
				//when Insert Stmt Failed
		else {
				rollback($dbc);
				echo $query;
				$err_msg='FATAL ERROR:- User Not Added Sucessfully. Insert Failed';
			}	
		
			
	}
	//Minor
	else {
				$err_msg='Validations Failed';
			}
			
}
	//Sever Validations Fails; When all the mandatory fields are not keyed in
else {
            $err_msg='Please Key in all the Mandatary Values';
			   }
			   
  	}
	
		//JavaScript Validation Fails when Date,Phone No, Email and NIC validations fails

	else{
		 $err_msg='Form Validation Failed';
	}
		
		}
	    //Duplicate NIC
		else {	
			while ($row = mysqli_fetch_array($NIC_DUP_result)){
			$valid_user_id=$row['USER_ID'];       }
			$err_msg="NIC Already Exists with User id - $valid_user_id";	
			  }
			  
			  //DB conncection Closed
			  		mysqli_close($dbc);
					
			  //isset_POSTSUBMIT close brackets
			  }
	
?>
    <form name="addmemberform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	 
  <div class="left">
  <h2>User Details</h2>
	  <div class="field">
        <label for="TITLE">Title:</label>
	  <select id="TITLE" name="TITLE">
		<option value="MR."  <?php if (isset($_POST['submit'])) echo $title == "MR."   ? ' selected="selected"' : ''?>>MR.</option>
		<option value="MRS." <?php if (isset($_POST['submit'])) echo $title == "MRS."  ? ' selected="selected"' : ''?>>MRS.</option>
		<option value="MS."  <?php if (isset($_POST['submit'])) echo $title == "MS."   ? ' selected="selected"' : ''?>>MS.</option>
		<option value="MAST."<?php if (isset($_POST['submit'])) echo $title == "MAST." ? ' selected="selected"' : ''?>>MAST.</option>
		<option value="MISS."<?php if (isset($_POST['submit'])) echo $title == "MISS." ? ' selected="selected"' : ''?>>MISS.</option>
		<option value="DR."  <?php if (isset($_POST['submit'])) echo $title == "DR."   ? ' selected="selected"' : ''?>>DR.</option>
		<option value="REV." <?php if (isset($_POST['submit'])) echo $title == "REV."  ? ' selected="selected"' : ''?>>REV.</option>
	  </select>
	  </div>
	
      <div class="field">
        <label for="FIRST_NAME">First Name:</label>
        <input id="FIRST_NAME" name="FIRST_NAME" type="text" size="30" value="<?php if (!empty($first_name)) echo $first_name; ?>"
          onblur="validateNonEmpty(this, document.getElementById('FIRST_NAME_help'))" />
        <span id="FIRST_NAME_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="LAST_NAME">Last Name:</label>
        <input id="LAST_NAME" name="LAST_NAME" type="text" size="30" value="<?php if (!empty($last_name)) echo $last_name; ?>"
          onblur="validateNonEmpty(this, document.getElementById('LAST_NAME_help'))" />
        <span id="LAST_NAME_help" class="help"></span>
      </div>
	  
	 
	  <div class="field">
        <label for="ID_TYPE">ID Type:</label>
	  <select id="ID_TYPE" name="ID_TYPE">
		<option value="NIC"<?php if (isset($_POST['submit'])) echo $id_type == "NIC" ? ' selected="selected"' : ''?>>NIC</option>
		<option value="DL" <?php if (isset($_POST['submit'])) echo $id_type == "DL"  ? ' selected="selected"' : ''?>>DRIVING LICENSE</option>
		<option value="PP" <?php if (isset($_POST['submit'])) echo $id_type == "PP"  ? ' selected="selected"' : ''?>>PASSPORT</option>

	  </select>
	  </div>
	  
	  <div class="field">
        <label for="ID_NUM">ID No:</label>
        <input id="ID_NUM" name="ID_NUM" type="text" size="12" value="<?php if (!empty($id_num)) echo $id_num; ?>"
          onblur="validateNIC(this, document.getElementById('ID_NUM_help'))" />
        <span id="ID_NUM_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="DOB">DOB:</label>
        <input id="DOB" name="DOB" type="date" value="<?php if (!empty($dob)) echo $dob; ?>"
          onblur="validateDate(this, document.getElementById('DOB_help'))" />
        <span id="DOB_help" class="help"></span>
      </div>
	  
		 
	<div class="field">
        <label for="OCCUPATION">Occupation:</label>
        <input id="OCCUPATION" name="OCCUPATION" type="text" size="30" value="<?php if (!empty($occupation)) echo $occupation; ?>"
          onblur="validateNonEmpty(this, document.getElementById('OCCUPATION_help'))" />
        <span id="OCCUPATION_help" class="help"></span>
      </div>
	  
	<div class="field">
		<label for="BLOOD_GROUP">Blood Group:</label>
		<select id="BLOOD_GROUP" name="BLOOD_GROUP">
			<option value="A+" <?php if (isset($_POST['submit'])) echo $blood_group == "A+" ? ' selected="selected"' : ''?>>A+</option>
			<option value="A-" <?php if (isset($_POST['submit'])) echo $blood_group == "A-" ? ' selected="selected"' : ''?>>A-</option>
			<option value="B+" <?php if (isset($_POST['submit'])) echo $blood_group == "B+" ? ' selected="selected"' : ''?>>B+</option>
			<option value="B-" <?php if (isset($_POST['submit'])) echo $blood_group == "B-" ? ' selected="selected"' : ''?>>B-</option>
			<option value="AB+" <?php if (isset($_POST['submit'])) echo $blood_group == "AB+" ? ' selected="selected"' : ''?>>AB+</option>
			<option value="AB-" <?php if (isset($_POST['submit'])) echo $blood_group == "AB-" ? ' selected="selected"' : ''?>>AB-</option>
			<option value="O+" <?php if (isset($_POST['submit'])) echo $blood_group == "O+" ? ' selected="selected"' : ''?>>O+</option>
			<option value="O-" <?php if (isset($_POST['submit'])) echo $blood_group == "O-" ? ' selected="selected"' : ''?>>O-</option>
		</select>
	</div>
	  
  </div>
	  
	  
	  
 <div class="right">
  <h2>Contact Details</h2>
	  <div class="field">
        <label for="ADDRESS1">Address 1:</label>
        <input id="ADDRESS1" name="ADDRESS1" type="text" size="30" value="<?php if (!empty($address1)) echo $address1; ?>"
          onblur="validateNonEmpty(this, document.getElementById('ADDRESS1_help'))" />
        <span id="ADDRESS1_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="ADDRESS2">Address 2:</label>
        <input id="ADDRESS2" name="ADDRESS2" type="text" size="30" value="<?php if (!empty($address2)) echo $address2; ?>"
          onblur="validateNonEmpty(this, document.getElementById('ADDRESS2_help'))" />
        <span id="ADDRESS2_help" class="help"></span>
      </div>
	 
	 
	 
	 	  <div class="field">
        <label for="DISTRICT">District:</label>
        <input id="DISTRICT" name="DISTRICT" type="text" size="20"  value="<?php if (!empty($district)) echo $district; ?>"
		      onblur="validateNonEmpty(this, document.getElementById('DISTRICT_help'))" />
        <span id="DISTRICT_help" class="help"></span>
      </div>
	  
	 

	  <div class="field">
        <label for="CITY">City:</label>
        <input id="CITY" name="CITY" type="text" size="20"  value="<?php if (!empty($city)) echo $city; ?>"
		      onblur="validateNonEmpty(this, document.getElementById('CITY_help'))" />
        <span id="CITY_help" class="help"></span>
      </div>
	  

	  
	  <div class="field">
        <label for="PROVINCE">Province:</label>
		<select id="PROVINCE" name="PROVINCE">">
		<option value="WESTERN PROVINCE"      <?php if (isset($_POST['submit'])) echo $province == "WESTERN PROVINCE"       ? ' selected="selected"' : ''?>>WESTERN PROVINCE</option>
		<option value="CENTRAL PROVINCE"      <?php if (isset($_POST['submit'])) echo $province == "CENTRAL PROVINCE"       ? ' selected="selected"' : ''?>>CENTRAL PROVINCE</option>
		<option value="NORTH CENTRAL PROVINCE"<?php if (isset($_POST['submit'])) echo $province == "NORTH CENTRAL PROVINCE" ? ' selected="selected"' : ''?>>NORTH CENTRAL PROVINCE</option>
		<option value="NORTH WESTERN PROVINCE"<?php if (isset($_POST['submit'])) echo $province == "NORTH WESTERN PROVINCE" ? ' selected="selected"' : ''?>>NORTH WESTERN PROVINCE</option>
		<option value="NORTHERN PROVINCE"     <?php if (isset($_POST['submit'])) echo $province == "NORTHERN PROVINCE"      ? ' selected="selected"' : ''?>>NORTHERN PROVINCE</option>
		<option value="SABARAGAMUWA PROVINCE" <?php if (isset($_POST['submit'])) echo $province == "SABARAGAMUWA PROVINCE"  ? ' selected="selected"' : ''?>>SABARAGAMUWA PROVINCE</option>
		<option value="UVA PROVINCE"          <?php if (isset($_POST['submit'])) echo $province == "UVA PROVINCE"           ? ' selected="selected"' : ''?>>UVA PROVINCE</option>
		<option value="SOUTHERN PROVINCE"     <?php if (isset($_POST['submit'])) echo $province == "SOUTHERN PROVINCE"      ? ' selected="selected"' : ''?>>SOUTHERN PROVINCE</option>
		<option value="EASTERN PROVINCE"      <?php if (isset($_POST['submit'])) echo $province == "EASTERN PROVINCE"       ? ' selected="selected"' : ''?>>EASTERN PROVINCE</option>
	  </select>
      </div>
	  
	  

	  <div class="field">
        <label for="EMAIL_ADDRESS">Email Address:</label>
        <input id="EMAIL_ADDRESS" name="EMAIL_ADDRESS" type="text" size="30" value="<?php if (!empty($email_address)) echo $email_address; ?>"
           onblur="validateEmail(this, document.getElementById('EMAIL_ADDRESS_help'))" /> 
        <span id="EMAIL_ADDRESS_help" class="help"></span>
      </div>
		  
	  <div class="field">
        <label for="TP_NO">Telephone Number:</label>
        <input id="TP_NO" name="TP_NO" type="text" size="20" value="<?php echo (!empty($mobile_no)) ? $mobile_no:'011-2XXXXXX'; ?>"
		    onblur="validatePhone(this, document.getElementById('TP_NO_help'))" /> 
        <span id="TP_NO_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="MOBILE_NO">Mobile Number:</label>
        <input id="MOBILE_NO" name="MOBILE_NO" type="text" size="20" value="<?php echo (!empty($mobile_no)) ? $mobile_no:'07X-XXXXXXX'; ?>"
			onblur="validatePhone(this, document.getElementById('MOBILE_NO_help'))" /> 
        <span id="MOBILE_NO_help" class="help"></span>
      </div>
	  <br/>

	  
		<div class="field">
			<label for="DONOR">DONOR:</label>
			<input id="DONOR" name="DONOR_FLG" type="checkbox" value="Y" <?php if (!empty($donor_flg) && $donor_flg == 'Y') echo 'checked="checked"'; ?> />
		</div>
	  
	  
	  <div class="button" style="width: 150%;">
		<input type="submit" class="sumbit" value="Add User" name="submit" />
	  </div>
	<div>
		<a href='../index.php'><img id='button_right' src='/blood_management/admin/images/back.png' alt='BACK'/></a>
	</div>
  </div>
	  
    </form>
		  	<!--<p class="error" ><?php// if (!empty($err_msg)) echo $err_msg; ?></p>-->
<?php
  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>