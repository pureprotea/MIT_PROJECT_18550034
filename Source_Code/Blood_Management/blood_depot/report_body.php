<!--body.php div tag opened-->
<div class='report_body'>
<?php
    // This function builds a search query from the search keywords and sort setting
  function report_query_inp($input_search,$table,$where_column) {
    $search_query = "SELECT * FROM $table";

    // Extract the search keywords into an array
    $replaced_search = str_replace(',', ' ', $input_search);
    $searched_words = explode(' ', $replaced_search);
    $final_search = array();
    if (count($searched_words) > 0) {
      foreach ($searched_words as $word) {
        if (!empty($word)) {
          $final_search[] = $word;
        }
      }
    }
	
    // Generate a WHERE clause using all of the search keywords
    $where_list = array();
    if (count($final_search) > 0) {
      foreach($final_search as $word) {
        $where_list[] = "$where_column LIKE '%$word%'";
      }
    }
	
    $where_clause = implode(' OR ', $where_list);
    // Add the keyword WHERE clause to the search query
    if (!empty($where_clause)) {
      $search_query .= " WHERE $where_clause";
    }
	
    return $search_query;
  }
  
  
  

  
  
  function generate_page_links_inp($input_search, $cur_page, $num_pages) {
    $page_links = '';
	
	    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
      $page_links .= '<a href="' . $_SERVER['PHP_SELF'] . '?usersearch=' . $input_search . '&page=' . ($cur_page - 1).'"><img id="button_report" src="images/report_back.png" alt="BACK"/></a> ';
    }
    else {
      $page_links .= "<img id='button_report' src='images/block.png' alt='BACK'/>";
    }


    // Loop through the pages generating the page number links
    for ($i = 1; $i <= $num_pages; $i++) {
      if ($cur_page == $i) {
        $page_links .= ' ' . $i;
      }
      else {
        $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?usersearch=' . $input_search .  '&page=' . $i .'"> ' . $i . '</a>';
      }
    }
	
	// If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
      $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?usersearch=' . $input_search . '&page=' . ($cur_page + 1) .'"><img id="button_report" src="images/report_forward.png" alt="BACK"/></a>';
    }
    else {
      $page_links .= "<img id='button_report' src='images/block.png' alt='BACK'/>";
    }

    return $page_links;
  }
  
  
    function generate_page_links($cur_page, $num_pages) {
    $page_links = '';
	
	    // If this page is not the first page, generate the "previous" link
    if ($cur_page > 1) {
      $page_links .= '<a href="' . $_SERVER['PHP_SELF']. '?&page=' . ($cur_page - 1).'"><img id="button_report" src="images/report_back.png" alt="BACK"/></a> ';
    }
    else {
      $page_links .= "<img id='button_report' src='images/block.png' alt='BACK'/>";
    }


    // Loop through the pages generating the page number links
    for ($i = 1; $i <= $num_pages; $i++) {
      if ($cur_page == $i) {
        $page_links .= ' ' . $i;
      }
      else {
        $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] .  '?&page=' . $i .'"> ' . $i . '</a>';
      }
    }
	
	// If this page is not the last page, generate the "next" link
    if ($cur_page < $num_pages) {
      $page_links .= ' <a href="' . $_SERVER['PHP_SELF'] . '?&page=' . ($cur_page + 1) .'"><img id="button_report" src="images/report_forward.png" alt="BACK"/></a>';
    }
    else {
      $page_links .= "<img id='button_report' src='images/block.png' alt='BACK'/>";
    }

    return $page_links;
  }
  
  
?>
