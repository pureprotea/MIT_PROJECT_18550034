<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Register Donor!';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System -  <?php echo $page_title?> </title>
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
  
  $user_id=strtoupper($_SESSION['user_id']);


if(!empty($user_id)){
			 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());

	
$query = "SELECT * FROM blood_management.user_master_tbl where USER_ID='$user_id'";
  									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 

 
 
 //if id no already exists in master table redirect to Host Campaign detail page
 if (mysqli_num_rows($result)==1){
	 
	  while ($row = mysqli_fetch_array($result)){
	  $user_status=$row['DONOR_STATUS'];  
	  }
	}
	
	mysqli_close($dbc);  


	 switch ($user_status) {
    case 'NE':
      $status = "NEW DONOR";
      break;
    // Descending by job title
    case 'EL':
      $status = "ACTIVE";
      break;
    // Ascending by state
    case 'BL':
      $status = "WITHDRAWN";
      break;
    default:
	$status = "N/A";
    }
	
	  }
?>


<div class="leftonly" style="padding-top:6%; width:75%">
	
	<?php 
	if($user_status!='EL'){ ?>
		<form name="activateform" action="donor_registration1.php" method="POST" onsubmit="return confirm('Blood Request Made Sucessfully');">
	<?php } 
	else { ?>
		<form name="blockform" action="donor_withdraw.php" method="POST" onsubmit="return confirm('Do you want to Withdraw Donor Status?');">
	<?php } ?>

		
      <div class="left">
        <label for="USER_ID">USER ID:</label>
        <input id="disabled" name="USER_ID" type="text" size="12" 
		value="<?php if (!empty($user_id)) echo $user_id; ?>"  disabled="true" />
		<br/>
		<br/>
		
			  
	  	<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="USER_HIDDEN_ID" name="USER_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($user_id)) echo $user_id; ?>" />


		<br/>
		<br/>
		<br/>
		<br/>
		
		<tr><td class="label"><label for="picture">User Pic:</label></td>
		<td><img src='<?php echo $mem_im_loc.member_pic($user_id); ?>' alt="User Picture" /></td></tr>
		
		
		<?php 
		if($user_status!='EL'){ ?>
			<input id="USER_ACTIVATE" name="USER_ACTIVATE" type="hidden"
			value="<?php if (!empty($user_id)) echo $user_id; ?>" />
		</div>
			<input type="submit" class="submit" value="Need Blood" name="submit" />
		<!--When Status is Not Equal to Eligible -->
		<?php } 
		else { ?>
			<input id="USER_BLOCK" name="USER_BLOCK" type="hidden"
			value="<?php if (!empty($user_id)) echo $user_id; ?>" />
		</div>
			<input type="submit" class="submit" value="Withdraw" name="submit" />
		<?php } ?>
		
		
		</form>
		
		<div>
			<a href='index.php'><img id='button_right' src='/blood_management/admin/images/back.png' alt='BACK'/></a>
		</div>
		
</div>

<?php

  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>