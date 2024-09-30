<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Send Email Reminder!';
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
  
  



  

 $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
	
$i=0;
$query = "select * from eligible_donors_view where BLOOD_GROUP in (
SELECT DONOR_BLOODGROUP FROM blood_management.blood_compatibility_tbl
where RECEIVER_BLOODGROUP in (SELECT BLOOD_GROUP FROM blood_management.pending_request_view))";




									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 while($row=mysqli_fetch_array($result)){
	 $USER_ID=$row['USER_ID']; 
	 $FIRST_NAME=$row['FIRST_NAME']; 
	 $email_address=$row['EMAIL_ADDRESS'];
	 
	 
$query2 = "select * from pending_request_view where BLOOD_GROUP in (
SELECT RECEIVER_BLOODGROUP FROM blood_management.blood_compatibility_tbl
where DONOR_BLOODGROUP in (select BLOOD_GROUP from eligible_donors_view where USER_ID='$USER_ID'))";
	 
		
	  $from = 'systembloodmanagement@gmail.com';
	  $subject = "systembloodmanagement@gmail.com";
      $msg = "	  Dear $FIRST_NAME,
	  
			We hope this email finds you well.

			We want to remind you about our upcoming blood donation drive. Your participation in this noble cause would be highly appreciated.
			As you may know, blood donation plays a crucial role in saving lives and supporting healthcare efforts. Your generous donation can make a significant difference in someone's life.
			Please confirm your attendance or let us know if you have any questions or concerns. We look forward to seeing you at the event.
			Thank you for your support and consideration.

			Best regards";

	  
      mail($email_address, $subject, $msg, 'From:' . $from);
	  $i++;
	  $email[]=$email_address;
 }
	        
	  $email_list=implode(', ',$email);
	  $err_msg= "Email Reminder Sent Successfully to $i Members";
	  
if(!empty($err_msg)){ 
echo "<h3>Sucess Info</h3>";
		echo '<p class="sucess" >'.$err_msg.'</p>';
		echo '<p>Email sent to Following Mail Address</p>';
		echo '<p>'.$email_list.'</p>';
		
		echo "<div class='left'><a href='index.php'><img id='button_right' src='images/back.png' 
	  alt='BACK'/></a></div>";
}

mysqli_close($dbc);	
 
 
  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>