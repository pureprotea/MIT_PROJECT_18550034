<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'BD User Modification!';
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
		validateNonEmpty(document.getElementById('NAME'), document.getElementById('NAME_help'));
				validateNonEmpty(document.getElementById('BRANCH'), document.getElementById('BRANCH_help'));

		validateNonEmpty(document.getElementById('ADDRESS1'), document.getElementById('ADDRESS1_help'));
		validateNonEmpty(document.getElementById('ADDRESS2'), document.getElementById('ADDRESS2_help'));
		validateNonEmpty(document.getElementById('CITY'), document.getElementById('CITY_help'));
		validateEmail(document.getElementById('EMAIL_ADDRESS'), document.getElementById('EMAIL_ADDRESS_help'));	
		validatePhone(document.getElementById('CONTACT_NO'), document.getElementById('CONTACT_NO_help'));
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
  
      $bd_id=strtoupper($_SESSION['bd_id']);

  
      if (!empty($bd_id)) {
		
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$query = "SELECT * FROM blood_depot_master_tbl WHERE BD_ID='$bd_id'";
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 if (mysqli_num_rows($result)==1){
	 
 while($row=mysqli_fetch_array($result)){
$bd_id=$row['BD_ID'];
$name = $row['NAME'];
$branch = $row['BRANCH'];
$address1 = $row['ADDRESS1'];
$address2 = $row['ADDRESS2'];
$city = $row['CITY'];
$province = $row['PROVINCE'];
$email_address = $row['EMAIL_ADDRESS'];
$contact_no = $row['CONTACT_NO'];
$r_cre_time = $row['R_CRE_TIME'];
$r_cre_user_id = $row['R_CRE_USER_ID'];
$l_chg_time = $row['L_CHG_TIME'];
$l_chg_user_id = $row['L_CHG_USER_ID'];

										}
										
	}
  //if invalid membership id keyed in through url redirects to edit_member.php
	else{
	 	 $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/edit_member.php';
          header('Location: ' . $url);
		}
		
		mysqli_close($dbc);
	  }
  
    if (isset($_POST['submit'])) {
		 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
			
// Grab the POST data
$bd_id = mysqli_real_escape_string($dbc, trim($_POST['USER_HIDDEN_ID']));
$status = mysqli_real_escape_string($dbc, trim($_POST['STATUS_HIDDEN_ID']));
$r_cre_time = mysqli_real_escape_string($dbc, trim($_POST['R_CRE_TIME_HIDDEN_ID']));
$r_cre_user_id = mysqli_real_escape_string($dbc, trim($_POST['R_CRE_USER_ID_HIDDEN_ID']));
$l_chg_time = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_TIME_HIDDEN_ID']));
$l_chg_user_id = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_USER_ID_HIDDEN_ID']));

//if checked POST variable is not empty, Thus Value will be set to Y else N
if (!empty($_POST['DONOR_FLG'])){
$donor_flg=mysqli_real_escape_string($dbc, trim($_POST['DONOR_FLG']));
}
else{
$donor_flg="N";
}


$name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['NAME'])));
$branch = mysqli_real_escape_string($dbc, trim($_POST['BRANCH']));
$address1 = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ADDRESS1'])));
$address2 = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ADDRESS2'])));
$city = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['CITY'])));
$province = mysqli_real_escape_string($dbc, trim($_POST['PROVINCE']));
$email_address = mysqli_real_escape_string($dbc, trim($_POST['EMAIL_ADDRESS']));
$contact_no = mysqli_real_escape_string($dbc, trim($_POST['CONTACT_NO']));

$user=strtoupper(($_SESSION['bd_id']));


// Check wheteher all mandatory data keyed in
if(!empty($bd_id)  && !empty($name)    &&
	!empty($address1) && !empty($address2) && !empty($city) && !empty($province)  && 
	 !empty($email_address) && !empty($contact_no)&& !empty($user))
{
		 //Field Validations- NIC, DATE, PHONE NO, EMAIL
		  require_once('validation.php');
			  if (email_validation($email_address)&& phone_validation($contact_no)){
		
begin($dbc);
// update database
$query = "update blood_depot_master_tbl set  NAME='$name', 
			 BRANCH='$branch', ADDRESS1='$address1',ADDRESS2='$address2', CITY='$city', 
			 PROVINCE='$province', 
			 EMAIL_ADDRESS='$email_address', CONTACT_NO='$contact_no', L_CHG_TIME=now(), L_CHG_USER_ID='$user'
			 where BD_ID='$bd_id'";
			
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
        <label for="BD_ID">Blood Depot ID:</label>
        <input id="disabled" name="BD_ID" type="text" size="12" 
		value="<?php if (!empty($bd_id)) echo $bd_id; ?>"  disabled="true" />
      </div>
	  
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="USER_HIDDEN_ID" name="USER_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($bd_id)) echo $bd_id; ?>" />


	
      <div class="field">
        <label for="NAME">Name:</label>
        <input id="NAME" name="NAME" type="text" size="30" value="<?php if (!empty($name)) echo $name; ?>"
          onblur="validateNonEmpty(this, document.getElementById('NAME_help'))" />
        <span id="NAME_help" class="help"></span>
      </div>
	  
	  
	        <div class="field">
        <label for="BRANCH">Branch:</label>
        <input id="BRANCH" name="BRANCH" type="text" size="30" value="<?php if (!empty($branch)) echo $branch; ?>"
          onblur="validateNonEmpty(this, document.getElementById('BRANCH_help'))" />
        <span id="BRANCH_help" class="help"></span>
      </div>
	  

		
		
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
	  
	  
	  </div>

	   <div class="right">
	  <div class="field">
        <label for="EMAIL_ADDRESS">Email Address:</label>
        <input id="EMAIL_ADDRESS" name="EMAIL_ADDRESS" type="text" size="30" value="<?php if (!empty($email_address)) echo $email_address; ?>"
           onblur="validateEmail(this, document.getElementById('EMAIL_ADDRESS_help'))" /> 
        <span id="EMAIL_ADDRESS_help" class="help"></span>
      </div>
		  
	  <div class="field">
        <label for="CONTACT_NO">Contact Number:</label>
        <input id="CONTACT_NO" name="CONTACT_NO" type="text" size="20" value="<?php if (!empty($contact_no)) echo $contact_no; ?>"
		    onblur="validatePhone(this, document.getElementById('CONTACT_NO_help'))" /> 
        <span id="CONTACT_NO_help" class="help"></span>
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
	  	<br/>
		<br/>
		<br/>
		<div class="field">
		<input type="submit" class="submit" value="Update BD User" name="submit" />
		
		  <a href='edit_bd_user.php'><img id='button_right' src='/blood_management/admin/images/back.png' alt='BACK'/></a>
		  <a href='edit_bd_user_det.php?bd_id=<?php echo $bd_id;?>'><img id='button_right' src='/blood_management/admin/images/refresh.png' alt='REFRESH'/></a>
		
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