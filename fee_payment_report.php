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
?>
<div class="content-wrapper">
    <section class="content-header">
        <h1> View Fee Report</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">View Fee Report</a></li>
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
                        <h3 class="box-title">View Fee Report </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" >
        		  		<table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <!--<th scope="col">Action</th>-->
                                    <th>#ID</th>
                                    <th scope="col">Registration No.</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Fee</th>
                                    <th scope="col">Pay</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $q=mysqli_query($con,"select registration_no,student_name,discount,register.type,
                                session.name as session_name,course.name as course_name,register.session_id,register.id
                                from register
                                left join session on session.id=register.session_id
                                left join course on course.id=register.course_id
                                order by register.id desc");
                                $i = 1;	
                                while($r=mysqli_fetch_array($q)){ ?>
                                    <tr>
                                        <!--<td>-->
                                        <!--    <a href="#"><i class="fa fa-pencil text-yellow"></i></a>&nbsp;&nbsp; -->
                                        <!--    <a href="#" onclick="return confirm_click();"><i class="fa fa-remove text-red"></i></a>-->
                                        <!--</td>-->
                                        <td><?=$i;?></td>
                                        <td><?=$r['registration_no'];?></td>
                                        <td><?=$r['student_name'];?></td>
                                        <td><?=$r['course_name'];?> [<?=$r['session_name'];?>]</td>
                                        <td>
                                            <?php
                                                $total=mysqli_fetch_array(mysqli_query($con,"select sum(amount) as total from fee
                                                where session_id=".$r['session_id']." AND type='".$r['type']."'"))['total'];
                                                $fee=$total-$r['discount'];
                                                $paid=mysqli_fetch_array(mysqli_query($con,"select sum(amount) as paid from fee_payment where register_id=".$r['id']))['paid'];
                                                $remaining=$fee-$paid;
                                            ?>
                                            Course Fee: <?=$total;?><br>
                                            Discount: <?=$r['discount'];?><br>
                                            Payable: <?=$fee;?><br>
                                            <span style="color:green;">Paid: <?=$paid;?></span><br>
                                            <span style="color:#8c0000;">Remaining: <?=$remaining;?></span>
                                        </td>
                                        <td>
                                            <?php
                                                $receiptQ=mysqli_query($con,"select id,amount from fee_payment where register_id=".$r['id']." order by id desc");
                                                while($receiptR=mysqli_fetch_array($receiptQ)){
                                            ?>
                                                    <a href="receipt.php?upid=<?=$receiptR['id'];?>"><i class="fa fa-eye"></i></a> <?=$receiptR['amount'];?><a href="edit_fee_payment.php?upid=<?=$receiptR['id'];?>"> <i class="fa fa-pencil text-green"></i></a><br>
                                            <?php
                                                }
                                                if($remaining>0){
                                            ?>
                                            
                                            <a href="fee_payment.php?upid=<?=$r['id'];?>"><i class="fa fa-paypal text-red"></i>
                                            <?php
                                                }
                                            ?>
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
// gets the center of a table cell relative to the document
// function getCellCenter($("table"), row, column) {
//   var tableRow = $(table).find('tr')[row];
//   var tableCell = $(tableRow).find('td')[column];

//   var offset = $(tableCell).offset();
//   var width = $(tableCell).innerWidth();
//   var height = $(tableCell).innerHeight();
  
//   return {
//     x: offset.left + width / 2,
//     y: offset.top + height / 2
//   }
// }

// // draws an arrow on the document from the start to the end offsets
// function drawArrow(start, end) {

//   // create a canvas to draw the arrow on
//   var canvas = document.createElement('canvas');
//   canvas.width = $('body').innerWidth();
//   canvas.height = $('body').innerHeight();
//   $(canvas).css('position', 'absolute');
//   $(canvas).css('pointer-events', 'none');
//   $(canvas).css('top', '0');
//   $(canvas).css('left', '0');
//   $(canvas).css('opacity', '0.85');
//   $('body').append(canvas);
  
//   // get the drawing context
//   var ctx = canvas.getContext('2d');
//   ctx.fillStyle = 'steelblue';
//   ctx.strokeStyle = 'steelblue';
  
//   // draw line from start to end
//   ctx.beginPath();
//   ctx.moveTo(start.x, start.y);
//   ctx.lineTo(end.x, end.y);
//   ctx.lineWidth = 2;
//   ctx.stroke();
  
//   // draw circle at beginning of line
//   ctx.beginPath();  
//   ctx.arc(start.x, start.y, 4, 0, Math.PI * 2, true);
//   ctx.fill();

//   // draw pointer at end of line (needs rotation)
//   ctx.beginPath();  
//   var angle = Math.atan2(end.y - start.y, end.x - start.x);
//   ctx.translate(end.x, end.y);
//   ctx.rotate(angle);
//   ctx.moveTo(0, 0);
//   ctx.lineTo(-10, -7);
//   ctx.lineTo(-10, 7);
//   ctx.lineTo(0, 0);
//   ctx.fill();

//   // reset canvas context
//   ctx.setTransform(1, 0, 0, 1, 0, 0);  
  
//   return canvas;
// }

// // finds the center of the start and end cells, and then calls drawArrow
// function drawArrowOnTable(table, startRow, startColumn, endRow, endColumn) {
//   drawArrow(
//     getCellCenter($(table), startRow, startColumn),
//     getCellCenter($(table), endRow, endColumn)
//   );
// }

// // draw an arrow from (1, 0) to (2, 4)
// drawArrowOnTable('table', 1, 0, 2, 4);
</script>