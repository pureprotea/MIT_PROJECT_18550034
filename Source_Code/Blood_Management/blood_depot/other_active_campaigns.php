<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Other BD Active Campaigns Report';
  ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
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
  
$bd_id=strtoupper($_SESSION['bd_id']);

  // Grab search keywords from the URL using GET
  $page =  isset($_GET['page']) ? $_GET['page'] : 1;
  
  //assign variables
  $results_per_page='20';
  $skip= ($page-1)*$results_per_page;
  $table='active_campaign_view';
  //$where_column='TITLE';
 


  // Start generating the table of results
  echo '<table border="0" cellpadding="2">';

  // Generate the search result headings
  echo '<tr class="heading">';
  echo '<th>CAMPAIGN_ID</th>';
  echo '<th>CREATION_DATE</th>';
  echo '<th>BD_ID</th>'; 
  echo '<th>NAME</th>';
  echo '<th>BRANCH</th>';
  echo '<th>CONTACT_NO</th>';
  echo '<th>STRAT DATE</th>';
  echo '<th>END DATE</th>';
  echo '<th>LOCATION</th>';

  
  echo '</tr>';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Query to get the total results 
  $query = "select * from $table where BD_ID<>'$bd_id' order by CAMPAIGN_ID";
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
    echo '<td valign="top" width="100">' . $row['CAMPAIGN_ID'] . '</td>';
    echo '<td valign="top" width="150">' . $row['R_CRE_TIME'].'</td>';
	echo '<td valign="top" width="100">' . $row['BD_ID'] . '</td>';
    echo '<td valign="top" width="350">' . $row['NAME'] . '</td>';
    echo '<td valign="top" width="150">' . $row['BRANCH']. '</td>';
    echo '<td valign="top" width="150">' . $row['CONTACT_NO'] . '</td>';
    echo '<td valign="top" width="100">' . $row['START_DATE'] . '</td>';
	echo '<td valign="top" width="100">' . $row['END_DATE'] . '</td>';
    echo '<td valign="top" width="150">' . $row['PROVINCE'] . '</td>';

	  
	  
    echo '</tr>';
  } 
  echo '</table>';
    // Generate navigational page links if we have more than one page
  if ($num_pages > 1) {
    echo generate_page_links($page, $num_pages);
  }

  mysqli_close($dbc);
?>
<br/> <br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']).'/index.php'?>">Back to Reports</a> <br/>
</body>
</html>

<?php
  // Insert the page footer
  require_once('footer.php');
?>

