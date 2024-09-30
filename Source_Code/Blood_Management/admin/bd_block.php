<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Block Blood Depot!';
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

      if (!empty($_POST['BLOOD_DEPOT_BLOCK'])) {
		  
		  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$bd_id =  strtoupper(mysqli_real_escape_string($dbc, trim($_POST['BLOOD_DEPOT_BLOCK'])));
		$user=strtoupper(($_SESSION['admin_id']));
		

		$query = "SELECT * FROM blood_depot_master_tbl WHERE BD_ID='$bd_id'";
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
 if (mysqli_num_rows($result)==1){
	 
 while($row=mysqli_fetch_array($result)){
$bd_id=$row['BD_ID'];
$name = $row['NAME'];
$branch = $row['BRANCH'];
$status = $row['STATUS'];
$address1 = $row['ADDRESS1'];
$address2 = $row['ADDRESS2'];
$city = $row['CITY'];
$province = $row['PROVINCE'];
$email_address = $row['EMAIL_ADDRESS'];
$contact_no = $row['CONTACT_NO'];
$r_cre_time = $row['R_CRE_TIME'];
$r_cre_user_id = $row['R_CRE_USER_ID'];
$l_chg_time = $row['L_CHG_TIME'];
$l_chg_user_id = $row['L_CHG_USER_ID'];
										}
										
if ($status=='B'){					
 $err_msg="Blood Depot is Already in Blocked Status";
						
				}
				
else if ($status=='P'){					

	$err_msg="Blood Depot with Pending status can't be Blocked";
	
	
   }
   
if ($status=='A'){					
begin($dbc);
// update database
$query = "update blood_depot_master_tbl set STATUS='B', L_CHG_TIME=now(), L_CHG_USER_ID='$user'
			 where BD_ID='$bd_id'";
			
									//echo "<DIV CLASS='debug'>$query</DIV>";
		
 $result=mysqli_query($dbc, $query);
									//echo "<DIV CLASS='debug'>$result</DIV>";


									
//if update sucessful, refresh the page
if ($result){
	commit($dbc);
	$err_msg="Blood Depot has been successfully Blocked";
	$status='B';
	
	
   }
	else{
	rollback($dbc);
	$err_msg="Update Failed";
	}   
						
}
			   
		 
	}  
	//if invalid membership id keyed in through url redirects to edit_member.php
	else{
	 	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		 '/member_status.php';
         header('Location: ' . $url);
		}
		
			mysqli_close($dbc);
			
	}
  //Blood Depot ID is null
	else{
	 	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		 '/member_status.php';
         header('Location: ' . $url);
		}

	switch ($status) {
    case 'P':
      $m_status = "NEW USER";
      break;
    // Descending by job title
    case 'A':
      $m_status = "ACTIVE";
      break;
    // Ascending by state
    case 'B':
      $m_status = "BLOCKED";
      break;
    default:
	$m_status = "N/A";
    }		
?>

      <form>
	      
	<div class="left">

      <div class="field">
        <label for="BD_ID">Blood Depot ID:</label>
        <input id="BD_ID" name="BD_ID" type="text" size="12" 
		value="<?php if (!empty($bd_id)) echo $bd_id; ?>"  readonly="readonly" />
      </div>
	  

      <div class="field">
        <label for="NAME">Name:</label>
        <input id="NAME" name="NAME" type="text" size="30" value="<?php if (!empty($name)) echo $name; ?>"
			readonly="readonly"/>
      </div>
	  
	  <div class="field">
        <label for="BRANCH">Branch:</label>
        <input id="BRANCH" name="BRANCH" type="text" size="30" value="<?php if (!empty($branch)) echo $branch; ?>"
			readonly="readonly" />

      </div>

		
	  <div class="field">
        <label for="ADDRESS1">Address 1:</label>
        <input id="ADDRESS1" name="ADDRESS1" type="text" size="30" value="<?php if (!empty($address1)) echo $address1; ?>"
           readonly="readonly" />
      </div>
	  
	  <div class="field">
        <label for="ADDRESS2">Address 2:</label>
        <input id="ADDRESS2" name="ADDRESS2" type="text" size="30" value="<?php if (!empty($address2)) echo $address2; ?>"
           readonly="readonly" />

      </div>
	 

	  <div class="field">
        <label for="CITY">City:</label>
        <input id="CITY" name="CITY" type="text" size="20"  value="<?php if (!empty($city)) echo $city; ?>"
		       readonly="readonly" />

      </div>
	  
	  
	  <div class="field">
        <label for="PROVINCE">Province:</label>
		<select id="PROVINCE" name="PROVINCE" disabled="true">
		<option value="WESTERN PROVINCE"      <?php if (!empty($province)) echo $province == "WESTERN PROVINCE"       ? ' selected="selected"' : ''?>>WESTERN PROVINCE</option>
		<option value="CENTRAL PROVINCE"      <?php if (!empty($province)) echo $province == "CENTRAL PROVINCE"       ? ' selected="selected"' : ''?>>CENTRAL PROVINCE</option>
		<option value="NORTH CENTRAL PROVINCE"<?php if (!empty($province)) echo $province == "NORTH CENTRAL PROVINCE" ? ' selected="selected"' : ''?>>NORTH CENTRAL PROVINCE</option>
		<option value="NORTH WESTERN PROVINCE"<?php if (!empty($province)) echo $province == "NORTH WESTERN PROVINCE" ? ' selected="selected"' : ''?>>NORTH WESTERN PROVINCE</option>
		<option value="NORTHERN PROVINCE"     <?php if (!empty($province)) echo $province == "NORTHERN PROVINCE"      ? ' selected="selected"' : ''?>>NORTHERN PROVINCE</option>
		<option value="SABARAGAMUWA PROVINCE" <?php if (!empty($province)) echo $province == "SABARAGAMUWA PROVINCE"  ? ' selected="selected"' : ''?>>SABARAGAMUWA PROVINCE</option>
		<option value="UVA PROVINCE"          <?php if (!empty($province)) echo $province == "UVA PROVINCE"           ? ' selected="selected"' : ''?>>UVA PROVINCE</option>
		<option value="SOUTHERN PROVINCE"     <?php if (!empty($province)) echo $province == "SOUTHERN PROVINCE"      ? ' selected="selected"' : ''?>>SOUTHERN PROVINCE</option>
		<option value="EASTERN PROVINCE"      <?php if (!empty($province)) echo $province == "EASTERN PROVINCE"       ? ' selected="selected"' : ''?>>EASTERN PROVINCE</option>
	  </select>
      </div>
	  
	  </div>
	    	  <div class="right">
	  
	  <div class="field">
        <label for="EMAIL_ADDRESS">Email Address:</label>
        <input id="EMAIL_ADDRESS" name="EMAIL_ADDRESS" type="text" size="30" value="<?php if (!empty($email_address)) echo $email_address; ?>"
            readonly="readonly" /> 

      </div>
		  
	  <div class="field">
        <label for="CONTACT_NO">Contact Number:</label>
        <input id="CONTACT_NO" name="CONTACT_NO" type="text" size="20" value="<?php if (!empty($contact_no)) echo $contact_no; ?>"
		     readonly="readonly" /> 

      </div>
	  
	  <div class="field">
        <label for="STATUS" >Status:</label>
        <input id="red" name="STATUS" type="text" size="12"  value="<?php if (!empty($m_status)) echo $m_status; ?>"
		 readonly="readonly" />

      </div>
	  

	  <div class="field">
        <label for="R_CRE_TIME">Record Created Time:</label>
        <input id="disabled" name="R_CRE_TIME" type="text" size="20" 
		value="<?php if (!empty($r_cre_time)) echo $r_cre_time; ?>"  disabled="true" />
      </div>
	  

	        <div class="field">
        <label for="R_CRE_USER_ID">Record Created User:</label>
        <input id="disabled" name="R_CRE_USER_ID" type="text" size="20" 
		value="<?php if (!empty($r_cre_user_id)) echo $r_cre_user_id; ?>"  disabled="true" />
      </div>
	  

	  	<br/>
		<br/>
		<br/>
	  </div>
	  

    </form>

<a href='bd_status_update_det.php?bd_id=<?php echo $bd_id;?>&status=<?php echo $status;?>'><img id='button_left' src='/blood_management/admin/images/back.png' alt='BACK'/></a>

		 <p class="sucess" ><?php if (!empty($err_msg)) echo $err_msg; ?></p>
<?php

  // Insert the page footer
  require_once('footer.php');
  	if (!empty($err_msg)) {
			echo '<script language="javascript">';
			echo 'alert("'.$err_msg.'")';
			echo '</script>';
	}
?>