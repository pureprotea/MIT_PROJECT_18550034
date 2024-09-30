<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Pending Not Fullfilled';
  ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
	<script>
	  function redirectToDonate(request_id) {
		window.location.href = 'donate_request.php?req_id=' + request_id;
	  }
	</script>
	  <style>
      /* CSS for body background image */
      div.body {
         background-image: url("body1.jpg");
      }
   </style>
</head>
<body>

<?php
  // Show heading detail
  require_once('heading.php');
  
   //require_once('appvars.php');
  require_once('db_con_vars.php');
  
  // Show the navigation menu
  require_once('navmenu.php');
  
  // Show body common content
  //require_once('body.php');
  require_once('report_body.php');
  
$userid=strtoupper($_SESSION['user_id']);

  // Grab search keywords from the URL using GET
  $page =  isset($_GET['page']) ? $_GET['page'] : 1;
  
  //assign variables
  $results_per_page='20';
  $skip= ($page-1)*$results_per_page;
  $table='pending_request_view';
  //$where_column='TITLE';


  // Start generating the table of results
  echo '<table border="0" cellpadding="2">';

  // Generate the search result headings
  echo '<tr class="heading">';
  echo '<th>REQ_ID</th>';
  echo '<th>REQ_DATE</th>';
  echo '<th>URGENCY</th>';
  echo '<th>BLOOD_GROUP</th>';
  echo '<th>USER_ID</th>';
  echo '<th>FIRST_NAME</th>';
  echo '<th>MOBILE_NO</th>';
  echo '<th>EMAIL_ADDRESS</th>';
  echo '<th>ID_NUM</th>';
  echo '<th>CITY</th>';
  echo '<th>DONATE</th>';


  
  echo '</tr>';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Query to get the total results 
  $query = "select * from $table where BLOOD_GROUP in (
SELECT RECEIVER_BLOODGROUP FROM blood_management.blood_compatibility_tbl
where DONOR_BLOODGROUP=(select BLOOD_GROUP from user_master_tbl where USER_ID='$userid')) ";
  $result = mysqli_query($dbc, $query);
										//echo "<DIV CLASS='debug'>$query</DIV>";
   
  $total = mysqli_num_rows($result);
  $num_pages = ceil($total / $results_per_page);
  

	$query1 =  $query . " LIMIT $skip, $results_per_page";
	
  //echo "<DIV CLASS='debug'>$query1</DIV>";
  //echo $total .'</br>';
  //echo $num_pages;
  
  
  // Query again to get just the subset of results
  $result1 = mysqli_query($dbc, $query1);
  while ($row = mysqli_fetch_array($result1)) {
    echo '<tr class="results">';
    echo '<td valign="top" width="100">' . $row['request_id'] . '</td>';
    echo '<td valign="top" width="150">' . $row['request_date'].'</td>';
    echo '<td valign="top" width="100">' . $row['urgency'] . '</td>';
    echo '<td valign="top" width="50">' . $row['BLOOD_GROUP']. '</td>';
    echo '<td valign="top" width="50">' . $row['user_id'] . '</td>';
    echo '<td valign="top" width="100">' . $row['first_name']. '</td>';
	echo '<td valign="top" width="100">' . $row['id_num'] . '</td>';	
    echo '<td valign="top" width="50">' . $row['mobile_no'] . '</td>';
    echo '<td valign="top" width="100">' . $row['email_Address'] . '</td>';
	echo '<td valign="top" width="100">' . $row['CITY'] . '</td>';
	echo '<td valign="top" width="150"><button style="background-color: #007bff; color: #fff; padding: 8px 48px; border: none; border-radius: 4px; cursor: pointer;" onclick="redirectToDonate(\'' . $row['request_id'] . '\')" onmouseover="this.style.backgroundColor=\'#64af64\'" onmouseout="this.style.backgroundColor=\'#007bff\'">Donate</button></td>';

	  
	  
    echo '</tr>';
  } 
  echo '</table>';
    // Generate navigational page links if we have more than one page
  if ($num_pages > 1) {
    echo generate_page_links($page, $num_pages);
  }

  mysqli_close($dbc);
?>

</body>
</html>

<?php
  // Insert the page footer
  require_once('footer.php');
?>

