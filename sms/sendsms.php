<?php
$token = 'Your Token Here';

$mobile = '9651807986';
$msg = 'Hello World';
$site = 'http://localhost/ecampus/sms/';
$url = "http://api.fast2sms.com/sms.php?mob=".$mobile."&mess=".$msg."&sender=".$site."&route=0";
$homepage = file_get_contents($url);
if($homepage)
{
  echo "Message Send Compleated...";
}
else{
  echo "Something Went Wrong...";
}
?>
