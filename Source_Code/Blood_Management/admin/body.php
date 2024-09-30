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



// image max file size
$max_size=131072;
$mem_im_loc="../user/images/user/";

// to store Librarian related session variable 
if(isset($_SESSION['admin_id']) && isset($_SESSION['role']) && isset($_SESSION['img_name']) ){
 $user=strtoupper($_SESSION['admin_id']);
 $role=strtoupper($_SESSION['role']) ;
 $img_name=$_SESSION['img_name'] ; 
?>

<!-- Librarian Details in Corner-->
	<div class="r_corner">
	<tr><td><img style="float: right;" src='<?php  if (!empty($img_name)) echo 'images/'.$img_name ; ?>' 
	alt="Librarian Profile Picture" /></td></tr>
	<br/>
		<p style="float: right;">Role: <?php echo $role ; ?></p>
	</div>

<?php
// if condition end
}
?>
