<?php
  // Generate the navigation menu
 // echo '<hr />';
  
	
	  
		//echo '<a href="/blood_management/user/login.php" class="button" style="float:left">Login</a>';

		//echo '<a href="/blood_management/member/login.php" class="button"  style="float:right">Member Login</a>';
 
?>

<nav class="navbar sticky-top navbar-dark bg-danger navbar-expand-md">
        <a class="navbar-brand" href="#">WebBased Blood Management System</a>
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
				
				<li class="nav-item active">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			  </li>
			  
			  <li class="nav-item">
				<a class="nav-link" href="index.php?#about">About</a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="index.php?#contact">Contact</a>
			  </li>
			   <li class="nav-item active">
				<a class="nav-link" href="/blood_management/user/login.php">Login<span class="sr-only">(current)</span></a>

			  </li>
			  <li class="nav-item active">

				<a class="nav-link" href="/blood_management/registration/user_registration.php">Register<span class="sr-only">(current)</span></a>
			  </li>
				
            </ul>
        </div>
    </nav>