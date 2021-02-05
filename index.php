<?php
include('include/config.inc.php');
session_start();	
if(!empty($_SESSION['user_id'])){
	header("Location:Dashboard.php");
	exit();
}?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title> Academy</title>
<!-- Meta tag Keywords -->
<link rel="icon" href="images/uploads/favicon.png" sizes="16x16" type="image/jpg">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Event Register Form Responsive Widget,Login form widgets, Sign up Web forms , Login signup Responsive web form,Flat Pricing table,Flat Drop downs,Registration Forms,News letter Forms,Elements" />
<style type="text/css">
.wrapper {    
	margin-top: 80px;
	margin-bottom: 20px;
}

.form-signin {
  max-width: 420px;
  padding: 30px 38px 66px;
  margin: 0 auto;
  background-color: #eee;
  border: 3px dotted rgba(0,0,0,0.1);  
  }
.fix{
    position:fixed;
    bottom:10px;
    right:2%;
}
@media screen and (max-width: 600px) {
  .fix {
    position:fixed;
    top:10px;
    right:2%;
  }
}
.form-signin-heading {
  text-align:center;
  margin-bottom: 30px;
}

.form-control {
  position: relative;
  font-size: 16px;
  height: auto;
  padding: 10px;
}

input[type="text"] {
  margin-bottom: 0px;
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
}

input[type="password"] {
  margin-bottom: 20px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}

.colorgraph {
  height: 7px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}
</style>
</head>
<body>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------
<marquee scrollamount="5">Under Maintanance!</marquee>
<marquee scrollamount="5" direction="right">Under Maintanance!</marquee>
<marquee scrollamount="15">Under Maintanance!</marquee>
<marquee scrollamount="15" direction="right">Under Maintanance!</marquee>
<marquee scrollamount="20">Under Maintanance!</marquee>
<marquee scrollamount="20" direction="right">Under Maintanance!</marquee>
<marquee scrollamount="25">Under Maintanance!</marquee>
<marquee scrollamount="25" direction="right">Under Maintanance!</marquee>
<marquee scrollamount="8">Under Maintanance!</marquee>
<marquee scrollamount="8" direction="right">Under Maintanance!</marquee>
<marquee scrollamount="50">Under Maintanance!</marquee>
<marquee scrollamount="50" direction="right">Under Maintanance!</marquee>
<marquee scrollamount="5">Under Maintanance!</marquee>
<marquee scrollamount="5" direction="right">Under Maintanance!</marquee>
<marquee scrollamount="7">Under Maintanance!</marquee>
<marquee scrollamount="7" direction="right">Under Maintanance!</marquee>
-->
<div class = "container">
	<div class="wrapper">
		<form action="login_check.php" method="post" name="Login_Form" class="form-signin"> 
		
		<center><div><img src="images/uploads/favicon.png" height="140" style="border-radius:50%;" width="140"/></div></center>
		    <h3 class="form-signin-heading" style="text-transform:capitalize;"> Academy</h3>
			  <hr class="colorgraph"><br>
			  MANAGEMENT
			  <input type="radio" name="logintype" value="admin" checked />
			  <input type="text" class="form-control" name="email" placeholder="Enter UserID" required="" autofocus="" />
			  <input type="password" class="form-control" name="password" placeholder="Enter password" required=""/>     		  
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="ctl00$PageContent$btnsubmit" value="Login" type="Submit">Login</button>  			
		</form>			
	</div>
</div>
<div class="fix">
      </div>
</body>

</html>



<?php
  echo md5('81dc9bdb52d04dc20036dbd8313ed055');


?>