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
<title>Web Based Blood Management System -<?php echo $page_title?> </title>
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
  
    $user_id=strtoupper($_SESSION['admin_id']);

  
      if (!empty($_GET['don_id'])) {
		$don_id =  $_GET['don_id'];
		$bd_id =  $_GET['bd_id'];

	  }
?>


<div class="leftonly" style="padding-top:6%; width:75%">
	
	<form name="activateform" action="accept_blood_completion.php" method="POST" onsubmit="return confirm('Do you want to complete the Blood Donation Process?');">
		
      <div class="left">
        <label for="DON_ID">Donation ID:</label>
        <input id="disabled" name="DON_ID" type="text" size="12" 
		value="<?php if (!empty($don_id)) echo $don_id; ?>"  disabled="true" />
		<br/>
		<br/>
		
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="DON_HIDDEN_ID" name="DON_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($don_id)) echo $don_id; ?>" />
		
		
		<label for="COLL_BD">Collection BD:</label>
        <input id="COLL_BD" name="COLL_BD" type="text" size="12" 
		value="<?php if (!empty($bd_id)) echo $bd_id; ?>"/>
		<br/>
		<br/>
		<br/>
		<br/>
				

		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="BD_AGREE" name="BD_AGREE" type="hidden"
		value="<?php if (!empty($don_id)) echo $don_id; ?>" />
	  </div>
		
		<input type="submit" class="submit" value="ACCEPT" name="submit" />
			
	 </form>
		
		

	<form name="blockform" action="accept_blood_cancellation.php" method="POST" onsubmit="return confirm('Do you want to cancel the Donation Request?');">
	  <div class="left">
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="BD_CANCEL" name="BD_CANCEL" type="hidden"
		value="<?php if (!empty($don_id)) echo $don_id; ?>" />
		</div>
		
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="DON_HIDDEN_ID" name="DON_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($don_id)) echo $don_id; ?>" />
		
		
	  <input type="submit" class="submit" value="REJECT" name="submit" />
		
	</form>
	

	<div>
		<a href='accept_blood.php'><img id='button_right' src='images/back.png' alt='BACK'/></a>
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