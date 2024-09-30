<!--body.php div tag opened-->
<div class='body'>
<?php

// trans.php
function begin($dbc){
    mysqli_query($dbc,"BEGIN");
}

function commit($dbc){
    mysqli_query($dbc,"COMMIT");
}

function rollback($dbc){
    mysqli_query($dbc,"ROLLBACK");
}

// image max file size
$max_size=131072;
$mem_im_loc="images/user/";

function member_pic($user_id){
	
	 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());

    	//If Pic Already Available Capture the refference
	$query_pic = "SELECT * FROM user_login_tbl WHERE USER_ID='$user_id' and IMAGE_NAME is not null";
									//echo "<DIV CLASS='debug'>$query1</DIV>";
									

	$result_pic=mysqli_query($dbc, $query_pic);
	if (mysqli_num_rows($result_pic)==1){
	  $row=mysqli_fetch_array($result_pic);
	  $pic = $row['IMAGE_NAME'];
								  }
								  else{
									  $pic='nopic.jpg';
								  }
		mysqli_close($dbc);
	return $pic;			  
}

if(isset($_SESSION['user_id'])){
 $user=strtoupper($_SESSION['user_id']);
 $fname=strtoupper($_SESSION['first_name']) ; 
 $image_name=$_SESSION['image_name'] ; 

?>


<?php
// if condition end- isset($_SESSION['user_id'])
}
?>







