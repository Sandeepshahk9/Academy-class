<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('Master',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="Master";
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");


    $doid=$_REQUEST['upid'];
    $dovalue="course_subject";
  

?>

<div class="content-wrapper">
    <section class="content-header">
        <h1> <?=$_GET['nm']?> <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><?=$_GET['nm']?></a></li>
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
                        <h3 class="box-title"> <?=$_GET['nm']?>   Subject  <small></small></h3>
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
                             
								
								<?php    
								
								 $str=mysqli_query($con,"select * from subject order by name ASC");
                                 while( $row=mysqli_fetch_array($str)) {
									
									$ert = mysqli_query($con,"select id from  course_subject where course_id='".$doid."'  AND  subject_id	='".$row['id']."'  ");
                                    $numrow =mysqli_num_rows($ert);
									
								   ?>
								
								 <div class="form-group">
                                     <input name="course_subject[]" <?php print  ($numrow > 0) ? "Checked" : " "; ?> value="<?=$row['id']?>" type="checkbox" >
                                      <label><?=$row['name']?> </label>  
                                 </div>
								
								<?php } ?>
								
								
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

            