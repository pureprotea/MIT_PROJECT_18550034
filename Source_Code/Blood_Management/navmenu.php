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
				<a class="nav-link" href="#" onclick="scrollToContact()">About</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#" onclick="scrollToContact()">Contact</a>
			</li>
			<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="registerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Register
                </a>
                <div class="dropdown-menu" aria-labelledby="registerDropdown">
                    <a class="dropdown-item" href="/blood_management/registration_bd/bd_registration.php">Register as Blood Depot</a>
                    <a class="dropdown-item" href="/blood_management/registration/user_registration.php">Register as User</a>
                </div>
            </li>
			
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Login
                </a>
                <div class="dropdown-menu" aria-labelledby="loginDropdown">
                    <a class="dropdown-item" href="/blood_management/admin/login.php">Admin Login</a>
                    <a class="dropdown-item" href="/blood_management/blood_depot/login.php">Blood Depot Login</a>
                    <a class="dropdown-item" href="/blood_management/user/login.php">User Login</a>
                </div>
            </li>

			
            <li class="nav-item">
                <a class="nav-link" href="faq.html">FAQ</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="terms.html">Terms & Conditions</a>
            </li>
        </ul>
    </div>
</nav>
