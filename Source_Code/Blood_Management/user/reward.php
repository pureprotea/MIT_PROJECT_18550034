<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Transaction Report';
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
  
$userid=strtoupper($_SESSION['user_id']);

  // Grab search keywords from the URL using GET
  $page =  isset($_GET['page']) ? $_GET['page'] : 1;
  
  //assign variables
  $results_per_page='20';
  $skip= ($page-1)*$results_per_page;
  $table='reward_tran_tbl';
  //$where_column='TITLE';
  
  
  
   $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Query to get the total results 
  $query = "SELECT * FROM blood_management.reward_tran_tbl a, reward_balance_tbl b
where a.user_id=b.user_id and a.USER_ID='$userid'";
  $result = mysqli_query($dbc, $query);
										//echo "<DIV CLASS='debug'>$query</DIV>";
   
  $total = mysqli_num_rows($result);
  
   while($row=mysqli_fetch_array($result)){
  $balance= $row['REWARD_POINT_BALANCE'];
   }
   
   

  echo '<h2>Reward Points Balance: ' . $balance . '</h2>'; // Display balance above the table

  // Start generating the table of results
  echo '<table border="0" cellpadding="2">';

  // Generate the search result headings
  echo '<tr class="heading">';
  echo '<th>TRAN_ID</th>';
  echo '<th>TRAN_DATE</th>';
  echo '<th>USER_ID</th>';
  echo '<th>TRAN_TYPE</th>';
  echo '<th>TRAN_AMT</th>';
  echo '<th>TRAN_IND</th>';
  echo '<th>REMARKS</th>';
  
  echo '</tr>';


  
  

  $num_pages = ceil($total / $results_per_page);
  

	$query1 =  $query . " LIMIT $skip, $results_per_page";
	
  //echo "<DIV CLASS='debug'>$query1</DIV>";
  //echo $total .'</br>';
  //echo $num_pages;
  


  // Query again to get just the subset of results
  $result1 = mysqli_query($dbc, $query1);
  while ($row = mysqli_fetch_array($result1)) {
    echo '<tr class="results">';
    echo '<td valign="top" width="50">' . $row['TRAN_ID'] . '</td>';
    echo '<td valign="top" width="170">' . $row['R_CRE_TIME'].'</td>';
    echo '<td valign="top" width="170">' . $row['USER_ID'] . '</td>';
    echo '<td valign="top" width="100">' . $row['TRAN_TYPE']. '</td>';
    echo '<td valign="top" width="100">' . $row['TRAN_AMOUNT'] . '</td>';
    echo '<td valign="top" width="50">' . $row['CR_DR_IND']. '</td>';
    echo '<td valign="top" width="150">' . $row['REMARK'] . '</td>';

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
<a href="http://<?php echo $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']).'/reports.php'?>">Back</a> <br/>
</body>
</html>

<?php
  // Insert the page footer
  require_once('footer.php');
?>

