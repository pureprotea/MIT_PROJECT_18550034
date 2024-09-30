<?php
  // Generate the navigation menu
  //echo '<hr />';
   if (isset($_SESSION['bd_id'])) {
	echo '<a href="index.php"><img id="nav_icon_left" src="/blood_management/blood_depot/images/home.jpg"  
		alt="Home""></a>';
		
		/* inline css moved to main.css with img id - nav_icon_left
		echo '<a href="index.php"><img src="/kot_lib/librarian/images/home.png"  
		style="width:46.5px;float: left; background-color:#444444;padding-left:30px; padding-right:30px;" 
		alt="Home""></a>';*/
		
	echo '<a href="logout.php"><img id="nav_icon_right" src="/blood_management/blood_depot/images/logout.jpg"  
		alt="LogOut""></a>';
		
	
		echo '<ul><li><a href="host_campaign_det.php">Host Blood Drive</a></li> ';
		echo '<li><a href="edit_campaign.php">Edit Campaigns</a></li> ';
		echo '<li><a href="accept_blood.php">Accept Donation</a></li>';

		echo '<li><a href="active_campaigns.php">Active Campaigns</a></li> ';
		echo '<li><a href="other_active_campaigns.php">Other Active Campaigns</a></li> ';
		
		echo '<li><a href="donation_history.php?bd_id='. $_SESSION['bd_id'].'">Accept History</a></li> ';





	
	echo '<li style="float: right;background-color: #000000;" ><a style="">Logged in as (' . $_SESSION['bd_id'] . ')</a></li>';
					echo '<li style="float: right;"><a href="edit_bd_user_det.php">Edit Details</a></li></ul>';


	
  }
  else {
	      $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/blood_management/blood_depot/login.php';
          header('Location: ' . $home_url);
  }
  echo '<hr />';
?>
