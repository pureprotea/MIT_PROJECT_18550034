<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'User Modification!';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
	<script type="text/javascript">
	function validate_form(){
		validateNonEmpty(document.getElementById('FIRST_NAME'), document.getElementById('FIRST_NAME_help'));
		validateNonEmpty(document.getElementById('LAST_NAME'), document.getElementById('LAST_NAME_help'));
		validateDate(document.getElementById('DOB'), document.getElementById('DOB_help'));
		validateNonEmpty(document.getElementById('ADDRESS1'), document.getElementById('ADDRESS1_help'));
		validateNonEmpty(document.getElementById('ADDRESS2'), document.getElementById('ADDRESS2_help'));
		validateNonEmpty(document.getElementById('CITY'), document.getElementById('CITY_help'));
		validateNonEmpty(document.getElementById('OCCUPATION'), document.getElementById('OCCUPATION_help'));
		validateEmail(document.getElementById('EMAIL_ADDRESS'), document.getElementById('EMAIL_ADDRESS_help'));	
		validatePhone(document.getElementById('TP_NO'), document.getElementById('TP_NO_help'));
		validatePhone(document.getElementById('MOBILE_NO'), document.getElementById('MOBILE_NO_help'));
}
	</script>
</head>
<body onload="validate_form()">
  
<?php  
  require_once('heading.php');
  
  //require_once('appvars.php');
  require_once('db_con_vars.php');

  // Show the navigation menu
  require_once('navmenu.php');
  
  // Show body common content
  require_once('body.php');
  
    $user_id=strtoupper($_SESSION['user_id']);

  
      if (!empty($user_id)) {

		
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$query = "SELECT * FROM user_master_tbl WHERE USER_ID='$user_id'";
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 if (mysqli_num_rows($result)==1){
	 
 while($row=mysqli_fetch_array($result)){
$user_id=$row['USER_ID'];
$title = $row['TITLE'];
$first_name = $row['FIRST_NAME'];
$last_name = $row['LAST_NAME'];
$id_type = $row['ID_TYPE'];
$id_num = $row['ID_NUM'];
$donor_status = $row['DONOR_STATUS'];
$blood_group = $row['BLOOD_GROUP'];
$dob = $row['DOB'];
$donor_flg = $row['DONOR_FLG'];
$address1 = $row['ADDRESS1'];
$address2 = $row['ADDRESS2'];
$city = $row['CITY'];
$province = $row['PROVINCE'];
$occupation = $row['OCCUPATION'];
$email_address = $row['EMAIL_ADDRESS'];
$tp_no = $row['TP_NO'];
$mobile_no = $row['MOBILE_NO'];
$r_cre_time = $row['R_CRE_TIME'];
$r_cre_user_id = $row['R_CRE_USER_ID'];
$l_chg_time = $row['L_CHG_TIME'];
$l_chg_user_id = $row['L_CHG_USER_ID'];

										}
										
	}
  //if invalid membership id keyed in through url redirects to edit_member.php
	else{
	 	 $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/index.php';
          header('Location: ' . $url);
		}
		
		mysqli_close($dbc);
	  }
  
    if (isset($_POST['submit'])) {
		 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
			
// Grab the POST data
$user_id = mysqli_real_escape_string($dbc, trim($_POST['USER_HIDDEN_ID']));
$id_type = mysqli_real_escape_string($dbc, trim($_POST['ID_TYPE_HIDDEN_ID']));
$id_num = mysqli_real_escape_string($dbc, trim($_POST['ID_NUM_HIDDEN_ID']));
$status = mysqli_real_escape_string($dbc, trim($_POST['STATUS_HIDDEN_ID']));
$r_cre_time = mysqli_real_escape_string($dbc, trim($_POST['R_CRE_TIME_HIDDEN_ID']));
$r_cre_user_id = mysqli_real_escape_string($dbc, trim($_POST['R_CRE_USER_ID_HIDDEN_ID']));
$l_chg_time = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_TIME_HIDDEN_ID']));
$l_chg_user_id = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_USER_ID_HIDDEN_ID']));

//if checked POST variable is not empty, Thus Value will be set to Y else N
$donor_flg = ''; // Initialize the variable

if (isset($_POST['DONOR_FLG'])) {
    $donor_flg = "Y";
} else {
    $donor_flg = "N";
}


$title = mysqli_real_escape_string($dbc, trim($_POST['TITLE']));
$first_name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['FIRST_NAME'])));
$last_name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['LAST_NAME'])));
$dob = mysqli_real_escape_string($dbc, trim($_POST['DOB']));
$address1 = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ADDRESS1'])));
$address2 = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ADDRESS2'])));
$city = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['CITY'])));
$province = mysqli_real_escape_string($dbc, trim($_POST['PROVINCE']));
$blood_group = mysqli_real_escape_string($dbc, trim($_POST['BLOOD_GROUP']));
$occupation = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['OCCUPATION'])));
$email_address = mysqli_real_escape_string($dbc, trim($_POST['EMAIL_ADDRESS']));
$tp_no = mysqli_real_escape_string($dbc, trim($_POST['TP_NO']));
$mobile_no = mysqli_real_escape_string($dbc, trim($_POST['MOBILE_NO']));

$user=strtoupper(($_SESSION['user_id']));


// Check wheteher all mandatory data keyed in
if(!empty($user_id) &&!empty($title) && !empty($first_name) && !empty($last_name) &&  !empty($dob) && !empty($blood_group) &&
	!empty($address1) && !empty($address2) && !empty($city) && !empty($province) && !empty($occupation) && 
	 !empty($email_address) && !empty($tp_no)&& !empty($mobile_no)&& !empty($user))
{
		 //Field Validations- NIC, DATE, PHONE NO, EMAIL
		  require_once('validation.php');
			  if (email_validation($email_address)&& phone_validation($tp_no)&& phone_validation($mobile_no)
			   && NIC_validation($id_type,$id_num)){
		
begin($dbc);
// update database
$query = "update user_master_tbl set TITLE='$title', FIRST_NAME='$first_name', LAST_NAME='$last_name',
			 DOB=STR_TO_DATE('$dob','%Y-%m-%d'), DONOR_FLG='$donor_flg', ADDRESS1='$address1',ADDRESS2='$address2', CITY='$city', BLOOD_GROUP='$blood_group',
			 PROVINCE='$province', OCCUPATION='$occupation',  
			 EMAIL_ADDRESS='$email_address', TP_NO='$tp_no', MOBILE_NO='$mobile_no', L_CHG_TIME=now(), L_CHG_USER_ID='$user'
			 where USER_ID='$user_id'";
			
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
									//echo "<DIV CLASS='debug'>$result</DIV>";
									
//if update sucessful, refresh the page
if ($result){
	commit($dbc);
	      $err_msg="Update Sucessful";
	
	
   }
	else{
	rollback($dbc);
	$err_msg="Update Failed";
	}   
						
}
	else {
				$err_msg="Validations Failed";
			}
}
else {
            $err_msg="Mandatary Fields can't contain Null Values";
			   }
			   
		mysqli_close($dbc);  
	}
	
?>

    <form name="editmemberform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" 
	      onsubmit="return confirm('Do you want to Apply the Changes?');">
	<div class="left">

      <div class="field">
        <label for="USER_ID">User ID:</label>
        <input id="disabled" name="USER_ID" type="text" size="12" 
		value="<?php if (!empty($user_id)) echo $user_id; ?>"  disabled="true" />
      </div>
	  
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="USER_HIDDEN_ID" name="USER_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($user_id)) echo $user_id; ?>" />

	  <div class="field">
        <label for="TITLE">Title:</label>
	  <select id="TITLE" name="TITLE">
		<option value="MR."  <?php if (!empty($title)) echo $title == "MR."   ? ' selected="selected"' : ''?>>MR.</option>
		<option value="MRS." <?php if (!empty($title)) echo $title == "MRS."  ? ' selected="selected"' : ''?>>MRS.</option>
		<option value="MS."  <?php if (!empty($title)) echo $title == "MS."   ? ' selected="selected"' : ''?>>MS.</option>
		<option value="MAST."<?php if (!empty($title)) echo $title == "MAST." ? ' selected="selected"' : ''?>>MAST.</option>
		<option value="MISS."<?php if (!empty($title)) echo $title == "MISS." ? ' selected="selected"' : ''?>>MISS.</option>
		<option value="DR."  <?php if (!empty($title)) echo $title == "DR."   ? ' selected="selected"' : ''?>>DR.</option>
		<option value="REV." <?php if (!empty($title)) echo $title == "REV."  ? ' selected="selected"' : ''?>>REV.</option>
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
        <label for="DOB">DOB:</label>
        <input id="DOB" name="DOB" type="date" size="10" value="<?php if (!empty($dob)) echo $dob; ?>"
          onblur="validateDate(this, document.getElementById('DOB_help'))" />
        <span id="DOB_help" class="help"></span>
      </div>
	  
	  
	  
	  <div class="field">
        <label for="ID_TYPE">ID Type:</label>
	  <select id="disabled" name="ID_TYPE" disabled="true">
		<option value="NIC"<?php if (!empty($id_type)) echo $id_type == "NIC" ? ' selected="selected"' : ''?>>NIC</option>
		<option value="BC" <?php if (!empty($id_type)) echo $id_type == "BC"  ? ' selected="selected"' : ''?>>BC</option>
	  </select>
	  </div>
	  
	   <!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="ID_TYPE_HIDDEN_ID" name="ID_TYPE_HIDDEN_ID" type="hidden" size="3" 
		value="<?php if (!empty($id_type)) echo $id_type; ?>" />
	  
	  <div class="field">
        <label for="ID_NUM">ID No:</label>
        <input id="disabled" name="ID_NUM" type="text" size="12"
		value="<?php if (!empty($id_num)) echo $id_num; ?>" disabled="true" />
      </div>
	 	
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="ID_NUM_HIDDEN_ID" name="ID_NUM_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($id_num)) echo $id_num; ?>" />
		
		
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
        <label for="CITY">City:</label>
        <input id="CITY" name="CITY" type="text" size="20"  value="<?php if (!empty($city)) echo $city; ?>"
		      onblur="validateNonEmpty(this, document.getElementById('CITY_help'))" />
        <span id="CITY_help" class="help"></span>
      </div>
	  

	  
	  <div class="field">
        <label for="PROVINCE">Province:</label>
		<select id="PROVINCE" name="PROVINCE">
		<option value="WESTERN PROVINCE"      <?php if (!empty($province)) echo $province == "WESTERN PROVINCE"       ? ' selected="selected"' : ''?>>WESTERN PROVINCE</option>
		<option value="CENTRAL PROVINCE"      <?php if (!empty($province)) echo $province == "CENTRAL PROVINCE"       ? ' selected="selected"' : ''?>>CENTRAL PROVINCE</option>
		<option value="NORTH CENTRAL PROVINCE"<?php if (!empty($province)) echo $province == "NORTH CENTRAL PROVINCE" ? ' selected="selected"' : ''?>>NORTH CENTRAL PROVINCE</option>
		<option value="NORTH WESTERN PROVINCE"<?php if (!empty($province)) echo $province == "NORTH WESTERN PROVINCE" ? ' selected="selected"' : ''?>>NORTH WESTERN PROVINCE</option>
		<option value="NORTHERN PROVINCE"     <?php if (!empty($province)) echo $province == "NORTHERN PROVINCE"      ? ' selected="selected"' : ''?>>NORTHERN PROVINCE</option>
		<option value="SABARAGAMUWA PROVINCE" <?php if (!empty($province)) echo $province == "SABARAGAMUWA PROVINCE"  ? ' selected="selected"' : ''?>>SABARAGAMUWA PROVINCE</option>
		<option value="UVA PROVINCE"          <?php if (!empty($province)) echo $province == "UVA PROVINCE"           ? ' selected="selected"' : ''?>>UVA PROVINCE</option>
		<option value="SOUTHERN PROVINCE"     <?php if (!empty($province)) echo $province == "SOUTHERN PROVINCE"      ? ' selected="selected"' : ''?>>SOUTHERN PROVINCE</option>
		<option value="EASTERN PROVINCE"      <?php if (!empty($province)) echo $province == "EASTERN PROVINCE"       ? ' selected="selected"' : ''?>>EASTERN PROVINCE</option>
	  </select>
      </div>
	  
	  

	  
	  	<div class="field">
		<label for="BLOOD_GROUP">Blood Group:</label>
		<select id="BLOOD_GROUP" name="BLOOD_GROUP">
			<option value="A+" <?php if (!empty($blood_group)) echo $blood_group == "A+" ? ' selected="selected"' : ''?>>A+</option>
			<option value="A-" <?php if (!empty($blood_group)) echo $blood_group == "A-" ? ' selected="selected"' : ''?>>A-</option>
			<option value="B+" <?php if (!empty($blood_group)) echo $blood_group == "B+" ? ' selected="selected"' : ''?>>B+</option>
			<option value="B-" <?php if (!empty($blood_group)) echo $blood_group == "B-" ? ' selected="selected"' : ''?>>B-</option>
			<option value="AB+" <?php if (!empty($blood_group)) echo $blood_group == "AB+" ? ' selected="selected"' : ''?>>AB+</option>
			<option value="AB-" <?php if (!empty($blood_group)) echo $blood_group == "AB-" ? ' selected="selected"' : ''?>>AB-</option>
			<option value="O+" <?php if (!empty($blood_group)) echo $blood_group == "O+" ? ' selected="selected"' : ''?>>O+</option>
			<option value="O-" <?php if (!empty($blood_group)) echo $blood_group == "O-" ? ' selected="selected"' : ''?>>O-</option>
		</select>
	</div>
	  

	  </div>
<div class="right">
	  	  <div class="field">
        <label for="OCCUPATION">Occupation:</label>
        <input id="OCCUPATION" name="OCCUPATION" type="text" size="30" value="<?php if (!empty($occupation)) echo $occupation; ?>"
          onblur="validateNonEmpty(this, document.getElementById('OCCUPATION_help'))" />
        <span id="OCCUPATION_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="EMAIL_ADDRESS">Email Address:</label>
        <input id="EMAIL_ADDRESS" name="EMAIL_ADDRESS" type="text" size="30" value="<?php if (!empty($email_address)) echo $email_address; ?>"
           onblur="validateEmail(this, document.getElementById('EMAIL_ADDRESS_help'))" /> 
        <span id="EMAIL_ADDRESS_help" class="help"></span>
      </div>
		  
	  <div class="field">
        <label for="TP_NO">Telephone Number:</label>
        <input id="TP_NO" name="TP_NO" type="text" size="20" value="<?php if (!empty($tp_no)) echo $tp_no; ?>"
		    onblur="validatePhone(this, document.getElementById('TP_NO_help'))" /> 
        <span id="TP_NO_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="MOBILE_NO">Mobile Number:</label>
        <input id="MOBILE_NO" name="MOBILE_NO" type="text" size="20" value="<?php if (!empty($mobile_no)) echo $mobile_no; ?>"
			onblur="validatePhone(this, document.getElementById('MOBILE_NO_help'))" /> 
        <span id="MOBILE_NO_help" class="help"></span>
      </div>
	  

	  
	  <div class="field">
        <label for="STATUS">Status:</label>
	  <select id="disabled" name="STATUS" disabled="true">
		<option value="P" <?php if (!empty($status)) echo $status == "P"  ? ' selected="selected"' : ''?>>PENDING</option>
		<option value="A" <?php if (!empty($status)) echo $status == "A"  ? ' selected="selected"' : ''?>>ACTIVE</option>
	  	<option value="B" <?php if (!empty($status)) echo $status == "B"  ? ' selected="selected"' : ''?>>BLOCKED</option>
	  </select>
	  </div>
	  
	  <!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="STATUS_HIDDEN_ID" name="STATUS_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($status)) echo $status; ?>" />
		
		<div class="field">
			<label for="DONOR">DONOR:</label>
			<input id="DONOR" name="DONOR_FLG" type="checkbox" value="Y" <?php if (!empty($donor_flg) && $donor_flg == 'Y') echo 'checked="checked"'; ?> />
		</div>



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
		
	  	<br/>
		<br/>
		<br/>
		<div class="field">
		<input type="submit" class="sumbit" value="Update User" name="submit" />

		 <a href='index.php'><img id='button_right' src='images/back.png' alt='BACK'/></a>
	 
		 <a href='edit_user_det.php?user_id=<?php echo $user_id;?>'><img id='button_right' src='images/refresh.png' alt='REFRESH'/></a>
		
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