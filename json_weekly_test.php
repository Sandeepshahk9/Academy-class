<?php
    include("include/config.inc.php");
    $test_id=mysqli_real_escape_string($con,$_REQUEST['test_id']);
    $q=mysqli_fetch_array(mysqli_query($con,"select date from weekly_test where id=$test_id"));
    
    echo $q['date'];
?>