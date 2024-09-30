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
  $table='donation_det_view';
  //$where_column='TITLE';


  // Start generating the table of results
  echo '<table border="0" cellpadding="2">';

  // Generate the search result headings
  echo '<tr class="heading">';
  echo '<th>BLOOD ID</th>';
  echo '<th>DON_DATE</th>';
  echo '<th>DON_ID</th>';
  echo '<th>BD_ID</th>';
  echo '<th>NAME</th>';
  echo '<th>BLOOD GROUP</th>';
  echo '<th>EXPIRY DATE</th>';
  echo '<th>STATUS</th>';
  
  echo '</tr>';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Query to get the total results 
  $query = "select * from $table where donor_id='$userid' ORDER BY donation_id ";
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
    echo '<td valign="top" width="100">' . $row['blood_id'] . '</td>';
    echo '<td valign="top" width="100">' . $row['donation_date'].'</td>';
    echo '<td valign="top" width="100">' . $row['donation_id'] . '</td>';
    echo '<td valign="top" width="100">' . $row['bd_id']. '</td>';
    echo '<td valign="top" width="300">' . $row['name'] . '</td>';
    echo '<td valign="top" width="150">' . $row['blood_group']. '</td>';
	echo '<td valign="top" width="200">' . $row['expiry_date'] . '</td>';	
    echo '<td valign="top" width="50">' . $row['status'] . '</td>';

	  
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

