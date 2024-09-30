<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="css/main.css">
	
    <link rel="stylesheet" href="css/bootstrap.css" >
    <script src="js/jquery-3.5.1.slim.js" ></script>
    <script src="js/main.js"></script>
    <script src="js/bootstrap.js"></script>
<script>
    function scrollToContact() {
        // Scroll to the contact section smoothly
        document.getElementById('contact').scrollIntoView({ behavior: 'smooth' });
    }
</script>
    <title>WebBased Blood Management System</title>
  </head>

<body>

<?php
  // Show heading detail
  require_once('heading.php');

  // Show the navigation menu
  require_once('navmenu.php');
  
  // Show body common content
  require_once('body.php');

  // Insert the page footer
  require_once('footer.php');
?>