<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Edit Campaign!';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System -<?php echo $page_title?> </title>
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
$id = mysqli_real_escape_string($dbc, trim($_POST['ID']));
$user=strtoupper($_SESSION['admin_id']);

// Check id is entered
if(!empty($id)){
$query = "SELECT * from blood_donation_campaign_tbl WHERE CAMPAIGN_ID='$id' and DEL_FLG='N'";
  									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 //if id no already exists in master table redirect to Host Campaign detail page
 if (mysqli_num_rows($result)==1){
	      $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/edit_campaign_det.php?id=' . $id ;
          header('Location: ' . $url); 
								 }
								 //incorrect ID no
								 else{
									 $err_msg='Campaign ID is  not found in the System\n';
								 }
								 
				}
				//id value is empty
				else {
					$err_msg='Please Key in ID no';
			   }
			   
		mysqli_close($dbc);  
	}
	
?>

    <form name="editcampaignform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	  		 <br/>


	
  <div class="center">
	  <div class="field" style="padding-top:5%">
        <label for="ID">Campaign ID:</label>
        <input id="ID" name="ID" type="text" size="17" value="<?php if (!empty($id)) echo $id; ?>" />
		</div>
     
	 <br/>
	 <br/>
	 <br/>
	 
	  <div class="field">
		<input type="submit" class="sumbit" value="Edit Campaign" name="submit" />
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