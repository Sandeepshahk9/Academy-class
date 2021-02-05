<?php 
session_start();
$user_id=$_SESSION['user_id'];
include_once('include/config.inc.php');

$do=mysqli_real_escape_string($con,$_REQUEST['do']);
switch($do)
{
    case "StudentStatus":
        $status=mysqli_real_escape_string($con,$_REQUEST['status']);
        $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
        
        $q=mysqli_query($con,"update register set status='$status' where id=$doid");
        if($q){
		    $_SESSION['msg']="Status Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Status Data Adding Failed!";
		}
		
		header("Location:status.php");
    break;
    case "Test":
	
      
        $register_id=mysqli_real_escape_string($con,$_REQUEST['doid']);
        $weekly_test_id=mysqli_real_escape_string($con,$_REQUEST['weekly_test_id']);
		
		$test_id = $register_id.'-'.$weekly_test_id.'-'.rand(100,9999);
		
		$subject_id =  $_POST['subject_id'];
	    $subject_marks =  $_POST['subject_marks'];
		
		$no_of = count($_POST['subject_id']);
		
        for($key=0;$key <  $no_of ; $key++) {
		
		
        $subject_id1=mysqli_real_escape_string($con,$subject_id[$key]);
        $subject_marks1=mysqli_real_escape_string($con,$subject_marks[$key]);
		
        
        $q=mysqli_query($con,"insert into test (test_id,register_id,weekly_test_id,subject_id,subject_marks,user_id)
		   values('$test_id','$register_id','$weekly_test_id','$subject_id1','$subject_marks1','$user_id')");
		
		
		}
       
	   if($q){
		    $_SESSION['msg']="Test Data Added Successfully";
			
			
		    ///////////////sms code/////////////////////////
			
			$str =mysql_query($con,"select * from   register where registration_no='".$register_id."'");
			$row =mysql_fetch_array($str);
			
			//Multiple mobiles numbers separated by comma
				$mobileNumber = $row['student_mobile'];
                $student_name = $row['student_name'];
				
				  //Your message to send, Add URL encoding here.
				$message = urlencode("Dear ".$student_name. ", your test report is ready now. ");

				//Define route 
				$route = "default";
				//Prepare you post parameters
				$postData = array(
					'authkey' => $authKey,
					'mobiles' => $mobileNumber,
					'message' => $message,
					'sender' => $senderId,
					'route' => $route
				);

				//API URL
				$url="http://sms.bulksmscity.com/api/sendhttp.php";

				// init the resource
				$ch = curl_init();
				curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
					//,CURLOPT_FOLLOWLOCATION => true
				));


				//Ignore SSL certificate verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


				//get response
				$output = curl_exec($ch);
			
			
			////////////////sms  code ////////////////////////////
			
			
			
		}
		else{
			$_SESSION['msg']="Test Data Adding Failed!";
		}
		header("Location:test.php");
    break;
    case "EditTest":
	
	
	    $q=mysqli_query($con,"delete from test where test_id='".$_REQUEST['test_id']."'");
	
	    $register_id=mysqli_real_escape_string($con,$_REQUEST['doid']);
        $weekly_test_id=mysqli_real_escape_string($con,$_REQUEST['weekly_test_id']);
		
		$test_id = $_REQUEST['test_id'];
		
		$subject_id =  $_POST['subject_id'];
	    $subject_marks =  $_POST['subject_marks'];
		
		$no_of = count($_POST['subject_id']);
		
        for($key=0;$key <  $no_of ; $key++) {
		
		
        $subject_id1=mysqli_real_escape_string($con,$subject_id[$key]);
        $subject_marks1=mysqli_real_escape_string($con,$subject_marks[$key]);
		
		 
        $q=mysqli_query($con,"insert into test (test_id,register_id,weekly_test_id,subject_id,subject_marks,user_id)
		   values('$test_id','$register_id','$weekly_test_id','$subject_id1','$subject_marks1','$user_id')");
		
       
        }

	    if($q){
		    $_SESSION['msg']="Test Data Updated Successfully";
			
			
		}
		else{
			$_SESSION['msg']="Test Data Updated Failed!";
		}
		header("Location:test_report_history.php?upid=$register_id");
    break;
    case "Attendance":
        // 0=absent
        // 1=present
        // 2=leave
        $date=mysqli_real_escape_string($con,$_REQUEST['date']);
        $session_id=mysqli_real_escape_string($con,$_REQUEST['doid']);
        $q=mysqli_query($con,"select id from register where session_id=$session_id");
        $attendance="";
        while($r=mysqli_fetch_array($q)){
            $status=mysqli_real_escape_string($con,$_REQUEST["status_".$r['id']]);
            $remark=mysqli_real_escape_string($con,$_REQUEST["remark_".$r['id']]);
            $attendance.=$r['id']."__".$status."__".$remark.",";
        }
        $q=mysqli_query($con,"insert into attendance (date,session_id,status) values('$date','$session_id','$attendance')");
        if($q){
		    $_SESSION['msg']="Attendance Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Attendance Data Adding Failed!";
		}
		header("Location:attendance.php");
    break;
    case "FeePayment":
	    $amount=mysqli_real_escape_string($con,$_REQUEST['amount']);
        $date=mysqli_real_escape_string($con,$_REQUEST['date']);
        $remark=mysqli_real_escape_string($con,$_REQUEST['remark']);
        $register_id=mysqli_real_escape_string($con,$_REQUEST['doid']);
        $q=mysqli_query($con,"insert into fee_payment (amount,date,remark,register_id,user_id) values ('$amount','$date','$remark',
            '$register_id','$user_id')");
        if($q){
		   
		   $_SESSION['msg']="Fee Payment Data Added Successfully";
			
			
			//////////////////sms   code start ////////////////////
			
			$str =mysql_query($con,"select * from   register where registration_no='".$register_id."'");
			$row =mysql_fetch_array($str);
			
			//Multiple mobiles numbers separated by comma
				$mobileNumber = $row['student_mobile'];
                $student_name = $row['student_name'];
				
				 //Your message to send, Add URL encoding here.
				$message = urlencode("Dear ".$student_name. ", We received a payment of ".$amount."₹. ");

				//Define route 
				$route = "default";
				//Prepare you post parameters
				$postData = array(
					'authkey' => $authKey,
					'mobiles' => $mobileNumber,
					'message' => $message,
					'sender' => $senderId,
					'route' => $route
				);

				//API URL
				$url="http://sms.bulksmscity.com/api/sendhttp.php";

				// init the resource
				$ch = curl_init();
				curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
					//,CURLOPT_FOLLOWLOCATION => true
				));


				//Ignore SSL certificate verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


				//get response
				$output = curl_exec($ch);
			
			///////////////end sms code ///////////////////////////
			
			
		}
		else{
			$_SESSION['msg']="Fee Payment Data Adding Failed!";
		}
		header("Location:fee_payment_report.php");
    break;
    case "EditFeePayment":
	    $amount=mysqli_real_escape_string($con,$_REQUEST['amount']);
        $date=mysqli_real_escape_string($con,$_REQUEST['date']);
        $remark=mysqli_real_escape_string($con,$_REQUEST['remark']);
        $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
        $q=mysqli_query($con,"update fee_payment set amount='$amount',date='$date',remark='$remark' where id=$doid");
        if($q){
		    $_SESSION['msg']="Fee Payment Data Updated Successfully";
		}
		else{
			$_SESSION['msg']="Fee Payment Data Update Failed!";
		}
		header("Location:fee_payment_report.php");
    break;
    case "Discount":
	    $discount=mysqli_real_escape_string($con,$_REQUEST['discount']);
	    $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    
		$q=mysqli_query($con,"update register set discount='$discount' where id=$doid");
		if($q){
		    $_SESSION['msg']="Discount Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Discount Data Adding Failed!";
		}
		header("Location:register_report.php");
	break;
    case "Fee":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $type=mysqli_real_escape_string($con,$_REQUEST['type']);
	    $amount=mysqli_real_escape_string($con,$_REQUEST['amount']);
	    
		$q=mysqli_query($con,"insert into fee (name,session_id,course_id,amount,user_id,type) 
		    values ('$name','$session_id','$course_id','$amount','$user_id','$type')");
		if($q){
		    $_SESSION['msg']="Fee Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Fee Data Adding Failed!";
		}
		header("Location:fee.php");
	break;
	case "EditFee":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $amount=mysqli_real_escape_string($con,$_REQUEST['amount']);
	    $type=mysqli_real_escape_string($con,$_REQUEST['type']);
	    $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    
		$q=mysqli_query($con,"update fee set type='$type',name='$name',session_id='$session_id',course_id='$course_id',
		    amount='$amount' where id=$doid");
		if($q){
		    $_SESSION['msg']="Fee Data Updated Successfully";
		}
		else{
			$_SESSION['msg']="Fee Data Update Failed!";
		}
		header("Location:fee.php");
	break;
    case "Register":
	    $student_name=mysqli_real_escape_string($con,$_REQUEST['student_name']);
	    $father_name=mysqli_real_escape_string($con,$_REQUEST['father_name']);
	    $mother_name=mysqli_real_escape_string($con,$_REQUEST['mother_name']);
	    $address=mysqli_real_escape_string($con,$_REQUEST['address']);
	    $dob=mysqli_real_escape_string($con,$_REQUEST['dob']);
	    $marks=mysqli_real_escape_string($con,$_REQUEST['marks']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $gender=mysqli_real_escape_string($con,$_REQUEST['gender']);
	    $student_mobile=mysqli_real_escape_string($con,$_REQUEST['student_mobile']);
	    $parent_mobile=mysqli_real_escape_string($con,$_REQUEST['parent_mobile']);
	    $enquiry_date=mysqli_real_escape_string($con,$_REQUEST['enquiry_date']);
	    $reference=mysqli_real_escape_string($con,$_REQUEST['reference']);
	    $remark=mysqli_real_escape_string($con,$_REQUEST['remark']);
	    $guarantee=mysqli_real_escape_string($con,$_REQUEST['guarantee']);
	    $type=mysqli_real_escape_string($con,$_REQUEST['type']);
	    $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
	    if($_FILES['image']['name']!=null){
	        $image=time()."_".$_FILES['image']['name'];
	        move_uploaded_file($_FILES['image']['tmp_name'],"images/student/".$image);
	    }
		$q=mysqli_query($con,"insert into register (guarantee,student_name,father_name,mother_name,
		    address,dob,marks,course_id,gender,student_mobile,parent_mobile,
		    enquiry_date,reference,remark,user_id,image,session_id,type) 
		    values ('$guarantee','$student_name','$father_name','$mother_name',
		    '$address','$dob','$marks','$course_id','$gender','$student_mobile','$parent_mobile',
		    '$enquiry_date','$reference','$remark','$user_id','$image','$session_id','$type')");
		$insert_id=$con->insert_id;
		$registration_no="VICTORY".str_pad($insert_id, 4, '0', STR_PAD_LEFT);
		$q=mysqli_query($con,"update register set registration_no='$registration_no' where id='$insert_id'");
		if($q){
		   
 		        $_SESSION['msg']="Registeration Data Added Successfully";
			
			

				//Multiple mobiles numbers separated by comma
				$mobileNumber = $student_mobile;

				
				 //Your message to send, Add URL encoding here.
				$message = urlencode("Hii ".$student_name. ",  you  registered  successfully with us. Your Registration Number  is  ".$registration_no."");

				//Define route 
				$route = "default";
				//Prepare you post parameters
				$postData = array(
					'authkey' => $authKey,
					'mobiles' => $mobileNumber,
					'message' => $message,
					'sender' => $senderId,
					'route' => $route
				);

				//API URL
				$url="http://sms.bulksmscity.com/api/sendhttp.php";

				// init the resource
				$ch = curl_init();
				curl_setopt_array($ch, array(
					CURLOPT_URL => $url,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
					//,CURLOPT_FOLLOWLOCATION => true
				));


				//Ignore SSL certificate verification
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


				//get response
				$output = curl_exec($ch);



		}
		else{
			$_SESSION['msg']="Registeration Data Adding Failed!";
		}
		header("Location:register_report.php");
	break;
	case "EditRegister":
	    $student_name=mysqli_real_escape_string($con,$_REQUEST['student_name']);
	    $father_name=mysqli_real_escape_string($con,$_REQUEST['father_name']);
	    $mother_name=mysqli_real_escape_string($con,$_REQUEST['mother_name']);
	    $address=mysqli_real_escape_string($con,$_REQUEST['address']);
	    $dob=mysqli_real_escape_string($con,$_REQUEST['dob']);
	    $marks=mysqli_real_escape_string($con,$_REQUEST['marks']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $gender=mysqli_real_escape_string($con,$_REQUEST['gender']);
	    $student_mobile=mysqli_real_escape_string($con,$_REQUEST['student_mobile']);
	    $parent_mobile=mysqli_real_escape_string($con,$_REQUEST['parent_mobile']);
	    $enquiry_date=mysqli_real_escape_string($con,$_REQUEST['enquiry_date']);
	    $reference=mysqli_real_escape_string($con,$_REQUEST['reference']);
	    $remark=mysqli_real_escape_string($con,$_REQUEST['remark']);
	    $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
	    $guarantee=mysqli_real_escape_string($con,$_REQUEST['guarantee']);
	    $type=mysqli_real_escape_string($con,$_REQUEST['type']);
	    $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    if($_FILES['image']['name']!=null){
	        $image=mysqli_fetch_array(mysqli_query($con,"select image from register where id='$doid'"))['image'];
	        if(!empty($image)){
	            unlink("images/student/".$image);
	        }
	        $image=time()."_".$_FILES['image']['name'];
	        move_uploaded_file($_FILES['image']['tmp_name'],"images/student/".$image);
	        mysqli_query($con,"update register set image='$image' where id='$doid'");
	    }
		$q=mysqli_query($con,"update register set guarantee='$guarantee',student_name='$student_name',father_name='$father_name',
		    mother_name='$mother_name',
		    address='$address',dob='$dob',marks='$marks',course_id='$course_id',gender='$gender',student_mobile='$student_mobile',
		    parent_mobile='$parent_mobile',
		    enquiry_date='$enquiry_date',reference='$reference',remark='$remark',user_id='$user_id',session_id='$session_id',
		    type='$type'
		    where id=$doid");
		if($q){
		    $_SESSION['msg']="Registeration Data Updated Successfully";
		}
		else{
			$_SESSION['msg']="Registeration Data Update Failed!";
		}
		header("Location:register_report.php");
	break;
    case "EnquiryRegister":
	    $student_name=mysqli_real_escape_string($con,$_REQUEST['student_name']);
	    $father_name=mysqli_real_escape_string($con,$_REQUEST['father_name']);
	    $mother_name=mysqli_real_escape_string($con,$_REQUEST['mother_name']);
	    $address=mysqli_real_escape_string($con,$_REQUEST['address']);
	    $dob=mysqli_real_escape_string($con,$_REQUEST['dob']);
	    $marks=mysqli_real_escape_string($con,$_REQUEST['marks']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $gender=mysqli_real_escape_string($con,$_REQUEST['gender']);
	    $student_mobile=mysqli_real_escape_string($con,$_REQUEST['student_mobile']);
	    $parent_mobile=mysqli_real_escape_string($con,$_REQUEST['parent_mobile']);
	    $enquiry_date=mysqli_real_escape_string($con,$_REQUEST['enquiry_date']);
	    $reference=mysqli_real_escape_string($con,$_REQUEST['reference']);
	    $remark=mysqli_real_escape_string($con,$_REQUEST['remark']);
	    $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
	    $type=mysqli_real_escape_string($con,$_REQUEST['type']);
	    $guarantee=mysqli_real_escape_string($con,$_REQUEST['guarantee']);
	    $enquiry_id=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    $image="";
	    if($_FILES['image']['name']!=null){
	        $image=time()."_".$_FILES['image']['name'];
	        move_uploaded_file($_FILES['image']['tmp_name'],"images/student/".$image);
	    }
		$q=mysqli_query($con,"insert into register (guarantee,student_name,father_name,mother_name,
		    address,dob,marks,course_id,gender,student_mobile,parent_mobile,
		    enquiry_date,reference,remark,user_id,enquiry_id,image,session_id,type) 
		    values ('$guarantee','$student_name','$father_name','$mother_name',
		    '$address','$dob','$marks','$course_id','$gender','$student_mobile','$parent_mobile',
		    '$enquiry_date','$reference','$remark','$user_id','$enquiry_id','$image','$session_id','$type')");
		$insert_id=$con->insert_id;
		$registration_no="VICTORY".str_pad($insert_id, 4, '0', STR_PAD_LEFT);
		$q=mysqli_query($con,"update register set registration_no='$registration_no' where id='$insert_id'");
		if($q){
		    $_SESSION['msg']="Enquiry Registeration Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Enquiry Registeration Data Adding Failed!";
		}
		header("Location:register_report.php");
	break;
  
  case "Course":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    
		$q=mysqli_query($con,"insert into course (name,user_id) 
		    values ('$name','$user_id')");
		if($q){
		    $_SESSION['msg']="Course Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Course Data Adding Failed!";
		}
		header("Location:course.php");
	break;
	case "EditCourse":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    
		$q=mysqli_query($con,"update course set name='$name',user_id='$user_id' where id=$doid");
		if($q){
		    $_SESSION['msg']="Course Data Updated Successfully";
		}
		else{
			$_SESSION['msg']="Course Data Update Failed!";
		}
		header("Location:course.php");
	break;
	
	
	


	case "Subject":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    
		$q=mysqli_query($con,"insert into subject (name) 
		    values ('$name')");
		if($q){
		    $_SESSION['msg']="Subject Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Subject Data Adding Failed!";
		}
		header("Location:subject.php");
	break;
	case "EditSubject":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    
		$q=mysqli_query($con,"update subject set name='$name' where id=$doid");
		if($q){
		    $_SESSION['msg']="Subject Data Updated Successfully";
		}
		else{
			$_SESSION['msg']="Subject Data Update Failed!";
		}
		header("Location:subject.php");
	break;
	
	
	////////////////course subject  /////////////////////
	
	case "course_subject":
	
	    $course_id=$_POST['doid'];
	    $subject_id=$_POST['course_subject'];
		
		$de =mysqli_query($con,"Delete from  course_subject where course_id='".$course_id."' ");
		
		
		foreach($subject_id  as $value){
			
			
			$q=mysqli_query($con,"insert into course_subject (course_id,subject_id) 
		    values ('$course_id','$value')");
		}
	 
		if($q){
		    $_SESSION['msg']="Course Subject Data Added Successfully";
		}
		else{
			$_SESSION['msg']=" Course Subject Data Adding Failed!";
		}
		header("Location:course.php");
	 break;
	
	///////////////////////////course subject ////////////////////
	
	
	case "Session":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $duration=mysqli_real_escape_string($con,$_REQUEST['duration']);
	    
		$q=mysqli_query($con,"insert into session (name,course_id,duration,user_id) 
		    values ('$name','$course_id','$duration','$user_id')");
		if($q){
		    $_SESSION['msg']="Session Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Session Data Adding Failed!";
		}
		header("Location:session.php");
	break;
	case "EditSession":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $duration=mysqli_real_escape_string($con,$_REQUEST['duration']);
	    $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    
		$q=mysqli_query($con,"update session set name='$name',course_id='$course_id',duration='$duration' where id=$doid");
		if($q){
		    $_SESSION['msg']="Session Data Updated Successfully";
		}
		else{
			$_SESSION['msg']="Session Data Update Failed!";
		}
		header("Location:session.php");
	break;
	case "Enquiry":
	    $student_name=mysqli_real_escape_string($con,$_REQUEST['student_name']);
	    $father_name=mysqli_real_escape_string($con,$_REQUEST['father_name']);
	    $mother_name=mysqli_real_escape_string($con,$_REQUEST['mother_name']);
	    $address=mysqli_real_escape_string($con,$_REQUEST['address']);
	    $dob=mysqli_real_escape_string($con,$_REQUEST['dob']);
	    $marks=mysqli_real_escape_string($con,$_REQUEST['marks']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $gender=mysqli_real_escape_string($con,$_REQUEST['gender']);
	    $student_mobile=mysqli_real_escape_string($con,$_REQUEST['student_mobile']);
	    $parent_mobile=mysqli_real_escape_string($con,$_REQUEST['parent_mobile']);
	    $enquiry_date=mysqli_real_escape_string($con,$_REQUEST['enquiry_date']);
	    $reference=mysqli_real_escape_string($con,$_REQUEST['reference']);
	    $remark=mysqli_real_escape_string($con,$_REQUEST['remark']);
	    $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
	    $type=mysqli_real_escape_string($con,$_REQUEST['type']);
	    $guarantee=mysqli_real_escape_string($con,$_REQUEST['guarantee']);
	    $enquiry_id=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    $image="";
	    if($_FILES['image']['name']!=null){
	        $image=time()."_".$_FILES['image']['name'];
	        move_uploaded_file($_FILES['image']['tmp_name'],"images/student/".$image);
	    }
		$q=mysqli_query($con,"insert into enquiry (guarantee,student_name,father_name,mother_name,
		    address,dob,marks,course_id,gender,student_mobile,parent_mobile,
		    enquiry_date,reference,remark,user_id,enquiry_id,image,session_id,type) 
		    values ('$guarantee','$student_name','$father_name','$mother_name',
		    '$address','$dob','$marks','$course_id','$gender','$student_mobile','$parent_mobile',
		    '$enquiry_date','$reference','$remark','$user_id','$enquiry_id','$image','$session_id','$type')");
		if($q){
		    $_SESSION['msg']="Enquiry Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Enquiry Data Adding Failed!";
		}
		header("Location:enquiry_report.php");
	break;
	case "EditEnquiry":
	    $student_name=mysqli_real_escape_string($con,$_REQUEST['student_name']);
	    $father_name=mysqli_real_escape_string($con,$_REQUEST['father_name']);
	    $mother_name=mysqli_real_escape_string($con,$_REQUEST['mother_name']);
	    $address=mysqli_real_escape_string($con,$_REQUEST['address']);
	    $dob=mysqli_real_escape_string($con,$_REQUEST['dob']);
	    $marks=mysqli_real_escape_string($con,$_REQUEST['marks']);
	    $course_id=mysqli_real_escape_string($con,$_REQUEST['course_id']);
	    $gender=mysqli_real_escape_string($con,$_REQUEST['gender']);
	    $student_mobile=mysqli_real_escape_string($con,$_REQUEST['student_mobile']);
	    $parent_mobile=mysqli_real_escape_string($con,$_REQUEST['parent_mobile']);
	    $enquiry_date=mysqli_real_escape_string($con,$_REQUEST['enquiry_date']);
	    $reference=mysqli_real_escape_string($con,$_REQUEST['reference']);
	    $remark=mysqli_real_escape_string($con,$_REQUEST['remark']);
	    $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
	    $type=mysqli_real_escape_string($con,$_REQUEST['type']);
	    $guarantee=mysqli_real_escape_string($con,$_REQUEST['guarantee']);
	    $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    if($_FILES['image']['name']!=null){
	        $image=mysqli_fetch_array(mysqli_query($con,"select image from enquiry where id='$doid'"))['image'];
	        if(!empty($image)){
	            unlink("images/student/".$image);
	        }
	        $image=time()."_".$_FILES['image']['name'];
	        move_uploaded_file($_FILES['image']['tmp_name'],"images/student/".$image);
	        mysqli_query($con,"update register set image='$image' where id='$doid'");
	    }
		$q=mysqli_query($con,"update enquiry set guarantee='$guarantee',student_name='$student_name',father_name='$father_name',
		    mother_name='$mother_name',
		    address='$address',dob='$dob',marks='$marks',course_id='$course_id',gender='$gender',student_mobile='$student_mobile',
		    parent_mobile='$parent_mobile',
		    enquiry_date='$enquiry_date',reference='$reference',remark='$remark',user_id='$user_id',session_id='$session_id',
		    type='$type'
		    where id=$doid");
		if($q){
		    $_SESSION['msg']="Enquiry Data Updated Successfully";
		}
		else{
			$_SESSION['msg']="Enquiry Data Update Failed!";
		}
		header("Location:enquiry_report.php");
	break;
	case "Menu" :
        $menu = mysqli_escape_string($con,$_REQUEST['menu']);
		$UserID = mysqli_escape_string($con,$_REQUEST['EntryUser']);
		if(!empty($_REQUEST['doid'])){
				
					$check=mysqli_query($con,"update  menu set menuname='".$menu."'
					where id=".(int)$_REQUEST['doid']);
					if($check){
						$_SESSION['msg']=' Record Updated Successfully .';
					}else{
						$_SESSION['msg']='Record Not Updated Failed! ';
					}
				
			}else{
			$check=mysqli_query($con,"insert into menu(user_id,menuname)
					values('".$UserID."','".$menu."')");
				
					if($check){
						$_SESSION['msg']=' Record Add Successfully .';
					}else{
						$_SESSION['msg']='Record Not Add Failed! ';
					}
			}
			
        header("Location:addmenu.php");
		break;
		
		
	case "usercreate" :
        $name = mysqli_escape_string($con,$_REQUEST['name']);
		 $username = mysqli_escape_string($con,$_REQUEST['username']);
		  $email = mysqli_escape_string($con,$_REQUEST['email']);
		  $password = mysqli_escape_string($con,$_REQUEST['password']);
		   $password=md5($password);
		   $mobile = mysqli_escape_string($con,$_REQUEST['mobile']);
		    $role = mysqli_escape_string($con,$_REQUEST['role']);
			 $per = $_REQUEST['per'];
			$menu=implode(',',$per);
			
		$UserID = mysqli_escape_string($con,$_REQUEST['UserID']);
		if(!empty($_REQUEST['doid'])){
				
					$check=mysqli_query($con,"update  admin set menuper='".$menu."',mobile='".$mobile."'
					,mobile='".$mobile."',name='".$name."',user_id='".$UserID."',role='".$role."'  where id=".(int)$_REQUEST['doid']);
					if($check){
						$_SESSION['msg']=' Record Updated Successfully .';
					}else{
						$_SESSION['msg']='Record Not Updated Failed! ';
					}
				
			}else{
				$upuserresult=mysqli_query($con,"select * from admin where email='".$email."' or username='".$username."' ");
	  $row=mysqli_num_rows($upuserresult);
	  if($row>0){
		  $_SESSION['msg']='Email Id Allready Exits ! '; 
	  }else{
			$check=mysqli_query($con,"insert into admin(password,username,email,role,mobile,menuper,name,user_id)
					values('".$password."','".$username."','".$email."','".$role."',
					'".$mobile."','".$menu."','".$name."','".$UserID."')");
				
					if($check){
						$_SESSION['msg']=' Record Add Successfully .';
					}else{
						$_SESSION['msg']='Record Not Add Failed! ';
					}
			}
		}
			
        header("Location:usersreports.php");
		break;
	case "WeeklyTest":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    $date=mysqli_real_escape_string($con,$_REQUEST['date']);
	    
		$q=mysqli_query($con,"insert into weekly_test (name,date,user_id) 
		    values ('$name','$date','$user_id')");
		if($q){
		    $_SESSION['msg']="Weekly Test Data Added Successfully";
		}
		else{
			$_SESSION['msg']="Weekly Test Data Adding Failed!";
		}
		header("Location:weekly_test.php");
	break;
	case "EditWeeklyTest":
	    $name=mysqli_real_escape_string($con,$_REQUEST['name']);
	    $date=mysqli_real_escape_string($con,$_REQUEST['date']);
	    $doid=mysqli_real_escape_string($con,$_REQUEST['doid']);
	    
		$q=mysqli_query($con,"update weekly_test set name='$name',date='$date',user_id='$user_id' where id=$doid");
		if($q){
		    $_SESSION['msg']="Weekly Test Data Updated Successfully";
		}
		else{
			$_SESSION['msg']="Weekly Test Data Update Failed!";
		}
		header("Location:weekly_test.php");
	break;
}
?>