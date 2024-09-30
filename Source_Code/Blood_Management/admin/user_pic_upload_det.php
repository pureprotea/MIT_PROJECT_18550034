<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'User Picture Upload!';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System -<?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>

</head>
<body>
  
<?php  
  require_once('heading.php');
  
  //require_once('appvars.php');
  require_once('db_con_vars.php');

  // Show the navigation menu
  require_once('navmenu.php');
  
  // Show body common content
  require_once('body.php');
  
      if (!empty($_GET['user_id'])) {
		$user_id =  $_GET['user_id'];
		
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$query = "SELECT * FROM user_master_tbl WHERE USER_ID='$user_id'";
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 if (mysqli_num_rows($result)==1){
$row=mysqli_fetch_array($result);
$user_id=$row['USER_ID'];
$title = $row['TITLE'];
$first_name = $row['FIRST_NAME'];
$last_name = $row['LAST_NAME'];
$dob = substr ($row['DOB'],8,2).'/'.substr ($row['DOB'],5,2).'/'.substr ($row['DOB'],0,4);
$id_type = $row['ID_TYPE'];
$id_num = $row['ID_NUM'];
$del_flg = $row['DEL_FLG'];
										
	//If Pic Already Available Capture the refference
	$query1 = "SELECT * FROM user_login_tbl WHERE USER_ID='$user_id' and IMAGE_NAME is not null";
									//echo "<DIV CLASS='debug'>$query1</DIV>";
		
 $result1=mysqli_query($dbc, $query1);
  if (mysqli_num_rows($result1)==1){
	  $row=mysqli_fetch_array($result1);
	  $org_pic = $row['IMAGE_NAME'];
	  
								  }
		//pic not found
		else {
	  $org_pic = '';
			 }
										
	}
  //if invalid membership id keyed in through url redirects to edit_member.php
	else{
	 	 $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/user_pic_upload.php';
          header('Location: ' . $url);
		}
		
		mysqli_close($dbc);
	  }
  
    if (isset($_POST['submit'])) {
		 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
			
// Grab the POST data
$user_id = mysqli_real_escape_string($dbc, trim($_POST['MEMBERSHIP_HIDDEN_ID']));
$title = mysqli_real_escape_string($dbc, trim($_POST['TITLE_HIDDEN_ID']));
$first_name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['FIRST_NAME_HIDDEN_ID'])));
$last_name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['LAST_NAME_HIDDEN_ID'])));
$dob = mysqli_real_escape_string($dbc, trim($_POST['DOB_HIDDEN_ID']));

$id_type = mysqli_real_escape_string($dbc, trim($_POST['ID_TYPE_HIDDEN_ID']));
$id_num = mysqli_real_escape_string($dbc, trim($_POST['ID_NUM_HIDDEN_ID']));
$del_flg = mysqli_real_escape_string($dbc, trim($_POST['DEL_FLG_HIDDEN_ID']));
$org_pic = mysqli_real_escape_string($dbc, trim($_POST['PIC_HIDDEN_ID']));


//uploaded Pic details
    $pic = mysqli_real_escape_string($dbc, trim($_FILES['PIC']['name']));
    $pic_size = $_FILES['PIC']['size']; 
	$pic_type = $_FILES['PIC']['type'];
						


	   if (($pic_type == 'image/gif') || ($pic_type == 'image/jpeg') || ($pic_type == 'image/png') || ($pic_type == 'image/pjpeg')){
          if (($pic_size > 0) && ($pic_size <= $max_size)) {
          if ($_FILES['PIC']['error'] == 0) {
			  
			  $pic_name=time(). $pic;
            // Move the file to the target upload folder
            $img_location = $mem_im_loc.$pic_name;
            if (move_uploaded_file($_FILES['PIC']['tmp_name'], $img_location)) {
              // Write the data to the database
              $query2 = "UPDATE user_login_tbl SET image_name='$pic_name' where USER_ID='$user_id'";
								//echo "<DIV CLASS='debug'>$query2</DIV>";
			  
			   $result2=mysqli_query($dbc, $query2);

				if ($result2){
					 @unlink($mem_im_loc.$org_pic);
						$org_pic=$pic_name;
				}
            }
            else {
              $err_msg="Problem Encountered while uploading the Image";
            }
          }
        }
			else {
			 $err_msg='File size should be less than'.($max_size / 1024).' KB in size';
				}
		}
        else {
           $err_msg="Only GIF, JPEG, or PNG formats are supported";
             }

        // Try to delete the temporary screen shot image file
        @unlink($_FILES['PIC']['tmp_name']);
			   
		mysqli_close($dbc);  
	}
	
?>

    <form enctype="multipart/form-data"  name="uploadpicmemberform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" 
	      onsubmit="return confirm('Do you want to Apply the Changes?');">
	<div class="left">

      <div class="field">
        <label for="USER_ID">User ID:</label>
        <input id="disabled" name="USER_ID" type="text" size="12" 
		value="<?php if (!empty($user_id)) echo $user_id; ?>"  disabled="true" />
      </div>
	  
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="MEMBERSHIP_HIDDEN_ID" name="MEMBERSHIP_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($user_id)) echo $user_id; ?>" />

	  <div class="field">
        <label for="TITLE">Title:</label>
	  <select id="disabled" name="TITLE" disabled="true">
		<option value="MR."  <?php if (!empty($title)) echo $title == "MR."   ? ' selected="selected"' : ''?>>MR.</option>
		<option value="MRS." <?php if (!empty($title)) echo $title == "MRS."  ? ' selected="selected"' : ''?>>MRS.</option>
		<option value="MS."  <?php if (!empty($title)) echo $title == "MS."   ? ' selected="selected"' : ''?>>MS.</option>
		<option value="MAST."<?php if (!empty($title)) echo $title == "MAST." ? ' selected="selected"' : ''?>>MAST.</option>
		<option value="MISS."<?php if (!empty($title)) echo $title == "MISS." ? ' selected="selected"' : ''?>>MISS.</option>
		<option value="DR."  <?php if (!empty($title)) echo $title == "DR."   ? ' selected="selected"' : ''?>>DR.</option>
		<option value="REV." <?php if (!empty($title)) echo $title == "REV."  ? ' selected="selected"' : ''?>>REV.</option>
	  </select>
	  </div>
	  
	  
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="TITLE_HIDDEN_ID" name="TITLE_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($title)) echo $title; ?>" />
	
	
      <div class="field">
        <label for="FIRST_NAME">First Name:</label>
        <input id="disabled" name="FIRST_NAME" type="text" size="30" value="<?php if (!empty($first_name)) echo $first_name; ?>"
          disabled="true" />
      </div>
	  
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="FIRST_NAME_HIDDEN_ID" name="FIRST_NAME_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($first_name)) echo $first_name; ?>" />
		
	  
	  <div class="field">
        <label for="LAST_NAME">Last Name:</label>
        <input id="disabled" name="LAST_NAME" type="text" size="30" value="<?php if (!empty($last_name)) echo $last_name; ?>"
           disabled="true" />
      </div>
	  
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="LAST_NAME_HIDDEN_ID" name="LAST_NAME_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($last_name)) echo $last_name; ?>" />
		
	  
	  <div class="field">
        <label for="DOB">DOB:</label>
        <input id="disabled" name="DOB" type="text" size="10" value="<?php if (!empty($dob)) echo $dob; ?>"
          disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="DOB_HIDDEN_ID" name="DOB_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($dob)) echo $dob; ?>" />
		
	  

	  
	  <div class="field">
        <label for="ID_TYPE">ID Type:</label>
	  <select id="disabled" name="ID_TYPE" disabled="true">
		<option value="NIC"<?php if (!empty($id_type)) echo $id_type == "NIC" ? ' selected="selected"' : ''?>>NIC</option>
		<option value="BC" <?php if (!empty($id_type)) echo $id_type == "BC"  ? ' selected="selected"' : ''?>>BC</option>
	  </select>
	  </div>
	  
	   <!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="ID_TYPE_HIDDEN_ID" name="ID_TYPE_HIDDEN_ID" type="hidden" size="3" 
		value="<?php if (!empty($id_type)) echo $id_type; ?>" />
	  
	  <div class="field">
        <label for="ID_NUM">ID No:</label>
        <input id="disabled" name="ID_NUM" type="text" size="12"
		value="<?php if (!empty($id_num)) echo $id_num; ?>" disabled="true" />
      </div>
	 	
		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="ID_NUM_HIDDEN_ID" name="ID_NUM_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($id_num)) echo $id_num; ?>" />
		
	  
	  <div class="field">
        <label for="DEL_FLG">Status:</label>
	  <select id="disabled" name="DEL_FLG" disabled="true">
		<option value="Y" <?php if (!empty($del_flg)) echo $del_flg == "Y"  ? ' selected="selected"' : ''?>>ACTIVE</option>
		<option value="N" <?php if (!empty($del_flg)) echo $del_flg == "N"  ? ' selected="selected"' : ''?>>DISABLED</option>

	  </select>
	  </div>
	  
	  <!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="DEL_FLG_HIDDEN_ID" name="DEL_FLG_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($del_flg)) echo $del_flg; ?>" />
		
	  	<br/>
		<br/>
		<br/>

	</div>
	
	
<div class="right">
    <label for="PICTURE">Memeber's Pic:</label>
    <input type="file" id="PICTURE" name="PIC" /><br /> <br /> <br />
	
	
	<!--<?php echo $mem_im_loc.$org_pic ; ?> -->
	
	<tr><td class="label"><label for="picture">Picture:</label></td>
	<td><img src='<?php echo (!empty($org_pic)) ? $mem_im_loc.$org_pic : $mem_im_loc.'nopic.jpg' ; ?>' alt="Profile Picture" /></td></tr>
	
	<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="PIC_HIDDEN_ID" name="PIC_HIDDEN_ID" type="hidden" size="12" 
		value="<?php if (!empty($org_pic)) echo $org_pic; ?>" />
	
	<br /> <br /> <br />
	 <div class="field">
		<input type="submit" class="sumbit" value="Upload" name="submit" />
	 </div>
		<a href='user_pic_upload_det.php?user_id=<?php echo $user_id;?>'><img id='button_left' src='/blood_management/admin/images/refresh.png' alt='REFRESH'/></a>
	
		<a href='user_pic_upload.php'><img id='button_left' src='/blood_management/admin/images/back.png' alt='BACK'/></a>


</div>
    </form>
	
	


<?php

  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>