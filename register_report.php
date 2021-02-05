<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('Register',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="Register";
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1> View Registeration</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">View Registeration</a></li>
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
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">View Registeration </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" >
        		  		<table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th>#ID</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Registration No.</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Photo</th>
                                    <th scope="col">Father Name</th>
                                    <th scope="col">Mother Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">DOB</th>
                                    <th scope="col">10+2 Marks</th>
                                    <th scope="col">Session</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Student Mobile</th>
                                    <th scope="col">Parent Mobile</th>
                                    <th scope="col">Guaranteed?</th>
                                    <th scope="col">Course Fee</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col">Enquiry Date</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $q=mysqli_query($con,"select register.*,course.name as course_name,session.name as session_name
                                from register
                                left join course on course.id=register.course_id
                                left join session on session.id=register.session_id
                                order by register.id desc");
                                $i = 1;	
                                while($r=mysqli_fetch_array($q)){ ?>
                                    <tr>
                                        <td>
                                            <a href="./direct_register.php?upid=<?php echo $r["id"]; ?>"><i class="fa fa-pencil text-yellow"></i></a>&nbsp;&nbsp; 
                                            <a href="./direct_register.php?did=<?php echo $r["id"]; ?>" onclick="return confirm_click();"><i class="fa fa-remove text-red"></i></a>
                                        </td>
                                        <td><?=$i;?></td>
                                        <td style="text-transform:capitalize;"><?=$r['status'];?></td>
                                        <td style="text-transform:capitalize;"><?=$r['type'];?></td>
                                        <td><?=$r['registration_no'];?></td>
                                        <td><?=$r['student_name'];?></td>
                                        <td><img src="images/student/<?=$r['image'];?>" width="50px" height="50px" /></td>
                                        <td><?=$r['father_name'];?></td>
                                        <td><?=$r['mother_name'];?></td>
                                        <td><?=$r['address'];?></td>
                                        <td><?=$r['dob'];?></td>
                                        <td><?=$r['marks'];?></td>
                                        <td><?=$r['session_name'];?></td>
                                        <td><?=$r['course_name'];?></td>
                                        <td><?=$r['gender'];?></td>
                                        <td><?=$r['student_mobile'];?></td>
                                        <td><?=$r['parent_mobile'];?></td>
                                        <td><?php if($r['guarantee']==1) echo "Yes"; else echo "No";?></td>
                                        <td>
                                            <?php
                                                echo
                                                mysqli_fetch_array(mysqli_query($con,"select sum(amount) as total from fee
                                                where session_id=".$r['session_id']." AND type='".$r['type']."'"))['total'];
                                            ?>
                                        </td>
                                        <td><a href="./discount.php?upid=<?php echo $r["id"]; ?>"><i class="fa fa-pencil text-yellow"></i></a><?=$r['discount'];?></td>
                                        <td><?=$r['enquiry_date'];?></td>
                                        <td><?=$r['reference'];?></td>
                                        <td><?=$r['remark'];?></td>
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
<script src="plugins/datatables/jquery.dataTables.min.js"  type="text/javascript"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"  type="text/javascript"></script>
<script src="bootstrap/js/dataTables.buttons.min.js"  type="text/javascript"></script>
<script src="bootstrap/js/jszip.min.js"  type="text/javascript"></script>
<script src="bootstrap/js/pdfmake.min.js"  type="text/javascript"></script>
<script src="bootstrap/js/vfs_fonts.js"  type="text/javascript"></script>
<script src="bootstrap/js/buttons.html5.min.js"  type="text/javascript"></script>
<script src="bootstrap/js/buttons.print.min.js"  type="text/javascript"></script>
<script src="bootstrap/js/buttons.colVis.min.js"  type="text/javascript"></script>
<script src="bootstrap/js/buttons.flash.min.js"  type="text/javascript"></script>
<script  type="text/javascript">
$(document).ready(function() {
    $('#example1').DataTable( {
        dom: 'Bfrtip',
        columnDefs: [
            {
                targets: 1,
                className: 'noVis'
            }
        ],
        buttons: [
            {
                extend: 'colvis',
                columns: ':not(.noVis)'
            }
        ],
		 buttons: [
		  { extend: 'colvis', text: 'COLOUMNS' },
		 { extend: 'csv', text: 'Export to CSV' },
		 { extend: 'excel', text: 'Export to Excel' },
           { extend: 'pdfHtml5', text: 'Create PDF', orientation: 'landscape', exportOptions: { columns: ':visible' } },
{ extend: 'print', text: 'Print', exportOptions:{columns: ':visible',autoPrint: true}}
        ],
		
    });
});
</script>