<?php
  session_start();

  // If admin_id Session variable is not set but cookie is set, then set session variables with cookie membership_id/first_name info
  if (!isset($_SESSION['admin_id'])) {
    if (isset($_COOKIE['admin_id']) && isset($_COOKIE['role']) && isset($_COOKIE['img_name'])) {
      $_SESSION['admin_id'] = $_COOKIE['admin_id'];
      $_SESSION['role'] = $_COOKIE['role']; 
	  $_SESSION['img_name'] = $_COOKIE['img_name']; 
    }
  }
?>
