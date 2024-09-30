<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'User Status Change!';
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
  
      if (!empty($_GET['user_id'])) {
		$user_id =  $_GET['user_id'];
		$user_status =  $_GET['status'];
	  

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
      $status = "BLOCKED";
      break;
    default:
	$status = "N/A";
    }
	
	  }
?>


<div class="leftonly" style="padding-top:6%; width:75%">
	
	<?php 
	if($user_status!='EL'){ ?>
		<form name="activateform" action="user_activate.php?user_id=<?php echo $user_id;?>" method="POST" onsubmit="return confirm('Do you want to Activate the User?');">
	<?php } 
	else { ?>
		<form name="blockform" action="user_block.php" method="POST" onsubmit="return confirm('Do you want to Block the User?');">
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

		
		<label for="STATUS">Status:</label>
        <input id="disabled" name="Status" type="text" size="12" 
		value="<?php if (!empty($user_status)) echo $status; ?>"  disabled="true" />
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
			<input type="submit" class="sumbit" value="ACTIVATE" name="submit" />
		<!--When Status is Not Equal to Eligible -->
		<?php } 
		else { ?>
			<input id="USER_BLOCK" name="USER_BLOCK" type="hidden"
			value="<?php if (!empty($user_id)) echo $user_id; ?>" />
		</div>
			<input type="submit" class="sumbit" value="BLOCK" name="submit" />
		<?php } ?>
		
		
		</form>
		
		<div>
			<a href='user_status.php'><img id='button_right' src='/blood_management/admin/images/back.png' alt='BACK'/></a>
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