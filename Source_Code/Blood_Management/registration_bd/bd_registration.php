<?php
  // Start the session if cookie var available assign them to session var
  //require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Institution Registration!';
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
		validateNonEmpty(document.getElementById('NAME'), document.getElementById('NAME_help'));
		validateNonEmpty(document.getElementById('BRANCH'), document.getElementById('BRANCH_help'));
		validateNonEmpty(document.getElementById('ADDRESS1'), document.getElementById('ADDRESS1_help'));
		validateNonEmpty(document.getElementById('ADDRESS2'), document.getElementById('ADDRESS2_help'));
		validateNonEmpty(document.getElementById('CITY'), document.getElementById('CITY_help'));
		validateEmail(document.getElementById('EMAIL_ADDRESS'), document.getElementById('EMAIL_ADDRESS_help'));	
		validatePhone(document.getElementById('CONTACT_NO'), document.getElementById('CONTACT_NO_help'));
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
$name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['NAME'])));
$branch = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['BRANCH'])));
$address1 = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ADDRESS1'])));
$address2 = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ADDRESS2'])));
$city = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['CITY'])));
$province = mysqli_real_escape_string($dbc, trim($_POST['PROVINCE']));
$email_address = mysqli_real_escape_string($dbc, trim($_POST['EMAIL_ADDRESS']));
$contact_no = mysqli_real_escape_string($dbc, trim($_POST['CONTACT_NO']));


//$user=strtoupper(($_SESSION['admin_id']));


//Check Name already exists
$NAME_DUP_query = "SELECT * from blood_depot_master_tbl WHERE name='$name'  and branch='$branch'";
			
									//echo "<DIV CLASS='debug'>$NAME_DUP_query</DIV>";
		
$NAME_DUP_result=mysqli_query($dbc, $NAME_DUP_query);
if (mysqli_num_rows($NAME_DUP_result)==0){


// Check wheteher all mandatory data keyed in
if(!empty($name) && !empty($branch) && !empty($address1) && !empty($address2) && !empty($city) && !empty($province) && !empty($email_address) && !empty($contact_no))
	{
		  require_once('validation.php');
		  
		  //Field Validations- NIC, DATE, PHONE NO, EMAIL
		  if (email_validation($email_address)&& phone_validation($contact_no)){

		 
		 
//insert statements begins here		  
	begin($dbc);
// insert to the blood_depot_master_tbl
$query = "INSERT INTO blood_depot_master_tbl( NAME, BRANCH,  ADDRESS1, ADDRESS2, CITY, PROVINCE, 
			 EMAIL_ADDRESS, CONTACT_NO, R_CRE_TIME, R_CRE_USER_ID, L_CHG_TIME, L_CHG_USER_ID) values (
			'$name' ,'$branch','$address1' ,'$address2' ,'$city' ,'$province' , 
			'$email_address', '$contact_no', now(), 'SYSTEM', now(), 'SYSTEM')";
									//echo "<DIV CLASS='debug'>$query</DIV>";
									
 $result=mysqli_query($dbc, $query);
									//echo "<DIV CLASS='debug'>$result</DIV>";
									

if($result){
	 commit($dbc);
		  //get newly created membership id
$query1 = "SELECT BD_ID from blood_depot_master_tbl WHERE name='$name' and branch='$branch' and status='P'";
									//echo "<DIV CLASS='debug'>$query1</DIV>";
									
 $result1=mysqli_query($dbc, $query1);
  while ($row = mysqli_fetch_array($result1)){
	  $user_id=$row['BD_ID'];  
	  }
	  								//echo "<DIV CLASS='debug'>$user_id</DIV>";					

	  
//Write into Login Table
if (!empty($user_id)){
				//transaction is complete here. so load sucess page.
		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  "/add_bd_sucess.php?user_id=" . $user_id;
          header('Location: ' . $url);
		  			}
						
		}
		//when User ID is not Returned
		else {
				rollback($dbc);
				$err_msg='FATAL ERROR:- User Not Added Sucessfully.';
			}					
				
			
			
}
	//Sever Validations Fails; When all the mandatory fields are not keyed in
else {
            $err_msg='Please Key in all the Mandatary Values';
			   }
			   
}
	//JavaScript Validation Fails when Date,Phone No, Email validations fails
	else{
		 $err_msg='Form Validation Failed';
	}
		
  	}
	    //Duplicate Name
		else {	
			while ($row = mysqli_fetch_array($NAME_DUP_result)){
			$valid_user_id=$row['BD_ID'];       }
			$err_msg="NAME Already Exists with USER id - $valid_user_id";	
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
        <label for="CONTACT_NO">Telephone Number:</label>
        <input id="CONTACT_NO" name="CONTACT_NO" type="text" size="20" value="<?php echo (!empty($mobile_no)) ? $mobile_no:'011-2XXXXXX'; ?>"
		    onblur="validatePhone(this, document.getElementById('CONTACT_NO_help'))" /> 
        <span id="CONTACT_NO_help" class="help"></span>
      </div>
	  

	 
	  
	  
	  <div class="button" style="width: 150%;">
		<input type="submit" class="sumbit" value="Add Blood Depot" name="submit" />
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