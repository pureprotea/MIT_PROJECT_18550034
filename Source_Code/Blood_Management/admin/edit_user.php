<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'User Modification!';
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
$user_id = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['USER_ID'])));
$id_num = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['ID_NUM'])));


// If Membership id is entered
if(!empty($user_id))
{
$query = "SELECT USER_ID from user_master_tbl WHERE USER_ID='$user_id' and del_flg='N'";
			
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
  while ($row = mysqli_fetch_array($result)) {
  $valid_user_id=$row['USER_ID'];}
}

// if data is valid
if(!empty($id_num) && empty($valid_user_id))
{
$query = "SELECT USER_ID from user_master_tbl WHERE id_num='$id_num' and del_flg='N'";
			
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
  while ($row = mysqli_fetch_array($result))	 {
	  $valid_user_id=$row['USER_ID'];}
}

//valid membership id found redirects to edit member details page				
if(!empty($valid_user_id)){
          $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/edit_user_det.php?user_id=' . $valid_user_id ;
          header('Location: ' . $url);      
		}
		else {
				$err_msg='Member Not Found';
			}  
			
		mysqli_close($dbc);  
	}
	
?>
  <form name="searchmemberform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
  
  	<div class="left">
	<div class="field" style="padding-top:7%">
        <label for="USER_ID">User ID:</label>
        <input id="USER_ID" name="USER_ID" type="text" size="30" 
			value="<?php if (!empty($user_id)) echo $user_id; ?>"/>
    </div>
	</div>
	
	  	<div class="right">
	<div class="field" style="padding-top:7%">
        <label for="ID_NUM">ID No:</label>
        <input id="ID_NUM" name="ID_NUM" type="text" size="30" 
			value="<?php if (!empty($id_num)) echo $id_num; ?>"/>
    </div>
	</div>
	
	<br/>
	<br/>

	<div class="center" style="padding-top:8%;">
		<input type="submit" class="sumbit" value="Edit User" name="submit" />
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