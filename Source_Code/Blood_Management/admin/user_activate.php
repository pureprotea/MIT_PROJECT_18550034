<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Donor Activation!';
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
		validateDate(document.getElementById('MC_EXP_DATE'), document.getElementById('MC_EXP_DATE_help'));
		validateDate(document.getElementById('L_DON_DATE'), document.getElementById('L_DON_DATE_help'));
		validateNonEmpty(document.getElementById('MC'), document.getElementById('MC_help'));

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
	

    if (!empty($_GET['user_id'])) {
		$user_id =  $_GET['user_id'];
		  		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$user=strtoupper(($_SESSION['admin_id']));
		
		$query = "SELECT * FROM user_master_tbl WHERE USER_ID='$user_id'";
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 if (mysqli_num_rows($result)==1){
	 
$row=mysqli_fetch_array($result);
$user_id=$row['USER_ID'];
$title = $row['TITLE'];
$first_name = $row['FIRST_NAME'];
$last_name = $row['LAST_NAME'];
$id_type = $row['ID_TYPE'];
$id_num = $row['ID_NUM'];
$dob = $row['DOB'];
$status = $row['DONOR_STATUS'];
$email_address = $row['EMAIL_ADDRESS'];
$mobile_no = $row['MOBILE_NO'];
$l_chg_time = $row['L_CHG_TIME'];
$l_chg_user_id = $row['L_CHG_USER_ID'];
					
										}
	//if invalid id no keyed in through url redirects to user_status.php
	else{
	 	 $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/user_status.php';
          header('Location: ' . $url);
		}
		
		mysqli_close($dbc);
	  }
	 
    if (isset($_POST['USER_HIDDEN_ID2'])) {
		 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
			

			
// Grab the POST data
$user_id = mysqli_real_escape_string($dbc, trim($_POST['USER_HIDDEN_ID2']));
$mc_exp_date = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['MC_EXP_DATE'])));
$l_don_date = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['L_DON_DATE'])));
$mc = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['MC'])));

$title = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ID_TITLE_HIDDEN_ID'])));
$id_type = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ID_TYPE_HIDDEN_ID'])));

$l_chg_time = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_TIME_HIDDEN_ID']));
$l_chg_user_id = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_USER_ID_HIDDEN_ID']));



$first_name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['FIRST_NAME'])));
$last_name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['LAST_NAME'])));
$id_num = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ID_NUM'])));
$dob = mysqli_real_escape_string($dbc, trim($_POST['DOB']));
$status = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['STATUS'])));
$email_address = mysqli_real_escape_string($dbc, trim($_POST['EMAIL_ADDRESS']));
$mobile_no = mysqli_real_escape_string($dbc, trim($_POST['MOBILE_NO']));

$user=strtoupper($_SESSION['admin_id']);

// Check wheteher all mandatory data keyed in
if(!empty($mc_exp_date) && !empty($l_don_date)&& !empty($mc))
{

	begin($dbc);
	// Update to the user_master_tbl
	$query = "update blood_management.user_master_tbl set DONOR_FLG='Y', DONOR_STATUS='EL', L_CHG_USER_ID='$user'
				where USER_ID='$user_id'";
	
										//echo "<DIV CLASS='debug'>$query</DIV>";
 $result=mysqli_query($dbc, $query);
									//echo "<DIV CLASS='debug'>$result</DIV>";


	// Update to the donor_tbl
	$query1 = "update blood_management.donor_tbl set REGISTRATION_DATE=sysdate(),LAST_DONATION_DATE='$l_don_date', MEDICAL_CERTIFICATE_FILE_NAME='$mc',
				MEDICAL_CERTIFICATE_EXP_DATE='$mc_exp_date',L_CHG_USER_ID='$user'
				where DONOR_ID='$user_id'";
	
										//echo "<DIV CLASS='debug'>$query</DIV>";
 $result1=mysqli_query($dbc, $query1);
									//echo "<DIV CLASS='debug'>$result</DIV>";
									

	
if ($result && $result1) {
    commit($dbc);
	$msg = 'User ' . $user_id . ' has been successfully Registered as a donor.';
    echo '<script>';
    echo 'alert("' . $msg . '");'; // Display an alert box with the success message
    echo 'window.location.href = "http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/user_status.php";'; 
    echo '</script>';
    exit; // exit the script after redirection
	}
	else {
    rollback($dbc);
	$err_msg = 'Oops! Something went wrong while trying to Register user ' . $user_id . ' as a donor. Please try again later or contact support for assistance.';
}
	mysqli_close($dbc);  
	
}
else {
            $err_msg='Validation Failed';
			   }
			   
		mysqli_close($dbc);  
	}
		

?>

      <form name="user_activateform"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	      
	<div class="left">

      <div class="field">
        <label for="USER_ID">User ID:</label>
        <input id="USER_ID" name="USER_ID" type="text" size="12" 
		value="<?php if (!empty($user_id)) echo $user_id; ?>"  readonly="readonly" />
      </div>
	  
	  	<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="USER_HIDDEN_ID2" name="USER_HIDDEN_ID2" type="hidden" size="12" 
		value="<?php if (!empty($user_id)) echo $user_id; ?>" />

	  <div class="field">
        <label for="TITLE">Title:</label>
	  <select id="TITLE" name="TITLE" disabled="true" >
		<option value="MR."  <?php if (!empty($title)) echo $title == "MR."   ? ' selected="selected"' : ''?>>MR.</option>
		<option value="MRS." <?php if (!empty($title)) echo $title == "MRS."  ? ' selected="selected"' : ''?>>MRS.</option>
		<option value="MS."  <?php if (!empty($title)) echo $title == "MS."   ? ' selected="selected"' : ''?>>MS.</option>
		<option value="MAST."<?php if (!empty($title)) echo $title == "MAST." ? ' selected="selected"' : ''?>>MAST.</option>
		<option value="MISS."<?php if (!empty($title)) echo $title == "MISS." ? ' selected="selected"' : ''?>>MISS.</option>
		<option value="DR."  <?php if (!empty($title)) echo $title == "DR."   ? ' selected="selected"' : ''?>>DR.</option>
		<option value="REV." <?php if (!empty($title)) echo $title == "REV."  ? ' selected="selected"' : ''?>>REV.</option>
	  </select>
	  </div>
	  
	  
	  
	   <!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="ID_TITLE_HIDDEN_ID" name="ID_TITLE_HIDDEN_ID" type="hidden" size="3" 
		value="<?php if (!empty($title)) echo $title; ?>" />
	
      <div class="field">
        <label for="FIRST_NAME">First Name:</label>
        <input id="FIRST_NAME" name="FIRST_NAME" type="text" size="30" value="<?php if (!empty($first_name)) echo $first_name; ?>"
			readonly="readonly"/>
      </div>
	  
	  <div class="field">
        <label for="LAST_NAME">Last Name:</label>
        <input id="LAST_NAME" name="LAST_NAME" type="text" size="30" value="<?php if (!empty($last_name)) echo $last_name; ?>"
			readonly="readonly" />

      </div>
	  
	  
	  <div class="field">
        <label for="DOB">DOB:</label>
        <input id="DOB" name="DOB" type="date" size="10" value="<?php if (!empty($dob)) echo $dob; ?>"
           readonly="readonly" />
      </div>
	  
	  
	  
	  <div class="field">
        <label for="ID_TYPE">ID Type:</label>
	  <select id="ID_TYPE" name="ID_TYPE" disabled="true">
		<option value="NIC"<?php if (!empty($id_type)) echo $id_type == "NIC" ? ' selected="selected"' : ''?>>NIC</option>
		<option value="BC" <?php if (!empty($id_type)) echo $id_type == "BC"  ? ' selected="selected"' : ''?>>BC</option>
	  </select>
	  </div>
	  
	  	<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="ID_TYPE_HIDDEN_ID" name="ID_TYPE_HIDDEN_ID" type="hidden" size="3" 
		value="<?php if (!empty($id_type)) echo $id_type; ?>" />
	  
	  
	  
	  <div class="field">
        <label for="ID_NUM">ID No:</label>
        <input id="ID_NUM" name="ID_NUM" type="text" size="12"
		value="<?php if (!empty($id_num)) echo $id_num; ?>"  readonly="readonly" />
      </div>
	 	

	  <div class="field">
        <label for="EMAIL_ADDRESS">Email Address:</label>
        <input id="EMAIL_ADDRESS" name="EMAIL_ADDRESS" type="text" size="30" value="<?php if (!empty($email_address)) echo $email_address; ?>"
            readonly="readonly" /> 

      </div>
	  
	  <div class="field">
        <label for="MOBILE_NO">Mobile Number:</label>
        <input id="MOBILE_NO" name="MOBILE_NO" type="text" size="20" value="<?php if (!empty($mobile_no)) echo $mobile_no; ?>"
			 readonly="readonly" />

      </div>
	  	  </div>
		  
		  	<div class="right">
	  <div class="field">
        <label for="STATUS"  >Status:</label>
        <input id="red" name="STATUS" type="text" size="12" value="<?php if (!empty($status)) echo $status; ?>"
		 readonly="readonly" />

      </div>
	  

	  
	  
	  <div class="field">
        <label for="L_DON_DATE">Last Donation:</label>
        <input id="L_DON_DATE" name="L_DON_DATE" type="date" size="12" value="<?php if (!empty($l_don_date)) echo $l_don_date; ?>"
          onblur="validateDate(this, document.getElementById('L_DON_DATE_help'))" />
        <span id="L_DON_DATE_help" class="help"></span>
      </div>
	  
	<div class="field">
    <label for="PICTURE">Medical Certificate</label>
    <input type="file" id="MC" name="MC" />
	        <span id="MC_help" class="help"></span>
	</div>
	
	 <div class="field">
        <label for="MC_EXP_DATE">MC Exp Date:</label>
        <input id="MC_EXP_DATE" name="MC_EXP_DATE" type="date" size="12" value="<?php if (!empty($mc_exp_date)) echo $mc_exp_date; ?>"
          onblur="validateDate(this, document.getElementById('L_DON_DATE_help'))" />
        <span id="MC_EXP_DATE_help" class="help"></span>
      </div>
	  
		
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
	  </div>
	  
		<div class="field">
		<input type="submit" class="submit" value="Activate as Donor" name="submit" />

	 		
	  </div>
    </form>
		 <p class="sucess" ><?php if (!empty($err_msg)) echo $err_msg; ?></p>
	
		 			<a href='user_status_det.php?user_id=<?php echo $user_id;?>&status=<?php echo $status;?>'><img id='button_right' src='images/back.png' alt='BACK'/></a>

		 
<?php

  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>