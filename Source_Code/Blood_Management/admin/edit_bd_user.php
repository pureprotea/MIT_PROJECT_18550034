<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Blood Depot Modification!';
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
			
// Grab the POST data
$bd_id = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['BD_ID'])));


// If Membership id is entered
if(!empty($bd_id))
{
$query = "SELECT BD_ID from blood_depot_master_tbl WHERE BD_ID='$bd_id' and status='A'";
			
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
  while ($row = mysqli_fetch_array($result)) {
  $valid_bd_id=$row['BD_ID'];}
}



//valid membership id found redirects to edit BD details page				
if(!empty($valid_bd_id)){
          $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/edit_bd_user_det.php?bd_id=' . $valid_bd_id ;
          header('Location: ' . $url);      
		}
		else {
				$err_msg='BD Not Found';
			}  
			
		mysqli_close($dbc);  
	}
	
?>
  <form name="searchmemberform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  		 <br/>

  	<div class="center">
		<div class="field" style="padding-top:5%">
			<label for="BD_ID">Blood Depot ID:</label>
			<input id="BD_ID" name="BD_ID" type="text" size="30" 
				value="<?php if (!empty($bd_id)) echo $bd_id; ?>"/>
		</div>
		
		 <br/>
		 <br/>
		 <br/>
		  
		<div class="field">
			<input type="submit" class="sumbit" value="Edit BD" name="submit" />
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