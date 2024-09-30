<?php
  // Generate the navigation menu
  //echo '<hr />';
   if (isset($_SESSION['user_id'])) {
	echo '<a href="index.php"><img id="nav_icon_left" src="/blood_management/user/images/home.jpg"  
		alt="Home""></a>';
		
		/* inline css moved to main.css with img id - nav_icon_left
		echo '<a href="index.php"><img src="/kot_lib/librarian/images/home.png"  
		style="width:46.5px;float: left; background-color:#444444;padding-left:30px; padding-right:30px;" 
		alt="Home""></a>';*/
		
	echo '<a href="logout.php"><img id="nav_icon_right" src="/blood_management/user/images/logout.jpg"  
		alt="LogOut""></a>';
		
	
		echo '<ul><li><a href="register_donor.php">Donor Registration</a></li> ';
		echo '<li><a href="active_campaigns.php">Active Campaigns</a></li> ';
				echo '<li><a href="req_pending.php">Pending Requests</a></li> ';

		echo '<li><a href="donate_blood.php">Donate Blood</a></li>';
		echo '<li><a href="request_blood.php">Need Blood</a></li>';


		echo '<li><a href="donation_history.php?user_id='. $_SESSION['user_id'].'">Donation History</a></li> ';
		echo '<li><a href="request_history.php?user_id='. $_SESSION['user_id'].'">Request History</a></li> ';

				echo '<li><a href="reward.php?user_id='. $_SESSION['user_id'].'">Reward Points</a></li>';




	
	echo '<li style="float: right;background-color: #000000;" ><a style="">Logged in as (' . $_SESSION['user_id'] . ')</a></li>';
							echo '<li style="float: right;"><a href="edit_user_det.php">Edit Details</a></li></ul>';


	
  }
  else {
	      $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/blood_management/user/login.php';
          header('Location: ' . $home_url);
  }
  echo '<hr />';
?>
