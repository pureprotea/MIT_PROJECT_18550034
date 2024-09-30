<?php
  // Start the session if cookie var available assign them to session var
 //equire_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Institution Registration! Sucess!';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <link rel="stylesheet" href="/lib/w3.css">
   <script type="text/javascript" src="validation.js"></script>
</head>
<body>

  <?php
  require_once('heading.php');
  
  //require_once('appvars.php');
  require_once('db_con_vars.php');

  // Show the navigation menu
  //quire_once('navmenu.php');
  
  // Show body common content
  require_once('body.php');
  
    if (isset($_GET['user_id'])) {
    // Grab the data from the GET
    $user_id = $_GET['user_id'];
  
 

      // Connect to the database
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());


      $query = "select bd_id,name,branch,address1,address2, city,province,email_address,contact_no,r_cre_time,r_cre_user_id FROM blood_depot_master_tbl WHERE bd_id = '$user_id'
				and status='P' LIMIT 1";
      							
								//echo "<DIV class='debug'>$query</DIV>";
					
	$result = mysqli_query($dbc, $query);
	
	while ($row = mysqli_fetch_array($result)) {
		 $user_id=$row['bd_id'];
		 $name=$row['name'];
		 $branch=$row['branch'];
		 $address1=$row['address1'];
		 $address2=$row['address2'];
		 $city=$row['city'];	
		 $province=$row['province'];	
		 $email_address=$row['email_address'];	
		 $contact_no=$row['contact_no'];	
		 $r_cre_time=$row['r_cre_time'];
		 $r_cre_user_id=$row['r_cre_user_id'];
		
	
            // Confirm success with the user
			echo "<h3>Member Registration Sucess</h3>";
            echo '<p><strong>USER_ID</strong> ' . $user_id . '</p>';
            echo '<strong>Name:</strong> ' . $name . '<br />';
            echo '<strong>Branch:</strong> ' . $branch . '<br />';
            echo '<strong>Email_Address:</strong> ' . $email_address . '<br />';
			echo '<strong>Address1</strong> ' . $address1 . '<br />';
			echo '<strong>Address2</strong> ' . $address2 . '<br />';
            echo '<strong>City:</strong> ' . $city . '<br />';
            echo '<strong>Province:</strong> ' . $province . '<br />';
			if(!empty($contact_no)){echo '<strong>Contact No:</strong> ' . $contact_no . '<br />';}
            echo '<strong>Record Created Time:</strong> ' . $r_cre_time . '<br />';
			echo '<strong>Record Created User_Id:</strong> ' . $r_cre_user_id . '<br />';
			
			
			      // Confirm success with the user
      echo '<h3 style="text-align:center">User Ref No - ' . $user_id . ' for ' . $name .' :-'. $branch .' was successfully Added.</h3>';
	 }
	  
      mysqli_close($dbc);
    //is set get close bracket 	  
	}
	
				echo '<p><a href="../Index.php">&lt;&lt; Back to Login</a></p>';
  // Insert the page footer
  require_once('footer.php');
?>