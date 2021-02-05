<?php 
include("include/makeSession.php");
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
	mysqli_query($con,"delete from admin where StudenEnquiryID='$doid'");
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=Communication.php">';
	exit;
}
if(isset($_REQUEST['upid']) && $_REQUEST['upid']!=''){
	  $dovalue="usercreate";
	  $doid=$_REQUEST['upid'];
	  $upuserresult=mysqli_query($con,"select * from admin where id='".$_REQUEST['upid']."'");
	  $upuserarr=mysqli_fetch_array($upuserresult);
}else{
 	  $dovalue="usercreate";
	  $doid='';
} 
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> USER CREATE<small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">USER CREATE</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info">
          <div class="box-header">
            <h3 class="box-title"> USER CREATE <small></small></h3>
            <!-- tools box -->
            <div class="pull-right box-tools">
              <button class="btn btn-info btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
            </div><!-- /. tools -->
          </div><!-- /.box-header -->
          <div class="box-body pad">
            <div class="col-md-12">
			 <form method="post" action="action.php" name="addcategory" id="addcategory" enctype="multipart/form-data"  role="form">
              <input type="hidden"  name="do" value="<?php echo $dovalue;?>" />
                <input type="hidden"  name="doid" value="<?php echo $doid;?>" />
                <input type="hidden"  name="UserID" value="<?php echo $_SESSION["ecomid"];?>" />
              
                <div class="form-group col-md-4">
                  <label>Name *</label>                 
                  <input name="name" type="text" placeholder="Name" id="ContentPlaceHolder1_txtStudentName"
				  value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['name'];}?>" class="form-control" required>
                </div>
                <div class="form-group col-md-4">
                  <label> Username</label>
                  <input name="username" type="text" maxlength="10" placeholder="Username"
				  <?php if(isset($_REQUEST['upid'])){ echo 'readonly'; } ?>
				  id="ContentPlaceHolder1_txtMobile" value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['username'];}?>" class="form-control" required>                  
                </div>
              
                <div class="form-group col-md-4">
                  <label>Email</label>
                  <input name="email" type="email" placeholder="Email"
				  value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['email'];}?>"
				  id="ContentPlaceHolder1_txtLastQualification" class="form-control"
<?php if(isset($_REQUEST['upid'])){ echo 'readonly'; } ?>
				  required>                  
                </div>
				<?php if(isset($_REQUEST['upid'])){ }else{?>
				 <div class="form-group col-md-4">
                  <label>Password</label>
				
                       <input name="password" type="password" placeholder="password" 
					   value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['password'];}?>" id="ContentPlaceHolder1_txtUniversity_Last_Attended" class="form-control" >  

                                
                </div>
				<?php } ?>
                <div class="form-group col-md-4">
                  <label>Mobile</label>
                  <input name="mobile" type="number" placeholder="Mobile No."
				  value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['mobile'];}?>" 
				  id="ContentPlaceHolder1_txtMarks" class="form-control" required>                                
                </div>
                             
             
                <div class="form-group col-md-4">
                  <label>Role</label>
				
                       <input name="role" type="text" placeholder="Role" 
					   value="<?php if(isset($_REQUEST['upid'])){ echo $upuserarr['role'];}?>" id="ContentPlaceHolder1_txtUniversity_Last_Attended" class="form-control" >  

                                
                </div>
                <div class="form-group col-md-12">
                  <label>Menu Permission </label><br/>
				<?php 

            $menuper=explode(',',$upuserarr['menuper']);	
			$upuserresult=mysqli_query($con,"select * from menu ");
	  while($menu=mysqli_fetch_array($upuserresult)) {?>
                        <input type="checkbox" name="per[]" value="<?php echo $menu['menuname']; ?>" 
						<?php if(in_array($menu['menuname'],$menuper)){ echo 'checked'; } ?>
						>
						<?php echo $menu['menuname']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <?php } ?> 					 
                </div>
                                                                               
                <div class="box-footer col-md-12">
                  <input type="submit" class="btn btn-primary" name="ctl00$ContentPlaceHolder1$btnsave" value="Save"/>        <input type="reset" name="ctl00$ContentPlaceHolder1$btn_reset" value="Reset" id="ContentPlaceHolder1_btn_reset" class="btn btn-primary">           
                </div>
              </form>
			
			<!--
              <form method="post" action="action.php" name="addcategory" id="addcategory" enctype="multipart/form-data"  role="form">
                <input type="hidden"  name="do" value="<?php //echo $dovalue;?>" />
                <input type="hidden"  name="doid" value="<?php //echo $doid;?>" />
                <input type="hidden"  name="UserID" value="<?php //echo $_SESSION["ecomid"];?>" />
                <!-- text input 
                <div class="form-group">
                  <label>Student Name *</label>                 
                  <input name="StudentName" type="text" placeholder="Student Name" id="ContentPlaceHolder1_txtStudentName" value="<?php //if(isset($_REQUEST['upid'])){ echo $upuserarr['StudentName'];}?>" class="form-control" required>
                </div>
                <div class="form-group">
                  <label>Primary Mobile No. *</label>
                  <input name="Mobile" type="text" maxlength="10" placeholder="Primary Mobile No." id="ContentPlaceHolder1_txtMobile" value="<?php //if(isset($_REQUEST['upid'])){ echo $upuserarr['PrimaryMobileNo'];}?>" class="form-control" required>                  
                </div>
                <div class="form-group">
                  <label>Alternate Mobile No.</label>
                  <input name="AlternateMobNo" type="text" maxlength="10" placeholder="Alternate Mobile No." value="<?php //if(isset($_REQUEST['upid'])){ echo $upuserarr['AlternateMobileNo'];}?>" id="ContentPlaceHolder1_txtAlternateMobNo" class="form-control">                  
                </div>
                <div class="form-group">
                  <label>Last Qualification *</label>
                  <input name="LastQualification" type="text" placeholder="Last Qualification" value="<?php //if(isset($_REQUEST['upid'])){ echo $upuserarr['LastQualification'];}?>" id="ContentPlaceHolder1_txtLastQualification" class="form-control" required>                  
                </div>
                <div class="form-group">
                  <label>Last Qualification % Marks *</label>
                  <input name="Marks" type="text" placeholder="Last Qualification % Marks" value="<?php //if(isset($_REQUEST['upid'])){ echo $upuserarr['LastQualificationMarks'];}?>" id="ContentPlaceHolder1_txtMarks" class="form-control" required>                                
                </div>
                <div class="form-group">
                <label>Application Type</label>
                  <div class="radio">
                    <label>
                      <input type="radio" name="rdbappllicant" id="optionsRadios1" value="1" checked="">
                      DEPUTED
                    </label>
                  </div>
                  <div class="radio">
                    <label>
                      <input type="radio" name="rdbappllicant" id="optionsRadios2" value="2">
                      FRESHER
                    </label>
                  </div>                  
                </div>                
                <div class="form-group">
                  <label>Cast</label>
                  <select name="ddlcaste" class="form-control subject">
                      <option selected="selected" value="NA">Select</option>
                      <?php //$CasteQuery=mysqli_query($con,"select * from caste");
	  				 // while($CasteRow=mysqli_fetch_array($CasteQuery)){ 
                     // echo '<option value="'.$CasteRow['CasteID'].'" '.($upuserarr['Cast'] == $CasteRow['CasteID'] ? 'selected="selected"' : '' ).' >'.$CasteRow['CasteName'].'</option>';
					//   } ?>
                    </select>                               
                </div>
                <div class="form-group">
                  <label>University Last Attended</label>
                  <input name="University_Last_Attended" type="text" placeholder="University Last Attended" value="<?php //if(isset($_REQUEST['upid'])){ echo $upuserarr['UniversityLastAttended'];}?>" id="ContentPlaceHolder1_txtUniversity_Last_Attended" class="form-control">                                
                </div>
                <div class="form-group">
                  <label>Degree Name</label>
                  <select name="ddlcaste" class="form-control subject">
                      <option selected="selected" value="NA">Select</option>
                      <option value="1">B.ED</option>
                      <option value="2">D.El.Ed.</option>                     
                  </select>                               
                </div>
                <div class="form-group">
                  <label>Cast</label>
                  <select name="ddlcaste" class="form-control subject">
                  	<option selected="selected" value="NA">Select</option>                      
                  </select>                               
                </div>                                                                  
                <div class="box-footer">
                  <input type="submit" class="btn btn-primary" name="ctl00$ContentPlaceHolder1$btnsave" value="Save"/>                  
                </div>
              </form> -->
            </div>
          </div>
        </div><!-- /.box -->
      </div><!-- /.col-->
    </div><!-- ./row -->
  </section><!-- /.content -->
</div>
<?php include('include/footer.php');?>
	