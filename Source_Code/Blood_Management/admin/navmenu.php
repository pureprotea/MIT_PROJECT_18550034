<?php
  // Generate the navigation menu
  //echo '<hr />';
   if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
	   
		
		echo '<a href="index.php"><img id="nav_icon_left" src="/blood_management/admin/images/home.png"  
		alt="Home"></a>';
		
		/* inline css moved to main.css with img id - nav_icon_left
		echo '<a href="index.php"><img src="/blood_management/admin/images/home.png"  
		style="width:46.5px;float: left; background-color:#444444;padding-left:30px; padding-right:30px;" 
		alt="Home""></a>';*/
		
		echo '<a href="logout.php"><img id="nav_icon_right" src="/blood_management/admin/images/logout.png"  
		alt="LogOut"></a>';
		
		/* inline css moved to main.css with img id - nav_ico_right
				echo '<a href="logout.php"><img src="/blood_management/admin/images/logout.png"  
		style="width:46.5px;float: right; background-color:#444444;padding-left:30px; padding-right:30px;" 
		alt="LogOut""></a>'; 
		
				echo '<li><a href="add_member_sucess.php?id_num=802234987V&id_type=NIC">Activate/Block Member</a></li> ';
				echo '<li><a href="add_book_sucess.php?isbn=9789553101433&limit=2">Edit Books</a></li> ';
		*/
if ($_SESSION['role']=='ADMIN'){
		echo '<ul><li><a href="bd_status_update.php">Depot Status Update</a></li> ';
		echo '<li><a href="edit_bd_user.php">Edit Depot</a></li> ';
		echo '<li><a href="host_campaign.php">Host Campaign</a></li> ';
		echo '<li><a href="edit_Campaign.php">Edit Campaigns</a></li> ';
		echo '<li><a href="accept_blood.php">Accept Donation</a></li>';
		echo '<li><a href="user_status.php">Change User Status</a></li> ';
		echo '<li><a href="edit_user.php">Edit User</a></li> ';

		echo '<li><a href="reports.php">View Reports</a></li>';
		echo '<li style="float: right;background-color: #000000;" ><a style="">Logged in as (' . $_SESSION['admin_id'] . ')</a></li></ul>';

       }
  	   
	  else if ($_SESSION['role']=='SUPERADMIN'){
		echo '<ul><li><a href="index.php">Home</a></li>';
		echo '<li><a href="viewprofile.php">Add admins</a> </li>';
		echo '<li><a href="editprofile.php">Edit ADMIN Users</a></li>';
		echo '<li><a href="questionnaire.php">Password Reset</a> </li> ';
		echo '<li><a href="mymismatch.php">Configurations</a> </li>';
		echo '<li style="float: right;background-color: #000000;" ><a style="">Logged in as (' . $_SESSION['admin_id'] . ')</a></li></ul>';
	   }
	   
		else {
		     echo '<p>Invalid Role. Unable to Login! Please contact system Administrator</p>';
			 exit();
		}
   }
  else {
	      $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/blood_management/admin/login.php';
          header('Location: ' . $home_url);
		  
  }
  echo '<hr />';
?>
