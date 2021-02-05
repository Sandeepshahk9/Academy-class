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

if(!empty($_REQUEST['did']) && $_REQUEST['did']!=''){
	$dovalue="";
	$doid=$_REQUEST['did'];
	mysqli_query($con,"delete from course where id=".$doid);
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=course.php">';
	exit;
}
if(!empty($_REQUEST['upid']) && $_REQUEST['upid']!=''){
    $dovalue="EditCourse";
    $doid=$_REQUEST['upid'];
    $Query=mysqli_query($con,"select * from course where id=$doid");
    $Row=mysqli_fetch_array($Query);
}else{
    $dovalue="Course";
    $doid='';
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1> Course Form <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Course Form</a></li>
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
                        <h3 class="box-title"> Course Form <small></small></h3>
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
                                    <label>Course Name*</label>                 
                                    <input name="name" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['name'];}?>" type="text" placeholder="Enter Course Name" class="form-control" required>
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
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">View Courses </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" >
        		  		<table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th>#ID</th>
                                    <th scope="col">Course Name</th>
									 <th scope="col">Subject Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $q=mysqli_query($con,"select * from course order by id desc");
                                $i = 1;	
                                while($r=mysqli_fetch_array($q)){ ?>
                                    <tr>
                                        <td>
										    <a href="course_subject.php?upid=<?php echo $r["id"]; ?>&nm=<?=$r['name'];?>"  title="Add Subject"><i class="fa fa-plus text-blue"></i></a>&nbsp;&nbsp; 
										
                                            <a href="?upid=<?php echo $r["id"]; ?>"><i class="fa fa-pencil text-yellow"></i></a>&nbsp;&nbsp; 
                                            <a href="?did=<?php echo $r["id"]; ?>" onclick="return newconfirm_click();" ><i class="fa fa-remove text-red"></i></a>
                                        </td> 
                                        <td><?=$i;?></td>
                                        <td><?=$r['name'];?></td>
										<td>
										<?php  
										
										$str=mysqli_query($con,"select course_subject.subject_id,subject.name


										        from course_subject
                                                
												INNER JOIN subject ON  course_subject.subject_id = subject.id
 
                                      	       where  course_subject.course_id='".$r["id"]."'     ORDER BY name ASC "); 
                                               while( $row = mysqli_fetch_array($str)) {

                                               
										 ?>
										
										 <?=$row['name'].'  , '?>   
										
												<?php  } ?>
										</td>
                                    </tr>                
                                <?php $i++;} ?>                    
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div>
<?php include('include/footer.php');?>
  <script type="text/javascript">
            function newconfirm_click()
            {
                return confirm("Are you sure delete this records ?");
            }
            
            </script>         
            
            