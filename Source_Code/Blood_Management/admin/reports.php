<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Reports';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <link rel="stylesheet" href="/lib/w3.css">
   <script type="text/javascript" src="validation.js"></script>
   
 <style>
      /* CSS for body background image */
      div.body {
         background-image: url("body1.jpg");
      }
   </style>
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
  
  
 
?>

  	<div class="left" style="margin-top: 40px;">
	<form method="get" action="rep_active_users.php">
		<div class="search">
			<input type="submit" name="submit" value="All Users Report" /></br>
		</div>
	</form>
		
	<form method="get" action="rep_active_blood_depots">
		<div class="search">
			<input type="submit" name="submit" value="All Blood Depot Report" /></br>
		</div>
	</form>
  
	<form method="get" action="req_pending.php">
		<div class="search">
			<input type="submit" name="submit" value="Pending Not FulFilled Requests" /></br>
		</div>
	</form>
  
	<form method="get" action="rep_eligible_donor.php">
		<div class="search">
			<input type="submit" name="submit" value="Eligible Donors List" /></br>
		</div>
	</form>
	



	</div>
	
	<div class="right" style="margin-top: 40px;">
	
	<form method="get" action="rep_active_campaigns">
		<div class="search">
			<input type="submit" name="submit" value="Active Campaigns Report" /></br>
		</div>
	</form>
	
	<form method="get" action="rep_donation_match_completed.php">
		<div class="search">
			<input type="submit" name="submit" value="Donation Match Completed Report" /></br>
		</div>
	</form>
	
	<form method="get" action="rep_transaction.php">
		<div class="search">
			<input type="submit" name="submit" value="Transaction Report" /></br>
		</div>
	</form>

	<form method="get" action="rep_reward_redemption.php">
		<div class="search">
			<input type="submit" name="submit" value="Reward Points Redemptions" /></br>
		</div>
	</form>


	
	</div>
	
	  
<?php
  // Insert the page footer
  require_once('footer.php');
?>