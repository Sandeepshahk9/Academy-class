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

$doid=$_REQUEST['upid'];
$str = mysqli_query($con,"select  course_id  from   register  where id='".$doid."'");
$row = mysqli_fetch_array($str);  

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
        <h1> Test History <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Test History</a></li>
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
                        <h3 class="box-title">Test History </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" >
        		  		<table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Sr. No.</th>
                                    <th>Test name</th>
                                    <th>Date</th>
                                 
								  <?php 
											  $str2 = mysqli_query($con,"
								
								               select  subject.name,subject.id


										        from course_subject
                                                
												INNER JOIN subject ON  course_subject.subject_id = subject.id
 
                                      	       where  course_subject.course_id='".$row['course_id']."'     ORDER BY name ASC 
								
								             ");
								
								
								     while($row2 = mysqli_fetch_array($str2)){
								
								
								?>
                                     <th><?=$row2['name']?></th>
									
								<?php  } ?>
									
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i=0;
									
									
									
									
                                    $Query=mysqli_query($con,"select test.test_id,test.register_id,weekly_test.name,weekly_test.date from test
                                         inner join weekly_test on weekly_test.id=test.weekly_test_id
                                        where test.register_id='".$_REQUEST['upid']."'  GROUP BY   test_id
                                        order by weekly_test.date  desc");
                                    while($Row=mysqli_fetch_array($Query)){ $i++;
                                 ?>
                                <tr>
                                    <td>
                                        <a href="./test_report.php?upid=<?=$Row['test_id'];?>&page=<?=$Row["register_id"];?>"><i class="fa fa-pencil text-yellow"></i></a>&nbsp;&nbsp; 
                                        <a href="./test_report.php?did=<?=$Row['test_id'];?>&page=<?=$Row["register_id"];?>" onclick="return confirm_click();"><i class="fa fa-remove text-red"></i></a>
                                    </td>
                                    <td><?=$i;?></td>
                                    <td><?=$Row['name'];?></td>
                                    <td><?=date('d M  Y',strtotime($Row['date']));?></td>
                                   
								   
								     <?php 
											  $str3 = mysqli_query($con,"
								
								               select  test.subject_marks

										        from test
                                                
												INNER JOIN subject ON  test.subject_id = subject.id
 
                                      	     where  test.register_id='".$_REQUEST['upid']."'  AND test.test_id ='".$Row['test_id']."'

												
											   ORDER BY name ASC 
								
								             ");
								
								
								     while($row3 = mysqli_fetch_array($str3)){
								
								
								     ?>
                                  
                                    <td><?=$row3['subject_marks'];?></td>
									
									
									<?php  } ?>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
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