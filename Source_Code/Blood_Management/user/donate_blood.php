<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Donate Blood!';
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
  
  
    if (isset($_POST['submit'])) {
		 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());

$user_id=strtoupper($_SESSION['user_id']);
	
// Grab the POST data
$don_id = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['DON_ID'])));


// If don_id id is entered
if(!empty($don_id))
{
$query = "SELECT * FROM blood_management.donation_event_tbl a, eligible_donors_view b
			where a.DONOR_ID=b.user_id and Status='P' and a.DONOR_ID='$user_id'";
			
									//echo "<DIV CLASS='debug'>$query</DIV>";
									
 $result=mysqli_query($dbc, $query);
  while ($row = mysqli_fetch_array($result)) {
  $valid_don_id=$row['DONATION_ID'];
  $status=$row['STATUS'];

}	 
}


//valid membership id found redirects to edit BD details page				
if(!empty($valid_don_id)){
          $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/donate_blood_det.php?don_id=' . $valid_don_id.'&status='.$status;

          header('Location: ' . $url);      
		}
		else {
				$err_msg='Unable to fulfill the donation request.';
			}  
			
		mysqli_close($dbc);  
	}
	
?>
  <form name="searchmemberform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  		 <br/>

  	<div class="center">
		<div class="field" style="padding-top:5%">
			<label for="DON_ID">Donation ID:</label>
			<input id="DON_ID" name="DON_ID" type="text" size="30" 
				value="<?php if (!empty($don_id)) echo $don_id; ?>"/>
		</div>
		
		 <br/>
		 <br/>
		 <br/>
		  
		<div class="field">
			<input type="submit" class="sumbit" value="Donate Blood" name="submit" />
		</div>
	</div>
	
</form>
<?php
  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>