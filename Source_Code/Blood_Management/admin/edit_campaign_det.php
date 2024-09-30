<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Edit Campaign';
  ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Donation System <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
<script  type="text/javascript">
	function validate_form(){
		validateDate(document.getElementById('SDATE'), document.getElementById('SDATE_help'));
		validateDate(document.getElementById('EDATE'), document.getElementById('EDATE_help'));
		validateNonEmpty(document.getElementById('LOCATION'), document.getElementById('LOCATION_help'));

	}
	</script>
</head>
<body <?php if (isset($_POST['submit'])) echo 'onload="validate_form()"' ?>>

  <?php
  require_once('heading.php');
  
  //require_once('appvars.php');
  require_once('db_con_vars.php');

  // Show the navigation menu
  require_once('navmenu.php');
  
  // Show body common content
  require_once('body.php');
	
	//if
    if (!empty($_GET['id'])) {
		$id =  $_GET['id'];
		
		$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
		
		$query = "SELECT a.*,b.NAME,b.BRANCH from blood_donation_campaign_tbl a, blood_depot_master_tbl b WHERE a.bd_id=b.bd_id and 
					CAMPAIGN_ID='$id' and DEL_FLG='N' and Status='A'";
									//echo "<DIV CLASS='debug'>$query</DIV>";

$result=mysqli_query($dbc, $query);
if (mysqli_num_rows($result)==1){

while($row=mysqli_fetch_array($result)){
$id=$row['CAMPAIGN_ID'];
$bd_id=$row['BD_ID'];
$name = $row['NAME'];
$branch = $row['BRANCH'];

$sdate = $row['START_DATE'];
$edate = $row['END_DATE'];
$location = $row['PROVINCE'];


$r_cre_time = $row['R_CRE_TIME'];
$r_cre_user_id = $row['R_CRE_USER_ID'];
$l_chg_time = $row['L_CHG_TIME'];
$l_chg_user_id = $row['L_CHG_USER_ID'];
										}
													
	}
	//if invalid id no keyed in through url redirects to host_campaign.php
	else{
	 	 $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . 
		  '/edit_campaign.php';
          header('Location: ' . $url);
		}
		
		mysqli_close($dbc);
	  }
	
    if (isset($_POST['submit'])) {
		 	$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)  or die("Error connecting to MYSQL Database : ". mysqli_connect_error());
			

			
// Grab the POST data
$id = mysqli_real_escape_string($dbc, trim($_POST['ID']));
$bd_id = mysqli_real_escape_string($dbc, trim($_POST['BD_ID']));
$name = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['NAME'])));
$branch = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['BRANCH'])));
$location = strtoupper(mysqli_real_escape_string($dbc, trim($_POST['PROVINCE'])));


$r_cre_time = mysqli_real_escape_string($dbc, trim($_POST['R_CRE_TIME_HIDDEN_ID']));
$r_cre_user_id = mysqli_real_escape_string($dbc, trim($_POST['R_CRE_USER_ID_HIDDEN_ID']));
$l_chg_time = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_TIME_HIDDEN_ID']));
$l_chg_user_id = mysqli_real_escape_string($dbc, trim($_POST['L_CHG_USER_ID_HIDDEN_ID']));

$sdate = mysqli_real_escape_string($dbc, trim($_POST['SDATE']));
$edate = mysqli_real_escape_string($dbc, trim($_POST['EDATE']));


$user=strtoupper($_SESSION['admin_id']);

// Check wheteher all mandatory data keyed in
if(!empty($id) && !empty($location)&& !empty($sdate)&& !empty($edate))
{

//insert minimum once or until no of insert times reaches to No of Book Count(add_count)

	begin($dbc);
	// insert to the book_det_tbl
	$query = "update blood_donation_campaign_tbl set START_DATE=STR_TO_DATE('$sdate','%Y-%m-%d'), END_DATE=STR_TO_DATE('$edate','%Y-%m-%d'), LOCATION='$location',L_CHG_USER_ID='$user' where CAMPAIGN_ID='$id'";

	
										//echo "<DIV CLASS='debug'>$query</DIV>";
 $result=mysqli_query($dbc, $query);
									//echo "<DIV CLASS='debug'>$result</DIV>";

	
if ($result) {
    commit($dbc);
    $msg = 'Campaign details updated successfully';
    echo '<script>';
    echo 'alert("' . $msg . '");'; // Display an alert box with the success message
    echo 'window.location.href = "http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/edit_campaign.php";'; 
    echo '</script>';
    exit; // exit the script after redirection
	}
	else {
    rollback($dbc);
    $err_msg = 'Campaign details not updated';
}

}
else {
            $err_msg='Validation Failed';
			   }
			   
		mysqli_close($dbc);  
	}
	
	
?>

    <form name="hostcampaignform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
	
  <div class="left" style="width:60%">
	 <h2>Campaign Details</h2>
      <div class="field">
        <label for="ID">ID No:</label>
        <input id="ID" name="ID" type="text" size="17" value="<?php if (!empty($id)) echo $id; ?>"
          onblur="validateNonEmpty(this, document.getElementById('ID_help'))" readonly="readonly"/>
        <span id="ID_help" class="help"></span>
      </div>
	  
	<div class="field">
        <label for="BD_ID">BD_ID No:</label>
        <input id="BD_ID" name="BD_ID" type="text" size="17" value="<?php if (!empty($bd_id)) echo $bd_id; ?>"
          onblur="validateNonEmpty(this, document.getElementById('BD_ID_help'))" readonly="readonly"/>
        <span id="BD_ID_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="NAME">Name:</label>
        <input id="NAME" name="NAME" type="text" size="45" value="<?php if (!empty($name)) echo $name; ?>" readonly="readonly" />
      </div>
	  
	  
	  <div class="field">
        <label for="BRANCH">Branch:</label>
        <input id="BRANCH" name="BRANCH" type="text" size="45" value="<?php if (!empty($branch)) echo $branch; ?>" readonly="readonly" />
      </div>

	  <div class="field">
        <label for="SDATE">Start Date:</label>
        <input id="SDATE" name="SDATE" type="date" value="<?php if (!empty($sdate)) echo $sdate; ?>"
          onblur="validateDate(this, document.getElementById('SDATE_help'))" />
        <span id="SDATE_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="EDATE">End Date:</label>
        <input id="EDATE" name="EDATE" type="date" value="<?php if (!empty($edate)) echo $edate; ?>"
          onblur="validateDate(this, document.getElementById('EDATE_help'))" />
        <span id="EDATE_help" class="help"></span>
      </div>
	  
	  <div class="field">
        <label for="LOCATION">Location:</label>
      <input id="LOCATION" name="LOCATION" type="text" size="60" value="<?php if (!empty($location)) echo $location; ?>"/>
	  	<span id="LOCATION_help" class="help"></span>
      </div>
	 
	  
	  <br/>
	  <br/>
	  <br/>
	  
	  <div class="button">
		<input type="submit" class="submit" value="Edit Campaign" name="submit" />
	  </div>
	  
  </div>	
<div class="right" style="width:40%">
	 <h3><em>Record History</em></h3>
	  <div class="field">
        <label for="R_CRE_TIME">Record Created Time:</label>
        <input id="disabled" name="R_CRE_TIME" type="text" size="20" 
		value="<?php if (!empty($r_cre_time)) echo $r_cre_time; ?>"  disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="R_CRE_TIME_HIDDEN_ID" name="R_CRE_TIME_HIDDEN_ID" type="hidden" size="20" 
		value="<?php if (!empty($r_cre_time)) echo $r_cre_time; ?>" />
		
	  
	        <div class="field">
        <label for="R_CRE_USER_ID">Record Created User:</label>
        <input id="disabled" name="R_CRE_USER_ID" type="text" size="20" 
		value="<?php if (!empty($r_cre_user_id)) echo $r_cre_user_id; ?>"  disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="R_CRE_USER_ID_HIDDEN_ID" name="R_CRE_USER_ID_HIDDEN_ID" type="hidden" size="20" 
		value="<?php if (!empty($r_cre_user_id)) echo $r_cre_user_id; ?>" />
		
		
	        <div class="field">
        <label for="L_CHG_TIME">Last Modified Time:</label>
        <input id="disabled" name="L_CHG_TIME" type="text" size="20" 
		value="<?php if (!empty($l_chg_time)) echo $l_chg_time; ?>"  disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="L_CHG_TIME_HIDDEN_ID" name="L_CHG_TIME_HIDDEN_ID" type="hidden" size="20" 
		value="<?php if (!empty($l_chg_time)) echo $l_chg_time; ?>" />
		
	  
	        <div class="field">
        <label for="L_CHG_USER_ID">Last Modified User:</label>
        <input id="disabled" name="L_CHG_USER_ID" type="text" size="20" 
		value="<?php if (!empty($l_chg_user_id)) echo $l_chg_user_id; ?>"  disabled="true" />
      </div>
	  
	  		<!--disabled tag fields not getting submitted on form submission, so hidden tag is used -->
        <input id="L_CHG_USER_ID_HIDDEN_ID" name="L_CHG_USER_ID_HIDDEN_ID" type="hidden" size="20" 
		value="<?php if (!empty($l_chg_user_id)) echo $l_chg_user_id; ?>" />
		

	<div>
		<a href='edit_campaign.php' style="display: inline-block; margin-top: 130px;float:right;width:46.5px;padding-left:30px;padding-right:30px;">
			<img id='button_right' src='images/back.png' alt='BACK'/>
		</a>
	</div>

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