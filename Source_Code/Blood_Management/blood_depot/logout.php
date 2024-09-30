<?php
  // If the user is logged in, delete the session vars, session cookie, destroy session and clear cookies
  session_start();
  if (isset($_SESSION['bd_id'])) {
    // Delete the session vars
    $_SESSION = array();

    // Delete the session cookie
    if (isset($_COOKIE[session_name()])) {      setcookie(session_name(), '', time() - 3600);    }

    // Destroy the session
    session_destroy();
  }

  // Delete the membership_id , first_name,  mem_expiry_date and image_name cookies
  setcookie('bd_id', '', time() - 3600);
  setcookie('first_name', '', time() - 3600);
  setcookie('image_name', '', time() - 3600);
  

  // Redirect to the home page
	      $home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/blood_management/index.php';
          header('Location: ' . $home_url);
?>
