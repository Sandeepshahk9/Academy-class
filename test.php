<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('Test',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="Test";

include("include/header.php");
include("include/sidebar.php");
?>
<style>
    .bt{
        border:1px solid orange;
        border-radius:5px;
        background-color:rgba(255, 167, 7,0.3);
        color:black;
        padding:10px;
    }
    .bt:hover{
        border:1px solid red;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1> Weekly Test Report</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Weekly Test Report</a></li>
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
                        <h3 class="box-title">Weekly Test Report </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" >
        		  		<table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#ID</th>
                                    <th scope="col">Exam Report</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Registration No.</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Session</th>
                                    <th scope="col">Course</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $q=mysqli_query($con,"select register.*,course.name as course_name,
                                session.name as session_name
                                from register
                                left join course on course.id=register.course_id
                                left join session on session.id=register.session_id
                                order by register.id desc");
                                $i = 1;	
                                while($r=mysqli_fetch_array($q)){ ?>
                                    <tr>
                                        <td><?=$i;?></td>
                                        <td>
                                            <a href="test_report.php?add=<?=$r['id'];?>"><button type="button" class="bt">Add Report</button></a> || 
                                            <a href="test_report_history.php?upid=<?=$r['id'];?>"><button type="button" class="bt">History</button></a></td>
                                        <td style="text-transform:capitalize;"><?=$r['type'];?></td>
                                        <td><?=$r['registration_no'];?></td>
                                        <td><?=$r['student_name'];?></td>
                                        <td><?=$r['session_name'];?></td>
                                        <td><?=$r['course_name'];?></td>
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