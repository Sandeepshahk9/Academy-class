<?php
@ob_start();
include ("include/config.inc.php");
if($_REQUEST['logintype']=="admin"){
    if(isset($_POST['email'])){	
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    $password =$password;
    $sql= "select * from admin where password='$password' AND (username='$email' OR email='$email');";
    $result = mysqli_query($con,$sql);
    $row=mysqli_fetch_array($result);
    if($row['email'] && $row['password'] && $row['username']){
    			session_start();
    			$_SESSION['user_id'] = $row['id'];
    			//if found redirect to admin home page
    			header("Location:Dashboard.php");
    			exit();
    }else{
    session_start();
    $_SESSION['errmessage'] = 'Invalid Details. Please try again.';
    }
    header("Location:index.php");
    }else{
    	echo "Something went wrong.";
    }
}else if($_REQUEST['logintype']=="student"){
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);
    
    $Q=mysqli_query($con,"select username,password,id,name from admission_enquiry_form where username='".$email."' AND password='".$password."'");
    $R=mysqli_fetch_array($Q);
    $N=mysqli_num_rows($Q);
    if($N>0){
        if($R['password'] && $R['username']){
			session_start();
			$_SESSION['user_id'] = $R['id'];
			//if found redirect to admin home page
			header("Location:/student/view_book.php");
			exit();
        }else{
        session_start();
        $_SESSION['errmessage'] = 'Invalid Details. Please try again.';
        }
        header("Location:index.php");
    }else{
        session_start();
        $_SESSION['errmessage'] = 'Invalid Details. Please try again.';
        header("Location:index.php");
    }
}else{
    echo "Something went wrong.";
}
?>