<?php
  // Start the session if cookie var available assign them to session var
 //equire_once('startsession.php');

  // Set Title for the Page
  $page_title = 'User Registration Sucess!';
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
  
    if (isset($_GET['id_num'])&& isset($_GET['id_type'])) {
    // Grab the data from the GET
    $id_num = $_GET['id_num'];
	    $id_type = $_GET['id_type'];
  
 

      // Connect to the database
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());


      $query = "select user_id,title,first_name,last_name,id_type,id_num,dob,address1,address2, 
	  city,province,occupation,email_address,tp_no,mobile_no,r_cre_time,r_cre_user_id
	  FROM user_master_tbl WHERE id_num = '$id_num'
				and id_type='$id_type' and del_flg='N' LIMIT 1";
      							
								//echo "<DIV class='debug'>$query</DIV>";
					
	$result = mysqli_query($dbc, $query);
	
	while ($row = mysqli_fetch_array($result)) {
		 $user_id=$row['user_id'];
		 $title=$row['title'];
		 $first_name=$row['first_name'];
		 $last_name=$row['last_name'];
		 $id_type=$row['id_type'];
		 $id_num=$row['id_num'];
		 $dob=$row['dob'];			
		 $address1=$row['address1'];
		 $address2=$row['address2'];
		 $city=$row['city'];	
		 $province=$row['province'];	
		 $occupation=$row['occupation'];	
		 $email_address=$row['email_address'];	
		 $tp_no=$row['tp_no'];	
		 $mobile_no=$row['mobile_no'];	
		 $r_cre_time=$row['r_cre_time'];
		 $r_cre_user_id=$row['r_cre_user_id'];
		
	
            // Confirm success with the user
			echo "<h3>Member Registration Sucess</h3>";
            echo '<p><strong>USER_ID</strong> ' . $user_id . '</p>';
			echo '<strong>Title</strong> ' . $title . '<br />';
            echo '<strong>First Name:</strong> ' . $first_name . '<br />';
            echo '<strong>Last Name:</strong> ' . $last_name . '<br />';
			echo '<strong>ID_Type:</strong> ' . $id_type . '<br />';
            echo '<strong>ID_Num:</strong> ' . $id_num . '<br />';
			echo '<strong>DOB:</strong> ' . $dob . '<br />';
            echo '<strong>Email_Address:</strong> ' . $email_address . '<br />';
			echo '<strong>Address1</strong> ' . $address1 . '<br />';
			echo '<strong>Address2</strong> ' . $address2 . '<br />';
            echo '<strong>City:</strong> ' . $city . '<br />';
            echo '<strong>Province:</strong> ' . $province . '<br />';
			if(!empty($tp_no)){echo '<strong>TP No:</strong> ' . $tp_no . '<br />';}
            if(!empty($mobile_no)){echo '<strong>Mobile NO:</strong> ' . $mobile_no . '<br />';}
			echo '<strong>Occupation:</strong> ' . $occupation . '<br />';
            echo '<strong>Record Created Time:</strong> ' . $r_cre_time . '<br />';
			echo '<strong>Record Created User_Id:</strong> ' . $r_cre_user_id . '<br />';
			
			
			      // Confirm success with the user
      echo '<h3 style="text-align:center">User Ref No - ' . $user_id . ' for ' . $first_name . ' was successfully Added.</h3>';
	 }
	  
      mysqli_close($dbc);
    //is set get close bracket 	  
	}
	
				echo '<p><a href="../user/login.php">&lt;&lt; Back to AddMember</a></p>';
  // Insert the page footer
  require_once('footer.php');
?>