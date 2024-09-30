<?php
  require_once('db_con_vars.php');

  // Start the session
  session_start();
  
   // User Already Log on so Redirect to user home page
   if (isset($_SESSION['admin_id']) && isset($_SESSION['role'])) {
	  $output_form = 'no';
	      $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
   }
   else
   {
	     $output_form = 'yes';
   }

   
  // Clear the error message
  $err_msg = "";

  // When User hasn't Login yet and submited for login
  if (!isset($_SESSION['admin_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the DB
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered data during form submission
      $user_username = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['username'])));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));

	  
	  
      if (!empty($user_username) && !empty($user_password)) {
        // Check for the username and password in the DB
        $query = "SELECT a.admin_id, a.role,a.img_name FROM admin_login_tbl a,admin_MASTER_tbl b WHERE 
			a.admin_id=b.admin_id and a.admin_id = '$user_username' 
			AND a.user_pwd = sha(CONCAT(UPPER('$user_username'),'$user_password')) and b.del_flg='N'";
        $results = mysqli_query($dbc, $query);

		
        if (mysqli_num_rows($results) == 1) {
         // The log-in is valid, set session vars and cookies and redirect to the default home page of the user
          $row = mysqli_fetch_array($results);
          $_SESSION['admin_id'] = $row['admin_id'];
          $_SESSION['role'] = $row['role'];
		  		    //If Librarian pic available
			if (!empty($row['img_name'])) {
				$_SESSION['img_name'] = $row['img_name'];
				setcookie('img_name', $row['img_name'], time() + (60 * 60 * 24 * 45));    // expires in 45 days
			}
			else {
				$_SESSION['img_name'] = 'nopic.jpg';
				setcookie('img_name', 'nopic.jpg', time() + (60 * 60 * 24 * 45));    // expires in 45 days
			}
		  
		  
          setcookie('admin_id', $row['admin_id'], time() + (60 * 60 * 24 * 45));  // expires in 45 days
          setcookie('role', $row['role'], time() + (60 * 60 * 24 * 45));  // expires in 45 days
		  
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        }
		
		
        else {
          // The username/password are incorrect so set an error message
          $err_msg = 'Wrong user name or password. Try again.';
		  $output_form = 'yes';
        }
		
      }
	  //if user name or password is empty script goes into else condition
	  else {
		  
		  //if user name is empty
		if (empty($user_username)){
		  $err_msg = 'User Name or Password Can\'t be blank. Try again.';
		  $output_form = 'yes';
	    }
			//if user name is set and password is empty
        else {
        $err_msg = 'Password can\'t be blank. Please enter the Password.';
		$output_form = 'yes';
        }
	  }
	  	  
    }//close brackets of second IF  -- if (isset($_POST['submit']))
  }//close brackets of  first IF --  if(!isset($_SESSION['admin_id'])


	
	
  // page_title var passed to header.php
  $page_title = 'Admin Login Page';
 
 
// html page for login.php
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
 <!--  <style>div.body{background-image:url(library.jpg)} </style> -->
 
 
</head>
<body>

  <?php
  require_once('heading.php');

  require_once('body.php');
  
  // if output_form is yes then display the login form
  
  if ($output_form == 'yes'){
	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
		
	  ?>
<div class='login'>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <fieldset>
     <legend>Admin Login Form</legend>
      <label for="username">Username:</label>
      <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
      <label for="password">Password:</label>
      <input type="password" name="password" />
    </fieldset>
    <input type="submit" value="Log In" name="submit" />
	<div>
		<a href='../index.php'><img id='button_right' src='/blood_management/admin/images/back.png' alt='BACK'/></a>
	</div>
	
  </form>
</div>

  
<?php

	}// close brackets of ($output_form == 'yes')
	
  // Insert the page footer. Page Ends here (html close tags)
  require_once('footer.php');
?>