<?php
  // Start the session if cookie var available assign them to session var
  require_once('startsession.php');

  // Set Title for the Page
  $page_title = 'Accept Blood!';
  ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Based Blood Management System - <?php echo $page_title?> </title>
   <link rel="stylesheet" type="text/css" href="main.css" />
   <script type="text/javascript" src="validation.js"></script>
		<script>
		function redirectToDonate(donationId, bloodId) {
			window.location.href = 'accept_blood_det.php?don_id=' + donationId + '&bd_id=' + bloodId;
		}
		</script>
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
  $results_per_page='10';
  $skip= ($page-1)*$results_per_page;
  $table='pending_acceptance_view';
  //$where_column='TITLE';
 


  // Start generating the table of results
  echo '<table border="0" cellpadding="2">';

  // Generate the search result headings
  echo '<tr class="heading">';
  echo '<th>DONATION_ID</th>';
  echo '<th>DONOR_ID</th>';
  echo '<th>BD_ID</th>'; 
  echo '<th>REQ_DATE</th>';
  echo '<th>CAMPAIGN_ID</th>';
  echo '<th>ORG_REQ_ID</th>';
  echo '<th>FIRST_NAME</th>';
  echo '<th>ID_NUM</th>';
  echo '<th>BLOOD_GROUP</th>';
  echo '<th>MOBILE_NO</th>';
  echo '<th>REG_DATE</th>';
  echo '<th>LAST_DON_DATE</th>';
  echo '<th>MED_CERT_EXP_DATE</th>'; 
  echo '<th>ACCEPT</th>'; 

  echo '</tr>';

  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Query to get the total results 
  $query = "select * from $table order by DONATION_ID";
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
    echo '<td valign="top" width="100">' . $row['DONATION_ID'] . '</td>';
    echo '<td valign="top" width="100">' . $row['DONOR_ID'].'</td>';
	echo '<td valign="top" width="100">' . $row['BD_ID'] . '</td>';
    echo '<td valign="top" width="100">' . $row['REQUEST_DATE'] . '</td>';
	echo '<td valign="top" width="100">' . $row['CAMPAIGN_ID'] . '</td>';
	echo '<td valign="top" width="100">' . $row['ORG_REQ_ID'] . '</td>';
    echo '<td valign="top" width="200">' . $row['FIRST_NAME']. '</td>';
    echo '<td valign="top" width="200">' . $row['ID_NUM'] . '</td>';
    echo '<td valign="top" width="100">' . $row['BLOOD_GROUP'] . '</td>';
    echo '<td valign="top" width="150">' . $row['MOBILE_NO'] . '</td>';
    echo '<td valign="top" width="200">' . $row['REGISTRATION_DATE'] . '</td>';
	echo '<td valign="top" width="200">' . $row['LAST_DONATION_DATE'] . '</td>';
    echo '<td valign="top" width="200">' . $row['MEDICAL_CERTIFICATE_EXP_DATE'] . '</td>';	

	
	//echo '<td valign="top" width="150"><button onclick="redirectToA(' . $row['CAMPAIGN_ID'] . ')">' "Donate:" . $row['CAMPAIGN_ID'] . '</button></td>';
	//echo '<td valign="top" width="150"><button style="background-color: #007bff; color: #fff; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;" onclick="redirectToDonate(\'' . $row['CAMPAIGN_ID'] . '\')">Donate: ' . $row['CAMPAIGN_ID'] . '</button></td>';
	echo '<td valign="top" width="150"><button style="background-color: #007bff; color: #fff; padding: 8px 48px; border: none; border-radius: 4px; cursor: pointer;" onclick="redirectToDonate(\'' . $row['DONATION_ID'] . '\', \'' . $row['BD_ID'] . '\')" onmouseover="this.style.backgroundColor=\'#64af64\'" onmouseout="this.style.backgroundColor=\'#007bff\'">Accept</button></td>';

	  
	  
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

