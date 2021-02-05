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

if(!empty($_REQUEST['did']) && $_REQUEST['did']!=''){
	$dovalue="";
	$doid=$_REQUEST['did'];
	mysqli_query($con,"delete from fee_payment where id=".$doid);
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=fee_payment_report.php">';
	exit;
}
if(!empty($_REQUEST['upid'])){
    $dovalue="FeePayment";
    $doid=$_REQUEST['upid'];
    $Query=mysqli_query($con,"select student_name,discount,session_id,type from register where id=$doid");
    $Row=mysqli_fetch_array($Query);
    $fee=mysqli_fetch_array(mysqli_query($con,"select sum(amount) as fee from fee where session_id=".$Row['session_id']." AND type='".$Row['type']."'"))['fee'];
    $total=mysqli_fetch_array(mysqli_query($con,"select sum(amount) as total from fee_payment where register_id=$doid"))['total'];
    $amount=$fee-$total-$Row['discount'];
    echo "<script>alert('$fee');</script>";
}
?>
<?php if(!empty($_SESSION['msg'])){
    $msg=$_SESSION["msg"];
    echo '<div class="col-md-8">
            <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            '.$msg.'
            </div>'; 
    $_SESSION["msg"]='';} ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1> Fee Payment Form <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Fee Payment Form</a></li>
        </ol> 
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"> Fee Payment Form <small></small></h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div><!-- /. tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body pad">
                        <div class="col-md-8">
                            <form method="post" action="action.php" name="addcategory" id="addcategory" enctype="multipart/form-data"  role="form">
                                <input type="hidden"  name="do" value="<?php echo $dovalue;?>" />
                                <input type="hidden"  name="doid" value="<?php echo $doid;?>" />
                                
                                <div class="form-group">
                                    <label>Payment Date *</label>                 
                                    <input name="date" value="<?=date("Y-m-d");?>" type="date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Amount *</label>                 
                                    <input name="amount" value="<?=$amount;?>" type="number" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Remark (If Any) </label>                 
                                    <input name="remark" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['remark'];}?>" type="text" placeholder="Enter Remarks" class="form-control">
                                </div>
                                <div class="row">                                                            
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="submit" id="submit" class="btn btn-primary" value="Save"/>
                                        <input type="reset" value="Reset" class="btn btn-primary"/>           
                                    </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div><!-- /.col-->
        </div><!-- ./row -->
    </section><!-- /.content -->
</div>
<?php include('include/footer.php');?>
<script>
$(document).ready(function(){
    var maximum=parseInt($("input[name='amount']").val());
    $("input[name='amount']").keyup(function(){
        if(parseInt($(this).val())>maximum){
            alert("You Cannot Exceed the maximum Payable Amount: "+maximum);
            $(this).val(maximum);
        }else if(parseInt($(this).val())<0){
            alert("Enter a value greater than 0");
        }
    });
});
</script>