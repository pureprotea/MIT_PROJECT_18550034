<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'All Users Report';
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
  

  // Grab search keywords from the URL using GET
  $page =  isset($_GET['page']) ? $_GET['page'] : 1;
  
  //assign variables
  $results_per_page='20';
  $skip= ($page-1)*$results_per_page;
  $table='user_master_tbl';
  //$where_column='TITLE';
 


  // Start generating the table of results
  echo '<table border="0" cellpadding="2">';

  // Generate the search result headings
  echo '<tr class="heading">';
  echo '<th>USER_ID</th>';
  echo '<th>CREATION_DATE</th>';
  echo '<th>FIRST NAME</th>';
  echo '<th>ID_NUM</th>';
  echo '<th>DONOR_STATUS</th>';
  echo '<th>DOB</th>';
  echo '<th>OCCUPATION</th>';
  echo '<th>BLOOD_GROUP</th>';
  echo '<th>DEL_FLG</th>';
  echo '<th>EMAIL_ADDRESS</th>';
  echo '<th>MOBILE_NO</th>';

  
  echo '</tr>';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Query to get the total results 
  $query = "select * from $table";
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
    echo '<td valign="top" width="100">' . $row['USER_ID'] . '</td>';
    echo '<td valign="top" width="150">' . $row['R_CRE_TIME'].'</td>';
    echo '<td valign="top" width="100">' . $row['FIRST_NAME'] . '</td>';
    echo '<td valign="top" width="100">' . $row['ID_NUM']. '</td>';
    echo '<td valign="top" width="50">' . $row['DONOR_STATUS'] . '</td>';
    echo '<td valign="top" width="100">' . $row['DOB']. '</td>';
	echo '<td valign="top" width="150">' . $row['OCCUPATION'] . '</td>';
    echo '<td valign="top" width="50">' . $row['BLOOD_GROUP'] . '</td>';
    echo '<td valign="top" width="50">' . $row['DEL_FLG'] . '</td>';
	echo '<td valign="top" width="200">' . $row['EMAIL_ADDRESS'] . '</td>';
    echo '<td valign="top" width="100">' . $row['MOBILE_NO'] . '</td>';

	  
	  
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
<a href="http://<?php echo $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']).'/reports.php'?>">Back to Reports</a> <br/>
</body>
</html>

<?php
  // Insert the page footer
  require_once('footer.php');
?>

