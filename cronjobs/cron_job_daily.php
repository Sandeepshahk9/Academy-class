<?php 


session_start();
include_once('../include/config.inc.php');
include_once('../sendmessage.php');
include_once('../include/function.php');

$mobilesQ=mysqli_query($con,"select mobile1,mobile2,mobile3 from collageinfo where id=1");
$R=mysqli_fetch_array($mobilesQ);


$admission=mysqli_num_rows(mysqli_query($con,"select id from admission_enquiry_form where created_at>=CURRENT_DATE()"));
$monthlyfee=mysqli_fetch_array(mysqli_query($con,"select sum(payment_amount) as amount from paymonthlyfee where created_at=CURRENT_DATE()"))['amount'];
$onetimefee=mysqli_fetch_array(mysqli_query($con,"select sum(payment_amount) as amount from payonetimefee where created_at=CURRENT_DATE()"))['amount'];
$otherfee=$monthlyfee+$onetimefee;
$booking=mysqli_num_rows(mysqli_query($con,"select * from student_enqury_form where DATE(created_at)>=CURRENT_DATE()"));
$installments=mysqli_fetch_array(mysqli_query($con,"select sum(payment_amount) as amount from payinstallment where created_at>=CURRENT_DATE()"))['amount'];
$expense=mysqli_fetch_array(mysqli_query($con,"select sum(Pay_Amount) as amount from PartyTranctions where created_at=CURRENT_DATE()"))['amount'];
$cashinhand=mysqli_fetch_array(mysqli_query($con,"select cash from totalcash where id=1"))['cash'];
$bank=mysqli_fetch_array(mysqli_query($con,"select sum(bank_amount) as bankamount from bankdetails"))['bankamount'];
$due=mysqli_fetch_array(mysqli_query($con,"select sum(dueamount) as dueamount from admission_enquiry_form"))['dueamount'];

//Sending SMS:
	$sms="Kadambini Women's College Of Education \n Booking: ".$booking." \n Admission: ".$admission." \n Installments: Rs.".$installments." \n Other Fees: ".$otherfee." \n Expense: Rs.".$expense." \n "
	."Cash in Hand: Rs.".$cashinhand." \n Bank: Rs.".$bank." \n Unpaid Installments: Rs.".$due." \n ".date('d-m-Y')." \nKadambini Women's College Of Education";
	sendsms($con,$R['mobile1'],$sms);
	sendsms($con,$R['mobile2'],$sms);
	sendsms($con,$R['mobile3'],$sms);
?>