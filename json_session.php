<?php
    include("include/config.inc.php");
    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
    $q=mysqli_query($con,"select name,id from session where course_id=$course_id");
    $response="";
    while($r=mysqli_fetch_array($q)){
        $response.="<option value='".$r['id']."'>".$r['name']."</option>";
    }
    echo json_encode($response);
?>