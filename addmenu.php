<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('Menu',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="User";
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");
if(isset($_REQUEST['did']) && $_REQUEST['did']!=''){
	$dovalue="";
	$doid=$_REQUEST['did'];
	mysqli_query($con,"delete from menu where id='$doid'");
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=addmenu.php">';
	exit;
}
if(isset($_REQUEST['upid']) && $_REQUEST['upid']!=''){
	  $dovalue="Menu";
	  $doid=$_REQUEST['upid'];
	  $upuserresult=mysqli_query($con,"select * from menu where id='".$_REQUEST['upid']."'");
	  $upuserarr=mysqli_fetch_array($upuserresult);
}else{
 	  $dovalue="Menu";
	  $doid='';
} 
?>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Menu <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Menu</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title"> Menu Entry <small></small></h3>
            <!-- tools box -->
            <div class="pull-right box-tools">
              <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div>
            <!-- /. tools --> 
          </div>
          <!-- /.box-header -->
          <div class="box-body pad">
            <div class="col-md-8">
              <form method="post" action="action.php" name="addcategory" id="addcategory" enctype="multipart/form-data"  role="form">
                <input type="hidden"  name="do" value="<?php echo $dovalue;?>" />
                <input type="hidden"  name="doid" value="<?php echo $doid;?>" />
                <!-- text input -->
                <div class="form-group">
                  <label>Menu Name</label>
                  <input name="menu" type="text" id="ContentPlaceHolder1_txt_subtitle" class="form-control" value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['menuname'];}?>" placeholder="Enter Language Title">
                </div>                
                <div class="box-footer">
                  <input type="hidden" name="EntryUser" value="<?=$_SESSION['ecomusername'];?>" />	
                  <input type="submit" class="btn btn-primary" name="ctl00$ContentPlaceHolder1$btnsave" value="Save"/>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col--> 
    </div>
    <!-- ./row --> 
  </section>
  <!-- /.content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">REPORT</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th scope="col">Menu</th>
                  <th scope="col">Entry User</th>
                
                </tr>
              </thead>
              <tbody>
                <?php $Query=mysqli_query($con,"select * from menu ");
			  		$i = 1;
	  				  while($Row=mysqli_fetch_array($Query)){ ?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?=$Row['menuname'];?></td>
                  <td>Admin</td>
                <!--  <td><a href="?upid=<?php //echo $Row["id"]; ?>"><i class="fa fa-pencil text-yellow"></i></a>&nbsp;&nbsp; <a href="?did=<?php //echo $Row["id"]; ?>"><i class="fa fa-remove text-red"></i></a></td>  -->
                </tr>
                <?php $i++;} ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </section>
</div>
<?php include('include/footer.php');?>