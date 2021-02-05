<?php date_default_timezone_set('Asia/Kolkata'); include'config.inc.php';
	session_start();		
	if(empty($_SESSION['user_id']))
	{
		header("Location:index.php");
	}
?>