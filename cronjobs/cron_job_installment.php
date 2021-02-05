<?php 


session_start();
include_once('../include/config.inc.php');
include_once('../sendmessage.php');
include_once('../include/function.php');

$setinstallmentQ=mysqli_query($con,"select setinstallment.id,setinstallment.amount,setinstallment.studentid,admission_enquiry_form.name,admission_enquiry_form.mobileno from setinstallment
left join admission_enquiry_form on admission_enquiry_form.student_id=setinstallment.studentid where DATE(installmentdate) = CURRENT_DATE() + INTERVAL 7 DAY");

while($R=mysqli_fetch_array($setinstallmentQ)){
    $exist=mysqli_num_rows(mysqli_query($con,"select id from payinstallment where installment_id='".$R['id']."'"));
    if(empty($exist)){
        $x++;
        $sms="Kadambini Women's College Of Education\nYour Installment is Due in 7 days after that fine will be charged! Pay the amount Rs. ".$R['amount']
        ."\nStudent ID: ".$R['studentid']
        ."\nName: ".$R['name'];
        sendsms($con,$R['mobileno'],$sms);
    }
}
?>