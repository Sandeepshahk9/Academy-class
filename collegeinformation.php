<?php 
include ("include/makeSession.php");
$installment_id=mysqli_query($con,"select * from admin where id='".$_SESSION["ecomid"]."'");
	  $installment_id=mysqli_fetch_array($installment_id); 
$installment_id=$installment_id['menuper'];
	  $menuper=explode(',',$installment_id);
	   
	   if(in_array('Master Setting',$menuper)){
		  
	   }else{
		 
	header("location:index.php");
		   
		}
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");
if(isset($_REQUEST['did']) && $_REQUEST['did']!=''){
	$dovalue="";
	$doid=$_REQUEST['did'];
	mysqli_query($con,"delete from feeheadmaster where id='$doid'");
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=feeheadmaster.php">';
	exit;
}
if(isset($_REQUEST['upid']) && $_REQUEST['upid']!=''){
	  $dovalue="collageinfo";
	  $doid=$_REQUEST['upid'];
	  $upuserresult=mysqli_query($con,"select * from collageinfo where id='".$_REQUEST['upid']."'");
	  $upuserarr=mysqli_fetch_array($upuserresult);
}else{
 	  $dovalue="collageinfo";
	  $doid='';  
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Collage Information <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Collage Information</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
	   <?php if(!empty($_SESSION['msg'])){
			  $msg=$_SESSION["msg"];
           echo '<div class="col-md-12">
			<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  '.$msg.'
		  </div>'; $_SESSION["msg"]='';} ?>
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title"> Collage Information <small></small></h3>
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
              <form method="post" action="action2.php" enctype="multipart/form-data"  role="form">
                <input type="hidden"  name="do" value="<?php echo $dovalue;?>" />
                <input type="hidden"  name="doid" value="<?php echo $doid;?>" />
				 <input type="hidden"  name="UserID" value="<?php echo $_SESSION["ecomid"];?>" />
             
                <!-- text input --> 
				  
                <div class="form-group">
                  <label>Collage Prefix</label>                                    
                  <input name="collagepre" type="text" maxlength="3" class="form-control" value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['collagepre'];}?>" placeholder="Enter Collage Prefix" <?php if(isset($_REQUEST['upid'])){  echo "readonly"; } ?>>                  
                </div>
			 
				   <div class="form-group">
                  <label>Collage Name:</label>                                    
                  <input name="collagename" type="text" class="form-control" value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['collagename'];}?>" placeholder="Enter  Collage Name">                  
                </div> 
                <div class="form-group">
                  <label>Collage Address:</label>                                    
                  <input name="collageaddr" type="text" class="form-control" value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['collageaddr'];}?>" placeholder="Enter Collage Address">                  
                </div> 
               <div class="form-group">
                  <label>Collage Phone:</label>                                    
                  <input name="collagephone" type="text" class="form-control" value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['collagephone'];}?>" placeholder="Enter Collage Phone">                  
                </div>
				  <div class="form-group">
                  <label>Collage Email:</label>                                    
                  <input name="collageemail" type="text" class="form-control" value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['collageemail'];}?>" placeholder="Enter Collage Email">                  
                </div>
				  <div class="row" id='madhyamicmark'>
          <div class="col-md-6">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-6 control-label">Choose LOGO:</label>
                 
                    <input type="file" name="logo" />
                 
                </div>                                               
                </div> 
         <div class="col-md-6">
		 	 <?php if(isset($_REQUEST['upid'])){ ?>
                    <img src="images/uploads/<?php echo $upuserarr['logo']; ?>" height="70" width="70"/>           
 <?php } ?>							
                </div>
             </div>
                <div class="box-footer">
                  <input type="submit" class="btn btn-primary" name="ctl00$ContentPlaceHolder1$btnsave" value="Save"/>
                  <input type="reset" name="ctl00$ContentPlaceHolder1$btn_reset" value="Reset" id="ContentPlaceHolder1_btn_reset" class="btn btn-primary">
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
            <h3 class="box-title">Fee Head Master Report</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>                   
                    <th scope="col">Sr no</th>
                    <th scope="col">Collage Prefix </th>
					<th scope="col">Collage Name</th>
					<th scope="col">Collage Address</th>
                    <th scope="col">Collage Phone</th>
                     <th scope="col">Collage Email</th>
					 <th scope="col">Collage LOGO</th>
					 
                    <th scope="col">Creating Date </th>
					<th scope="col">Entry User </th>
                    <th scope="col">Action</th>
                  </tr>                
              </thead>
              <tbody> 
                <?php $Query=mysqli_query($con,"select *,admin.id as ids,collageinfo.id as id
				from collageinfo left JOIN admin as
			  admin ON collageinfo.user_id=admin.id order by collageinfo.id desc limit 10 ");
			  		$i = 1;
	  				  while($Row=mysqli_fetch_array($Query)){ ?>
                <tr>
			
                  <td><?php echo $i; ?></td>
                  <td><?=$Row['collagepre'];?></td> 
				  <td><?=$Row['collagename'];?></td> 
                  <td><?=$Row['collageaddr'];?></td>
                 <td><?=$Row['collagephone'];?></td>
				  <td><?=$Row['collageemail'];?></td>
				   <td><img src="images/uploads/<?php echo $Row['logo'];?>" height="70" width="70" /></td>
                  <td><?=$Row['created_at'];?></td>
				   <td><?=$Row['username'];?></td>
                  
                  <td><a href="?upid=<?php echo $Row["id"]; ?>"><i class="fa fa-pencil text-yellow"></i></a>&nbsp;&nbsp; <a href="?did=<?php echo $Row["id"]; ?>"><i class="fa fa-remove text-red"></i></a></td>
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

<script src="plugins/datatables/jquery.dataTables.min.js"  type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"  type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"  type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"  type="text/javascript"></script>


<script  type="text/javascript">
$(document).ready(function() {
    $('#example1').DataTable( {
      
        
        
    } );
} );
	//$(function () {
	//$("#example1").DataTable();
	
	//});
</script>