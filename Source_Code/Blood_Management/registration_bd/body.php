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

function member_pic($membership_id){
	
	 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());

    	//If Pic Already Available Capture the refference
	$query_pic = "SELECT * FROM member_login_tbl WHERE MEMBERSHIP_ID='$membership_id' and IMAGE_NAME is not null";
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


function book_pic($isbn){
	
	 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());

    	//If Pic Already Available Capture the refference
	$query_pic = "SELECT * FROM book_master_tbl WHERE MEMBERSHIP_ID='$isbn' and IMAGE_NAME is not null";
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


function charge_amt($accession_num,$days,$status){
	$amt=0; $lost_book_chrg_percent=0;$binding_chrg=0; $price=0;
	
 if($days<=30){
	 $amt=5*$days;
 }
 else if ($days<=90){
	 $amt=250;
 }
  else if ($days<=180){
	 $amt=500;
 }
 
 else{
	 $amt=1000;
 }
 
  if($status=='L'){
	  	 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
			
			    	
	$query_price = "SELECT PRICE FROM book_master_tbl a,book_det_tbl b WHERE a.ISBN=b.ISBN AND b.ACCESSION_NUM='$accession_num'";
									//echo "<DIV CLASS='debug'>$query_price</DIV>";
									

	$result_price=mysqli_query($dbc, $query_price);
	  $row=mysqli_fetch_array($result_price);
	  $price = $row['PRICE'];
	
	$query_binding_chrg= "SELECT VALUE FROM parameter_tbl WHERE EVENT='BINDING_CHRG'";
									//echo "<DIV CLASS='debug'>$query_binding_chrg</DIV>";
									

	$result_binding_chrg=mysqli_query($dbc, $query_binding_chrg);
	  $row=mysqli_fetch_array($result_binding_chrg);
	  	  $binding_chrg = $row['VALUE'];
		  
	$query_lost_book_chrg_percent= "SELECT VALUE FROM parameter_tbl WHERE EVENT='LOST_BOOK_CHRG_PERCENT'";
									//echo "<DIV CLASS='debug'>$query_lost_book_chrg_percent</DIV>";
									

	$result_lost_book_chrg_percent=mysqli_query($dbc, $query_lost_book_chrg_percent);
	  $row=mysqli_fetch_array($result_lost_book_chrg_percent);
	  	  $lost_book_chrg_percent = $row['VALUE'];
		  
	  //$amt=$amt+($price*$lost_book_chrg_percent/100)+$binding_chrg;
	  
	       mysqli_close($dbc);	
  }
	return array($amt, ($price*$lost_book_chrg_percent/100) ,$binding_chrg);			  
}



function membership_charge_amt($membership_id){

	  	 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
			
			    	
	$query_price = "SELECT CHILD_FLG,RECIDENT_FLG,EMPLOYED_FLG FROM member_master_tbl WHERE MEMBERSHIP_ID='$membership_id'";
									//echo "<DIV CLASS='debug'>$query_price</DIV>";
									

	$result_price=mysqli_query($dbc, $query_price);
	  $row=mysqli_fetch_array($result_price);
	  $child = $row['CHILD_FLG'];
	  $recident = $row['RECIDENT_FLG'];
	  $employed = $row['EMPLOYED_FLG'];
	  
	  if($child=='Y'){
		  //child recident
		  if($recident=='Y'){
			  $amt=51;
		  }
		  //child NR, Employed
		  else{
			  if($employed=='Y'){
				  $amt=102;
			  }
			  //Child NR, NE
			  else{
				  $amt=504;
			  }
		  }
	  }
	  else{
		  //Adult recident
		  if($recident=='Y'){
			  $amt=102;
		  }
		  //Adult NR, Employed
		  else{
			  if($employed=='Y'){
				  $amt=204;
			  }
			  //Adult NR, NE
			  else{
				  $amt=504;
			  }
		  }
	  }
	
		       mysqli_close($dbc);	
	return $amt;			  
}

// image max file size
$max_size=131072;
$mem_im_loc="../member/images/member/";
$book_im_loc="images/books/";

// to store Librarian related session variable 
if(isset($_SESSION['user_id']) && isset($_SESSION['role']) && isset($_SESSION['img_name']) ){
 $user=strtoupper($_SESSION['user_id']);
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
