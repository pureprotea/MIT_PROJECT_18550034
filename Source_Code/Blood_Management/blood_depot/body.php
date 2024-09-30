<!--body.php div tag opened-->
<div class='body'>
<?php

// trans.php
function begin($dbc){
    mysqli_query($dbc,"BEGIN");
}

function commit($dbc){
    mysqli_query($dbc,"COMMIT");
}

function rollback($dbc){
    mysqli_query($dbc,"ROLLBACK");
}

// image max file size
$max_size=131072;

if(isset($_SESSION['user_id'])){
 $user=strtoupper($_SESSION['user_id']);
 $fname=strtoupper($_SESSION['first_name']) ; 
 $image_name=$_SESSION['image_name'] ; 

?>



<?php
// if condition end- isset($_SESSION['user_id'])
}
?>







