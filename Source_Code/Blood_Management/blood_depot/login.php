<?php
  require_once('db_con_vars.php');

  // Start the session
  session_start();
  
   // User Already Log on so Redirect to user home page
   if (isset($_SESSION['bd_id'])) {
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
  if (!isset($_SESSION['bd_id'])) {
    if (isset($_POST['submit'])) {
      // Connect to the DB
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered data during form submission
      $user_username = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['username'])));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['password']));
	  $pass_phrase = mysqli_real_escape_string($dbc, trim($_POST['verify']));
	  
	  if (sha1($pass_phrase)==$_SESSION['pass_phrase']){
	
	  
      if (!empty($user_username) && !empty($user_password)) {
        // Check for the username and password in the DB
        $query = "SELECT a.bd_id, b.name,a.image_name FROM blood_depot_login_tbl a,blood_depot_master_tbl b WHERE a.bd_id=b.bd_id and 
					  a.bd_id = '$user_username' AND a.user_pwd = sha(CONCAT(UPPER('$user_username'),'$user_password'))and b.status='A'";
        $results = mysqli_query($dbc, $query);

		
        if (mysqli_num_rows($results) == 1) {
          // The log-in is valid, set session vars and cookies and redirect to the default home page of the user
          $row = mysqli_fetch_array($results);
          $_SESSION['bd_id'] = $row['bd_id'];
          $_SESSION['name'] = $row['name'];
		  //$_SESSION['mem_expiry_date'] = $row['expiry_date'];
		    //If memeber's pic available
			if (!empty($row['image_name'])) {
				$_SESSION['image_name'] = $row['image_name'];
				setcookie('image_name', $row['image_name'], time() + (60 * 60 * 24 * 45));    // expires in 45 days
			}
			else {
				$_SESSION['image_name'] = 'no_pic.jpg';
				setcookie('image_name', 'no_pic.jpg', time() + (60 * 60 * 24 * 45));    // expires in 45 days
			}
          setcookie('bd_id', $row['bd_id'], time() + (60 * 60 * 24 * 45));    // expires in 45 days
          setcookie('name', $row['name'], time() + (60 * 60 * 24 * 45));  // expires in 45 days
		  setcookie('mem_expiry_date', $row['expiry_date'], time() + (60 * 60 * 24 * 45));  // expires in 45 days
		  //setcookie('child_flg', $row['child_flg'], time() + (60 * 60 * 24 * 45));  // expires in 45 days
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
	  	  
	  }//close brackets of third IF  -- sha1($pass_phrase)=$_SESSION['pass_phrase']
	  else{
		$err_msg = 'Invalid Verification Code. Please Re-Enter the Correct Verification Code';
		$output_form = 'yes';
	  }
    }//close brackets of second IF  -- if (isset($_POST['submit']))
  }//close brackets of  first IF --  if(!isset($_SESSION['librarian_id'])


	
	
  // page_title var passed to header.php
  $page_title = 'Blood Depot Login Page';
  
  
// html page for login.php
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
     <legend>Blood Depot User Login Form</legend>
      <label for="username">Username:</label>
      <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /><br />
      <label for="password">Password:</label>
      <input type="password" name="password" /><br /><br />
	  <label for="password"></label>
	  <img src="captcha.php" /> <br />
	      <label for="verify">Verification:</label>
    <input type="text" id="verify" name="verify" value="" /> 
    
	  

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