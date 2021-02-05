<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('User',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="User";
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");
if(isset($_REQUEST['did']) && $_REQUEST['did']!=''){
	$dovalue="";
	$doid=$_REQUEST['did'];
	
	$check=mysqli_query($con,"delete from admin where id='$doid'");
	
	if($check){
	$_SESSION['msg']='Record Deleted Successfully';
	}
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=usersreports.php">';
	exit;
}
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1> Users Reports</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Users Reports</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Users Reports :</h3>
		
          </div><!-- /.box-header -->
          <div class="box-body table-responsive">
		  		
            <table id="example1" class="table table-bordered table-striped">
			  <?php if(!empty($_SESSION['msg'])){
			  $msg=$_SESSION["msg"];
           echo '<div class="col-md-8">
			<div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  '.$msg.'
		  </div>'; $_SESSION["msg"]='';} ?>
              <thead>
                <tr>
                  <th>#ID</th>
                 
                  <th scope="col">Name</th>
                  <th scope="col">Username</th>
                  <th scope="col">Email </th>
                  <th scope="col"> Mobile</th>
                  <th scope="col">Role</th>
				    <th scope="col">Menu Permission</th>
					<th scope="col">Created At</th>
				  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php $Query=mysqli_query($con,"select * from admin");
			  		$i = 1;	
	  				  while($Row=mysqli_fetch_array($Query)){ ?>
                    <tr>
					  <td><span id="ContentPlaceHolder1_GridViewEnquiry_LabelStudentFirstName_0"><?=$i; ?></span></td>	
                      <td><span id="ContentPlaceHolder1_GridViewEnquiry_LabelStudentFirstName_0"><?=$Row['name'];?></span></td>	  
                      <td><span id="ContentPlaceHolder1_GridViewEnquiry_LabelStudentFirstName_0"><?=$Row['username'];?></span></td>
                      <td><span id="ContentPlaceHolder1_GridViewEnquiry_LabelStudentFirstName_0"><?=$Row['email'];?></span></td>
                      <td><span id="ContentPlaceHolder1_GridViewEnquiry_LabelMobile_0"><?=$Row['mobile'];?></span></td>
                      <td><span id="ContentPlaceHolder1_GridViewEnquiry_LabelLastQualification_0"><?=$Row['role'];?></span></td>
                      <td><span id="ContentPlaceHolder1_GridViewEnquiry_LabelApplicationTypeName_0"><?=$Row['menuper'];?></span></td>
                      <td><span id="ContentPlaceHolder1_GridViewEnquiry_LabelCastName_0"><?=$Row['created_at'];?></span></td>
					  
					  <td><a href="./usercreate.php?upid=<?php echo $Row["id"]; ?>"><i class="fa fa-pencil text-yellow"></i></a>&nbsp;&nbsp; <a href="?did=<?php echo $Row["id"]; ?>"><i class="fa fa-remove text-red"></i></a></td>

                    </tr>                
                <?php $i++;} ?>                    
              </tbody>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<!-- footer start -->
<?php
include('include/footer.php');
?>
<!-- footer end -->
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"  type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"  type="text/javascript"></script>
<script  type="text/javascript">
	$(function () {
	$("#example1").DataTable();
	
	});
</script>