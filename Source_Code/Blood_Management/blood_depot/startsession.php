<?php
  session_start();

  // If user_id Session variable is not set but cookie is set, then set session variables with cookie user_id/first_name info
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['first_name'])&&  isset($_COOKIE['image_name'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['first_name'] = $_COOKIE['first_name'];
	  $_SESSION['image_name'] = $_COOKIE['image_name']; 
    }
  }
?>
