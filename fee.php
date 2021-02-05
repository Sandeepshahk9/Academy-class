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
	mysqli_query($con,"delete from fee where id=".$doid);
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=fee.php">';
	exit;
}
if(!empty($_REQUEST['upid']) && $_REQUEST['upid']!=''){
    $dovalue="EditFee";
    $doid=$_REQUEST['upid'];
    $Query=mysqli_query($con,"select * from fee where id=$doid");
    $Row=mysqli_fetch_array($Query);
}else{
    $dovalue="Fee";
    $doid='';
}
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
        <h1> Fee <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Fee</a></li>
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
                        <h3 class="box-title"> Fee <small></small></h3>
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
                                    <label>Fee Name *</label>                 
                                    <input name="name" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['name'];}?>" type="text" placeholder="Enter Fee Name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Amount *</label>                 
                                    <input name="amount" value="<?php if(!empty($_REQUEST['upid'])){ echo $Row['amount'];}?>" type="number" placeholder="Enter Fee Amount" class="form-control" required>
                                </div>
                                <div class="form-group">
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
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label>
                                        Hostel
                                        <input type="radio" name="type" value="hostel" <?php if($r['status']=="hostel"){ echo "checked"; }?> required />
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        Dayboarding
                                        <input type="radio" name="type" value="dayboarding" <?php if($r['status']=="dayboarding"){ echo "checked"; }?> required />
                                    </label>
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
                        <h3 class="box-title">View Fees </h3>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive" >
        		  		<table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Action</th>
                                    <th>#ID</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Fee Name</th>
                                    <th scope="col">Fee Amount</th>
                                    <th scope="col">Session</th>
                                    <th scope="col">Course</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $q=mysqli_query($con,"select fee.id,fee.name,course.name as course_name,
                                session.name as session_name,fee.amount,fee.type from fee
                                left join course on course.id=fee.course_id 
                                left join session on session.id=fee.session_id
                                order by fee.id desc");
                                $i = 1;	
                                while($r=mysqli_fetch_array($q)){ ?>
                                    <tr>
                                        <td>
                                            <a href="./fee.php?upid=<?php echo $r["id"]; ?>"><i class="fa fa-pencil text-yellow"></i></a>&nbsp;&nbsp; 
                                            <a href="./fee.php?did=<?php echo $r["id"]; ?>" onclick="return confirm_click();"><i class="fa fa-remove text-red"></i></a>
                                        </td>
                                        <td><?=$i;?></td>
                                        <td><?=$r['type'];?></td>
                                        <td><?=$r['name'];?></td>
                                        <td><?=$r['amount'];?></td>
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