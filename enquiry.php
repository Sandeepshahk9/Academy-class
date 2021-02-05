<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('Enquiry',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="Enquiry";
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");

if(!empty($_REQUEST['did']) && $_REQUEST['did']!=''){
	$dovalue="";
	$doid=$_REQUEST['did'];
	mysqli_query($con,"delete from enquiry where id=".$doid);
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=enquiry_report.php">';
	exit;
}
if(!empty($_REQUEST['upid'])){
    $dovalue="EditEnquiry";
    $doid=$_REQUEST['upid'];
    $Query=mysqli_query($con,"select * from enquiry where id=$doid");
    $Row=mysqli_fetch_array($Query);
}else{
    $dovalue="Enquiry";
    $doid='';
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
        <h1> Enquiry Form <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Enquiry Form</a></li>
        </ol> 
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"> Enquiry Form <small></small></h3>
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
                                    <label>Student Name *</label>                 
                                    <input name="student_name" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['student_name'];}?>" type="text" placeholder="Enter Student Name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Father Name *</label>                 
                                    <input name="father_name" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['father_name'];}?>" type="text" placeholder="Enter Father Name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Mother Name *</label>                 
                                    <input name="mother_name" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['mother_name'];}?>" type="text" placeholder="Enter Mother Name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Address *</label>                 
                                    <textarea name="address" class="form-control" required><?php if(!empty($_REQUEST['upid'])){ echo $Row['address'];}?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Date Of Birth *</label>                 
                                    <input name="dob" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['dob'];}?>" type="date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>10 + 2 Marks *</label>                 
                                    <input name="marks" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['marks'];}?>" type="number" placeholder="Enter 10 + 2 Marks" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Course *</label>
                                    <select name="course_id" class="form-control" required>
                                        <option>- - Select - -</option>
                                    <?php
                                        $courseQ=mysqli_query($con,"select id,name from course order by id desc");
                                        while($courseR=mysqli_fetch_array($courseQ)){
                                    ?>
                                        <option value="<?=$courseR['id'];?>" <?php if(!empty($_REQUEST['upid'])&&$Row['course_id']==$courseR['id']){ echo "selected";}?>><?=$courseR['name'];?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Session *</label>
                                    <select name="session_id" class="form-control" required>
                                        <option>- - Select - -</option>
                                    <?php
                                        if(!empty($_REQUEST['upid'])){
                                        $sessionQ=mysqli_query($con,"select id,name from session where course_id=".$Row['course_id']." order by id desc");
                                        while($sessionR=mysqli_fetch_array($sessionQ)){
                                    ?>
                                        <option value="<?=$sessionR['id'];?>" <?php if(!empty($_REQUEST['upid'])&&$Row['session_id']==$sessionR['id']){ echo "selected";}?>><?=$sessionR['name'];?></option>
                                    <?php
                                        }
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Gender *</label>      
                                    Male:
                                    <input name="gender" value="male" <?php if(!empty($_REQUEST['upid'])&&$Row['gender']=='male'){ echo "checked";}?> type="radio" required />
                                    Female:
                                    <input name="gender" value="female" <?php if(!empty($_REQUEST['upid'])&&$Row['gender']=='female'){ echo "checked";}?> type="radio" required />
                                </div>
                                <div class="form-group">
                                    <label>Type *</label>      
                                    Hostel:
                                    <input name="type" value="hostel" <?php if(!empty($_REQUEST['upid'])&&$Row['type']=='hostel'){ echo "checked";}?> type="radio" required />
                                    Day Boarding:
                                    <input name="type" value="dayboarding" <?php if(!empty($_REQUEST['upid'])&&$Row['type']=='dayboarding'){ echo "checked";}?> type="radio" required />
                                </div>
                                <div class="form-group">
                                    <label>Guranteed? *</label>      
                                    Normal:
                                    <input name="guarantee" value="0" <?php if(!empty($_REQUEST['upid'])&&$Row['guarantee']==0){ echo "checked";} else{ echo "checked";}?> type="radio" required />
                                    Guarantee:
                                    <input name="guarantee" value="1" <?php if(!empty($_REQUEST['upid'])&&$Row['guarantee']==1){ echo "checked";}?> type="radio" required />
                                </div>
                                <div class="form-group">
                                    <label>Image *</label>                 
                                    <input name="image" type="file" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Mobile Numbers *</label>                 
                                    <input name="student_mobile" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['student_mobile'];}?>" type="number" placeholder="Enter Student's Mobile No." class="form-control" required>
                                    <input name="parent_mobile" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['parent_mobile'];}?>" type="number" placeholder="Enter Parent's Mobile No." class="form-control" style="margin-top:10px;" required>
                                </div>
                                <div class="form-group">
                                    <label>Date of Enquiry *</label>                 
                                    <input name="enquiry_date" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['enquiry_date'];} else{ echo date('Y-m-d'); }?>" type="date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Reference </label>                 
                                    <input name="reference" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['reference'];}?>" type="text" placeholder="You heard about us from?" class="form-control">
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
    $("select[name='course_id']").change(function(){
        var course_id=$(this).val();
        $.ajax({  
            type: "POST",  
            url: "json_session.php",  
            data: {'course_id': course_id}, 
            dataType: "json",	
            beforeSend: function(){
                $("body").addClass("loading");
            },
            success: function(response) { 
                $("select[name='session_id']").html("<option value=''>- - Select - -</option>");
                $("select[name='session_id']").append(response);
            },
            complete:function(data){
                $("body").removeClass("loading");
            }
        });
    });
});
</script>