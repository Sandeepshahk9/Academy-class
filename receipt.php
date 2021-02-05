<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('Fee',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="Fee";
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");

if(!empty($_REQUEST['upid'])){
    $Query=mysqli_query($con,"select student_name,registration_no,date,course.name as course_name,session.name as session_name,
        student_mobile,fee_payment.id,sum(fee.amount) as total,discount,sum(fee.amount)-discount as fee,fee_payment.amount,
        register.id as register_id
        from fee_payment
        left join register on register.id=fee_payment.register_id 
        left join course on course.id=register.course_id
        left join session on session.id=register.session_id
        left join fee on fee.session_id=session.id
        where fee_payment.id=".$_REQUEST['upid']." AND fee.type=register.type");
    $Row=mysqli_fetch_array($Query);
    $paid=mysqli_fetch_array(mysqli_query($con,"select sum(amount) as paid from fee_payment where register_id=".$Row['register_id']."
        AND id<".$_REQUEST['upid']))['paid'];
    $remaining=$Row['fee']-$paid-$Row['amount'];
}
?>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
}

@page {
    size: A4;
    margin: 0;
}
@media print {
    .page {
        margin: 0;
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Payment Details <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Payment Details</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Payment details <small></small></h3>
                        <div class="pull-right box-tools">
                            <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div><!-- /. tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="col-md-12">
			                <input type='button' id='btn' value='Print' class='btn btn-primary'>
			                <div class='col-md-12 fff' style=' height:1800px;' id='printarea'> 
			                    <!--Student Copy-->
			                    <div class='row'>
						            <div  style=' height:200px; margin-top:10px;' width="100%" > 
						                <div style="width:200px;float:left;"> 
				                            <img src="images/uploads/favicon.png" width="100px"/>
				                        </div>
						                <div style="width:1000px;text-align:center"> 
					                        <h1>Victory Defence Academy</h1>
					                        <h3  style='margin-top:-5px;'>
					                            Bhiwani Road, Near SDM Office, Badhra<br>Haryana, 127308
			                                    <br>+91-7056676042, +91-7056676042<br>
			                                    <span style="margin-left:200px;">info@victorydefenceacademy.com</span>
			                                    <br>
			                                    <b style='margin-top:13px;text-decoration: underline;margin-left:200px;' >FEE PAYMENT MONEY RECEIPT
				                                </b>
			                                </h3>
                						</div>
                					</div> 
				                    <div style="width:1100px;"> 
						                <div style="width:350px;float:left;"> 
                                			<b>Student Name :</b>   <?=$Row['student_name'];?>  <br>
                                			<b>Registration No :</b>	<?=$Row['registration_no'];?>  <br>
                                			<b>Course :</b>	<?=$Row['course_name'];?>  <br>
				                        </div>
						                <div style="width:350px;float:left;"> 
                        			    	<b>Session :</b>	<?=$Row['session_name'];?>  <br>
                        			        <b>Mobile :</b>	<?=$Row['student_mobile'];?>  <br>
                        		        	<b>Receipt No :</b>	<?=$Row['id'];?>  <br>
					                    </div>
							            <div style="width:350px;float:left;"> 
                        			        <b>Payment Date :</b>
                        			        <?=date("d-m-Y",strtotime($Row['date']));?><br>
                						</div>
                					</div>
					                <table style="width:100%" style='margin-top:220px;' class='pull-right' border='1'>
						                <tr>
						                    <th><b>Particulars</b></th> 
                							<th><b>Amount</b></th>
					                    </tr>
					                    <tr>
					                        <td>Total Course Fee</td>
							                <td><?=$Row['total'];?>.00</td>
						                </tr>
						                <tr>
					                        <td>Discount</td>
							                <td><?=$Row['discount'];?>.00</td>
						                </tr>
						                <tr>
					                        <td>Payable Fee</td>
							                <td><?=$Row['fee'];?>.00</td>
						                </tr>
						                <tr>
						                    <td>Total Amount Paid Till Today</td>
						                    <td><?=$paid;?>.00</td>
					                    </tr>
					                    <tr>
							                <td>Amount Received</td>
							                <td><?=$Row['amount'];?>.00</td>
						                </tr>
							            <tr>
						                    <td><b>Total Due Amount </b></td>
							                <td><b><?=$remaining;?>.00</b></td>
							            </tr>
						            </table>
						            <div class='col-md-12'>
				                        <h3 style='margin-left:20px; '><b></b>
    				                        &nbsp;&nbsp;&nbsp;&nbsp;
        			                        <?php 
        						                $number = $Row['amount'].'.00';
                                                $no = round($number);
                                                $point = round($number - $no, 2) * 100;
                                                $hundred = null;
                                                $digits_1 = strlen($no);
                                                $i = 0;
                                                $str = array();
                                                $words = array('0' => '', '1' => 'One', '2' => 'Two',
                                                '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
                                                '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
                                                '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
                                                '13' => 'Thirteen', '14' => 'Fourteen',
                                                '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
                                                '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
                                                '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
                                                '60' => 'Sixty', '70' => 'Seventy',
                                                '80' => 'Eighty', '90' => 'Ninety');
                                                $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
                                                while ($i < $digits_1) {
                                                $divider = ($i == 2) ? 10 : 100;
                                                $number = floor($no % $divider);
                                                $no = floor($no / $divider);
                                                $i += ($divider == 10) ? 1 : 2;
                                                if ($number) {
                                                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                                                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                                                $str [] = ($number < 21) ? $words[$number] .
                                                    " " . $digits[$counter] . $plural . " " . $hundred
                                                    :
                                                    $words[floor($number / 10) * 10]
                                                    . " " . $words[$number % 10] . " "
                                                    . $digits[$counter] . $plural . " " . $hundred;
                                                } else $str[] = null;
                                                }
                                                $str = array_reverse($str);
                                                $result = implode('', $str);
                                                $points = ($point) ?
                                                "." . $words[$point / 10] . " " . 
                                                  $words[$point = $point % 10] : '';
                                                echo "<b>Rupees ".$result . "Only. </b>";
        					                ?>
					                    </h3>
						                <h4 style='margin-top:10px; '>Student/Guardian's Signature
				                            </br></br></br></br>
                						------------------------------------------
                						</h4>
						            </div> 
						            <div  style="margin-top:-50px; margin-bottom:30px">
                						<h3 class='pull-right' style="margin-top:-50px;">Course fee is NON REFUNDABLE at any circumtances <br><br><br><br><br>
                						    <b>Authorised Signatory with Stamp</b>
                						</h3>
    					            </div>  
							        </br></br></br></br>
							        </br></br></br></br>
						            <div class='col-md-12' style="margin-top:50px">
            						     <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
						            </div>
						        </div>
						        <br><br><br><br><br><br><br><br>
						        <!--College Copy-->
						        <div class='row'>
						            <div  style=' height:200px; margin-top:10px;' width="100%" > 
						                <div style="width:200px;float:left;"> 
				                            <img src="images/uploads/favicon.png" height="100" width="100"/>
				                        </div>
						                <div style="width:1000px;text-align:center"> 
					                        <h1>Victory Defence Academy</h1>
					                        <h3  style='margin-top:-5px;'>
					                            Bhiwani Road, Near SDM Office, Badhra<br>Haryana, 127308
			                                    <br>+91-7056676042, +91-7056676042<br>
			                                    <span style="margin-left:200px;">info@victorydefenceacademy.com</span>
			                                    <br>
			                                    <b style='margin-top:13px;text-decoration: underline;margin-left:200px;' >FEE PAYMENT MONEY RECEIPT
				                                </b>
			                                </h3>
                						</div>
                					</div> 
				                    <div style="width:1100px;"> 
						                <div style="width:350px;float:left;"> 
                                			<b>Student Name :</b>   <?=$Row['student_name'];?>  <br>
                                			<b>Registration No :</b>	<?=$Row['registration_no'];?>  <br>
                                			<b>Course :</b>	<?=$Row['course_name'];?>  <br>
				                        </div>
						                <div style="width:350px;float:left;"> 
                        			    	<b>Session :</b>	<?=$Row['session_name'];?>  <br>
                        			        <b>Mobile :</b>	<?=$Row['student_mobile'];?>  <br>
                        		        	<b>Receipt No :</b>	<?=$Row['id'];?>  <br>
					                    </div>
							            <div style="width:350px;float:left;"> 
                        			        <b>Payment Date :</b>
                        			        <?=date("d-m-Y",strtotime($Row['date']));?><br>
                						</div>
                					</div>
					                <table style="width:100%" style='margin-top:220px;' class='pull-right' border='1'>
						                <tr>
						                    <th><b>Particulars</b></th> 
                							<th><b>Amount</b></th>
					                    </tr>
					                    <tr>
					                        <td>Total Course Fee</td>
							                <td><?=$Row['total'];?>.00</td>
						                </tr>
						                <tr>
					                        <td>Discount</td>
							                <td><?=$Row['discount'];?>.00</td>
						                </tr>
						                <tr>
					                        <td>Payable Fee</td>
							                <td><?=$Row['fee'];?>.00</td>
						                </tr>
						                <tr>
						                    <td>Total Amount Paid Till Today</td>
						                    <td><?=$paid;?>.00</td>
					                    </tr>
					                    <tr>
							                <td>Amount Received</td>
							                <td><?=$Row['amount'];?>.00</td>
						                </tr>
							            <tr>
						                    <td><b>Total Due Amount </b></td>
							                <td><b><?=$remaining;?>.00</b></td>
							            </tr>
						            </table>
						            <div class='col-md-12'>
				                        <h3 style='margin-left:20px; '><b></b>
    				                        &nbsp;&nbsp;&nbsp;&nbsp;
        			                        <?php 
        						                $number = $Row['amount'].'.00';
                                                $no = round($number);
                                                $point = round($number - $no, 2) * 100;
                                                $hundred = null;
                                                $digits_1 = strlen($no);
                                                $i = 0;
                                                $str = array();
                                                $words = array('0' => '', '1' => 'One', '2' => 'Two',
                                                '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
                                                '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
                                                '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
                                                '13' => 'Thirteen', '14' => 'Fourteen',
                                                '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
                                                '18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
                                                '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
                                                '60' => 'Sixty', '70' => 'Seventy',
                                                '80' => 'Eighty', '90' => 'Ninety');
                                                $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
                                                while ($i < $digits_1) {
                                                $divider = ($i == 2) ? 10 : 100;
                                                $number = floor($no % $divider);
                                                $no = floor($no / $divider);
                                                $i += ($divider == 10) ? 1 : 2;
                                                if ($number) {
                                                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
                                                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                                                $str [] = ($number < 21) ? $words[$number] .
                                                    " " . $digits[$counter] . $plural . " " . $hundred
                                                    :
                                                    $words[floor($number / 10) * 10]
                                                    . " " . $words[$number % 10] . " "
                                                    . $digits[$counter] . $plural . " " . $hundred;
                                                } else $str[] = null;
                                                }
                                                $str = array_reverse($str);
                                                $result = implode('', $str);
                                                $points = ($point) ?
                                                "." . $words[$point / 10] . " " . 
                                                  $words[$point = $point % 10] : '';
                                                echo "<b>Rupees ".$result . "Only. </b>";
        					                ?>
					                    </h3>
						                <h4 style='margin-top:10px; '>Student/Guardian's Signature
				                            </br></br></br></br>
                						------------------------------------------
                						</h4>
						            </div> 
						            <div  style="margin-top:-50px; margin-bottom:30px">
                						<h3 class='pull-right' style="margin-top:-50px;">Course fee is NON REFUNDABLE at any circumtances <br><br><br><br><br>
                						    <b>Authorised Signatory with Stamp</b>
                						</h3>
    					            </div>  
							        </br></br></br></br>
							        </br></br></br></br>
						            <div class='col-md-12' style="margin-top:50px">
            						     <!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------  -->
						            </div>
						        </div>
			                </div>
			            </div>
                    </div> 
                </div>   
            </div><!-- /.box -->
        </div><!-- /.col-->
    </section><!-- /.content -->
</div>
<?php include('include/footer.php');?>
<script src='https://cdnjs.cloudflare.com/ajax/libs/PrintArea/2.4.1/jquery.PrintArea.min.js'></script>
<script>
$(document).ready(function() {
   $("#btn").click(function(){
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("#printarea").printArea( options );
    });
   
});
</script>