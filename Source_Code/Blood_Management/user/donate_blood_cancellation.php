<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Donor Withdrawal!';
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
  
  
      if (!empty($_POST['DON_HIDDEN_ID'])) {
		  		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$don_id =  strtoupper(mysqli_real_escape_string($dbc, trim($_POST['DON_HIDDEN_ID'])));
		$user_id=strtoupper(($_SESSION['user_id']));
		
			begin($dbc);
			
	// Update to the user_master_tbl
	$query = "update blood_management.donation_event_tbl set STATUS='C',L_CHG_USER_ID='$user_id'
				where DONATION_ID='$don_id' and DONOR_ID='$user_id'";
	
										//echo "<DIV CLASS='debug'>$query</DIV>";
 $result=mysqli_query($dbc, $query);
									//echo "<DIV CLASS='debug'>$result</DIV>";

									

	
if ($result) {
    commit($dbc);
	$msg = 'DONATION ID:  ' . $don_id . ' has been Cancelled.';
    echo '<script>';
    echo 'alert("' . $msg . '");'; // Display an alert box with the success message
    echo 'window.location.href = "http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/donate_blood.php";'; 
    echo '</script>';
    exit; // exit the script after redirection
	}
	else {
    rollback($dbc);
	$err_msg = 'Oops! Something went wrong while trying to Cancelling ' . $don_id . ' Donation ID. Please try again later or contact support for assistance.';
}
	mysqli_close($dbc);  

}
else {
            $err_msg='Oops! Something Went Wrong';
			
			   }
			   
	

  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>