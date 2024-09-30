<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Host Campaign!';
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
$bd_id = mysqli_real_escape_string($dbc, trim($_POST['BD_ID']));
$user=strtoupper($_SESSION['admin_id']);

// Check bd_id is entered
if(!empty($bd_id)){
$query = "SELECT * from blood_depot_master_tbl WHERE BD_ID='$bd_id' and status='A'";
  									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 //if bd_id no already exists in master table redirect to Host Campaign detail page
 if (mysqli_num_rows($result)==1){
	      $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/host_campaign_det.php?bd_id=' . $bd_id ;
          header('Location: ' . $url); 
								 }
								 //incorrect BD_ID no
								 else{
									 $err_msg='Blood Depot ID is  not found in the System\n';
								 }
								 
				}
				//bd_id value is empty
				else {
					$err_msg='Please Key in BD_ID no';
			   }
			   
		mysqli_close($dbc);  
	}
	
?>

    <form name="hostcampaignform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	  		 <br/>


	
  <div class="center">
	  <div class="field" style="padding-top:5%">
        <label for="BD_ID">Blood Depot No:</label>
        <input id="BD_ID" name="BD_ID" type="text" size="17" value="<?php if (!empty($bd_id)) echo $bd_id; ?>" />
		</div>
     
	 <br/>
	 <br/>
	 <br/>
	 
	  <div class="field">
		<input type="submit" class="sumbit" value="Host Campaig" name="submit" />
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