<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Donate Blood!';
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
  
      if (!empty($_GET['don_id'])) {
		$don_id =  $_GET['don_id'];
		$status =  $_GET['status'];
	
	switch ($status) {
    case 'P':
      $status = "PENDING";
      break;
    case 'A':
      $status = "AGREED";
      break;
    case 'C':
      $status = "CANCELLED";
	  
	case 'Y':
      $status = "COMPLETED";
      break;
	  
	case 'R':
      $status = "REJECTED";
      break;  
	
	case 'E':
      $status = "EXPIRED";
      break;  
	    
    default:
	$status = "N/A";
	
	  }
	  }
?>


<div class="leftonly" style="padding-top:6%; width:75%">
	
	<form name="activateform" action="donate_blood_completion.php" method="POST" onsubmit="return confirm('Do you want to complete the Blood Donation Process?');">
		
      <div class="left">
        <label for="DON_ID">Donation ID:</label>
        <input id="disabled" name="DON_ID" type="text" size="12" 
		value="<?php if (!empty($don_id)) echo $don_id; ?>"  disabled="true" />
		<br/>
		<br/>
		
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="DON_HIDDEN_ID" name="DON_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($don_id)) echo $don_id; ?>" />
		
		
		<label for="STATUS">Status:</label>
        <input id="disabled" name="Status" type="text" size="12" 
		value="<?php if (!empty($status)) echo $status; ?>"  disabled="true" />
		<br/>
		<br/>
		<br/>
		<br/>
				

		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="BD_AGREE" name="BD_AGREE" type="hidden"
		value="<?php if (!empty($don_id)) echo $don_id; ?>" />
	  </div>
		
		<input type="submit" class="submit" value="AGREE" name="submit" />
			
	 </form>
		
		

	<form name="blockform" action="donate_blood_cancellation.php" method="POST" onsubmit="return confirm('Do you want to cancel the Donation Request?');">
	  <div class="left">
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="BD_CANCEL" name="BD_CANCEL" type="hidden"
		value="<?php if (!empty($don_id)) echo $don_id; ?>" />
		</div>
		
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="DON_HIDDEN_ID" name="DON_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($don_id)) echo $don_id; ?>" />
		
		
	  <input type="submit" class="submit" value="CANCEL" name="submit" />
		
	</form>
	

	<div>
		<a href='donate_blood.php'><img id='button_right' src='images/back.png' alt='BACK'/></a>
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