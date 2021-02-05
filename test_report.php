<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('Test',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="Test";
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");

if(!empty($_REQUEST['did'])){
    $page=$_REQUEST['page'];
    $q=mysqli_query($con,"delete from test where test_id='".$_REQUEST['did']."'");
    if($q){
    	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=test_report_history.php?upid='.$page.'">';
    }
	exit;
}
if(!empty($_REQUEST['upid'])){
    $doid=$_REQUEST['page'];
    $dovalue="EditTest";
	$test_id=$_REQUEST['upid'];
	
    $Row=mysqli_fetch_array(mysqli_query($con,"select * from test where test_id='".$test_id."' GROUP BY test_id "));
	
}else if(!empty($_REQUEST['add'])){
    $dovalue="Test";
    $doid=$_REQUEST['add'];
}
?>
<style>
    #loader{
        display:none;
        position:fixed;
        z-index:1000;
        top:0;
        left:0;
        width:100%;
        height:100%;
        background-image:url(images/uploads/loader.gif);
        background-position:50% 50%;
        background-color:rgba(255,255,255,0.6);
        background-repeat:no-repeat;
    }
    body.loading{
        overflow:hidden;
    }
    body.loading #loader{
        display:block;
    }
</style>
<div id="loader"></div>
<div class="content-wrapper">
    <section class="content-header">
        <h1> Test Report <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Test Report</a></li>
        </ol> 
        <?php if(!empty($_SESSION['msg'])){
    $msg=$_SESSION["msg"];
    echo '<div class="col-md-8">
            <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            '.$msg.'
            </div>'; 
    $_SESSION["msg"]='';} ?>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title"> Test Report <small></small></h3>
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
                                <input type="hidden"  name="test_id" value="<?php echo $test_id;?>" /> 
								 
								 
                                <div class="form-group">
                                    <label>Test Name *</label>
                                    <select name="weekly_test_id" class="form-control" required>
                                        <option>- - Select - -</option>
                                    <?php
                                        $testQ=mysqli_query($con,"select id,name from weekly_test order by id desc");
                                        while($testR=mysqli_fetch_array($testQ)){
                                    ?>
                                        <option value="<?=$testR['id'];?>" <?php if(!empty($_REQUEST['upid'])&&$Row['weekly_test_id']==$testR['id']){ echo "selected";}?>><?=$testR['name'];?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date *</label>                 
                                    <input name="date" id="date"  type="date" value="<?php if(!empty($_REQUEST['upid'])){ 
									 $Row2=mysqli_fetch_array(mysqli_query($con,"select date from weekly_test where  id='".$Row['weekly_test_id']."' "));
									
									 echo $Row2['date'];}?>" class="form-control" required readonly>
                                 </div>
								
								
								 <?php 
								
								$str = mysqli_query($con,"select  course_id  from   register  where id='".$doid."'");
								$row = mysqli_fetch_array($str);  
								
								$str2 = mysqli_query($con,"
								
								               select course_subject.subject_id,subject.name,subject.id


										        from course_subject
                                                
												INNER JOIN subject ON  course_subject.subject_id = subject.id
 
                                      	       where  course_subject.course_id='".$row['course_id']."'     ORDER BY name ASC 
								
								             ");
								
								
								     while($row2 = mysqli_fetch_array($str2)){
								
								
							       ?>
								
								
								   <input name="subject_id[]" value="<?=$row2['id']?>" type="hidden"/>
                                   <div class="form-group">
                                     <label><?=$row2['name']?> *</label>                 
                                    <input name="subject_marks[]" value="<?php if(!empty($_REQUEST['upid'])){ 
									 $Row3=mysqli_fetch_array(mysqli_query($con,"select subject_marks from test where 
  									        test_id='".$test_id."'  AND subject_id='".$row2['id']."' "));
									
									echo $Row3['subject_marks'];}
									
									?>" type="text" placeholder="Enter <?=$row2['name']?>  Marks" class="form-control" required>
                                    </div>
                              
								
								<?php  } ?>
								
								
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
    $("select[name='weekly_test_id']").select2();
    $("select[name='weekly_test_id']").change(function(){
        var test_id=$(this).val();
        $.ajax({  
            type: "POST",  
            url: "json_weekly_test.php",  
            data: {'test_id': test_id}, 
            beforeSend: function(){
                $("body").addClass("loading");
            },
            success: function(response) { 
                $("#date").val(response);
            },
            complete:function(data){
                $("body").removeClass("loading");
            }
        });
    });
    
});
</script>