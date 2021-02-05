<?php 
include ("include/makeSession.php");
$menu_string=mysqli_fetch_array(mysqli_query($con,"select * from admin where id='".$_SESSION["user_id"]."'"))['menuper'];
$menu_arr=explode(',',$menu_string);
if(!in_array('Attendance',$menu_arr)){
	header("location:index.php");
}
$_SESSION['page_name']="Attendance";
include('include/function.php');
include("include/header.php");
include("include/sidebar.php");

?>
<style>
    .count{
        border: 1px solid;
        padding: 10px;
        border-radius: 5px;
        margin:10px;
    }
    .count span{
        font-weight:bold;
    }
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
        <h1> Attendance Form <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Attendance Form</a></li>
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
                    <form method="post" action="action.php" name="addcategory" id="addcategory" enctype="multipart/form-data"  role="form">
                        <input type="hidden"  name="do" value="Attendance" />
                        <input type="hidden"  name="doid" value="" />
                        <div class="box-header">
                            <h3 class="box-title"> Attendance Form <small></small></h3>
                            <!-- tools box -->
                            <div class="pull-right box-tools">
                                <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                            </div><!-- /. tools -->
                        </div><!-- /.box-header -->
                        <div class="box-body pad">
                            <div class="col-md-12">
                                <div class="form-group col-md-4">
                                    <label>Course *</label>
                                    <select name="course_id" class="form-control" required>
                                        <option>- - Select - -</option>
                                    <?php
                                        $courseQ=mysqli_query($con,"select id,name from course order by id desc");
                                        while($courseR=mysqli_fetch_array($courseQ)){
                                    ?>
                                        <option value="<?=$courseR['id'];?>" <?php if(!empty($_REQUEST['upid'])&&$Row['course_id']==$courseR['id']){ echo "selected";}?>><?=$courseR['name'];?></option>
                                    <?php
                                        }
                                    ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Session *</label>
                                    <select name="session_id" class="form-control" required>
                                        <option>- - Select - -</option>
                                        <?php
                                            if(!empty($Row['session_id'])){
                                                $q=mysqli_query($con,"select name,id from session where course_id=".$Row['course_id']);
                                                while($r=mysqli_fetch_array($q)){
                                                    $selected="";
                                                    if($Row['session_id']==$r['id']){
                                                        $selected="selected";
                                                    }
                                                    echo "<option value='".$r['id']."' $selected>".$r['name']."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Date *</label>                 
                                    <input name="date" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['date'];} else{ echo date('Y-m-d'); }?>" type="date" class="form-control" required>
                                </div>
                                <div class="col-md-12">
                                    <center>
                                        <span class="count" style="color:green;">
                                            <small>Present: </small>
                                            <span id="present_value">0</span>
                                        </span>
                                        <span class="count" style="color:red;">
                                            <small>Absent: </small>
                                            <span id="absent_value">0</span>
                                        </span>
                                        <span class="count" style="color:orange;">
                                            <small>Leave: </small>
                                            <span id="leave_value">0</span>
                                        </span>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="box-header">
                            <h3 class="box-title">Attendance Action </h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive" >
            		  		<table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="4">Status</th>
                                        <th rowspan="2">Registration No.</th>
                                        <th rowspan="2">Student Name</th>
                                    </tr>
                                    <tr>
                                        <th>Present <button id="present" type="button" class="btn btn-primary">Select All</button></th>
                                        <th>Absent <button id="absent" type="button" class="btn btn-primary">Select All</button></th>
                                        <th>Leave <button id="leave" type="button" class="btn btn-primary">Select All</button></th>
                                        <th>Remark</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div class="row">                                                            
                                <div class="col-md-6">
                                <div class="form-group">
                                    <input type="submit" id="submit" class="btn btn-primary" value="Save"/>
                                    <input type="reset" value="Reset" class="btn btn-primary"/>           
                                </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                    </form>
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
    $("select[name='session_id']").change(function(){
        var session_id=$(this).val();
        $("input[name='doid']").val(session_id);
        $.ajax({  
            type: "POST",  
            url: "json_attendance.php",  
            data: {'session_id': session_id,'do':'Take'}, 
            dataType: "json",	
            beforeSend: function(){
                $("body").addClass("loading");
            },
            success: function(response) { 
                $("tbody").html(response);
            },
            complete:function(data){
                $("body").removeClass("loading");
            }
        });
    });
    $("#present").click(function(){
        $(".present").prop("checked","checked");
    });
    $("#absent").click(function(){
        $(".absent").prop("checked","checked");
    });
    $("#leave").click(function(){
        $(".leave").prop("checked","checked");
    });
    $("table").on("click",".present,.absent,.leave,#present,#absent,#leave",function(){
        var present=0;
        for(var i=0;i<$(".present").length;i++){
            if($($(".present")[i]).prop("checked")==true){
                present++;
            }
        }
        $("#present_value").html(present);
        
        var absent=0;
        for(var i=0;i<$(".absent").length;i++){
            if($($(".absent")[i]).prop("checked")==true){
                absent++;
            }
        }
        $("#absent_value").html(absent);
        
        var leave=0;
        for(var i=0;i<$(".leave").length;i++){
            if($($(".leave")[i]).prop("checked")==true){
                leave++;
            }
        }
        $("#leave_value").html(leave);
    });
});
</script>