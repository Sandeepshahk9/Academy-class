<?php require('config/config.php'); 
include_once("config/logincheck.php");
 include_once("config/function.php");
 if($admina["type"]=='Marketing Team Lead' ||  $admina["type"]=='Operation Team Lead'  ||
    $admina["usertype"]=='admin' || $admina["type"]=='Marketing Employee'   )
	{

	}
	
	
	else
	{
  header("Location:login.php?msg=Please Login First.");
		
	}
	
	

   /*
	$subtopicsid=$_GET['stz'];
	$subtopicquery=select_table_single('sub_topic',$_GET['stz']);
    $subtopic=mysqli_fetch_array($subtopicquery);

     */

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Food licence | Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	  
  <link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">

   <link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
      
	  <?php include_once('include/sidemenu.php') ;?>
	  
	  
          <?php include_once('include/header.php') ;?>
	  
		
        </div>
                     <?php 

if($_GET['msg']=='1'){

echo "<div class='alert alert-success'> Updated Successfully</div>";}

elseif($_GET['msg']=='2'){

echo "<div class='alert alert-danger'>Error !!! Please Try Again</div>";}

elseif($_GET['msg']=='3'){

echo "<div class='alert alert-danger'>Number is Already Exist. Please Try New</div>";}

elseif($_GET['msg']=='4'){

echo "<div class='alert alert-success'> Status Updated Successfully</div>";}

elseif($_GET['msg']=='5'){

echo "<div class='alert alert-success'> Deleted Successfully</div>";}
elseif($_GET['msg']=='555'){

echo "<div class='alert alert-danger'>Error !!! You cant delete this record.</div>";}


elseif($_GET['msg']=='6'){

echo "<div class='alert alert-success'>Added Successfully</div>";}

 ?>     



<!-----------body start ----------------->

  <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>List of all lead  Going To Expire </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                           
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
					
					
					
					 <h4>Date  Range  select</h4>
					<div class="row">
					 
					 <div class="col-lg-10">
					  <div class="form-group" id="data_5">
                              
								
								  <form class="form-horizontal"  method="GET"  
  											       enctype="multipart/form-data">
								
                                    <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="form-control-sm form-control" name="start"   value="<?php echo  !empty($_GET['start'])?$_GET['start']:date('d-m-Y'); ?>"/>
								 
                                    <span class="input-group-addon">to</span>
									
                                    <input type="text" class="form-control-sm form-control" name="end"   value="<?php  echo  !empty($_GET['end'])?$_GET['end']:
						                   date('d-m-Y',strtotime('+ 90 days')); ?>"  />
                               
							         </div>
								 
                            </div>
							
					</div>
					
					 <div class="col-lg-2"> 
					 <button type="submit" class="btn btn-primary">Send</button>
					</div>
					
					</div>
					
					
					
					
					
					
					
                    <div class="ibox-content">

                      <div class="table-responsive" >
                    <table class="table table-striped table-bordered table-hover "  id="dataTables-example"  style="width:100%" >
                    <thead>
                    <tr>
                        <th>No.</th>
						
                        <th>Licence type </th>
						
						
						 <th>Licence Number </th>
						  <th>Licence Issue Date </th>
						   <th>Licence Exp Date </th>
						
						
						 <th>Company name</th>
						 
						<th>Owner Name </th>
						
						<th>Mobile No </th>
						<th>Email id </th>
						
						
						<?php  if($admina["type"] !='Marketing Employee')  {
						echo '<th>Assigned to</th>';   }  
						
						
						if($admina["type"] !='Operation Employee')  {
							
						echo ' <th>Lead By</th> ' ; } ?>
						   
						   
						  <th>Lead Status</th>
						
                        <th>Manage</th>
                        
                    </tr>
                    </thead>
                    <tbody>
                 
				 
				    <?php  $i=1;  


                        $start = !empty($_GET['start'])?$_GET['start']:date('d-m-Y');
                        $start  = date("Y-m-d", strtotime($start));
						
						
						 $end = !empty($_GET['end'])?$_GET['end']:
						         date('d-m-Y',strtotime('+ 90 days'));
                         $end = date("Y-m-d", strtotime($end));
					
					
					 
						 
						 $query1=mysqli_query($con,"select * from   licenece  where  


							 	licenece_exp_date  between '".$start."' and '".$end."'
                     					  ORDER BY 	licenece_exp_date ASC");
						
						 while( $roww=mysqli_fetch_array($query1)) {
						
						
						
					
                    
				         if($admina["type"]=='Marketing Employee')
	                        {
							
							 $query=mysqli_query($con,"select * from  lead  where  user_id = '".$_SESSION['uniq_user_id']."'
                     				AND id='".$roww['lead_id']."' AND status = 'Approved'	");

	                       }
						   
						   else {
							   
							  $query=mysqli_query($con,"select * from  lead  where id='".$roww['lead_id']."' AND status = 'Approved' ");
							   
						   }
                              
							 if(mysqli_num_rows($query) != 0){
				    			  
								$row=mysqli_fetch_array($query)	;

                             
								
                        
				         ?>
                       <tr class="gradeC">
                        <td><?=$i?></td>
						
                         <td><?=$row['type_of_licence']?></td>  
						 
						 
						    <td><?=$roww['licenece_number']?></td>  
							   <td><?=date('d M Y',strtotime($roww['licenece_issue_date']))?></td>  
							      <td><?=date('d M Y',strtotime($roww['licenece_exp_date']))?></td>  
						 
						 
						 
						  <td><?=$row['company_name']?></td> 
						  
						  <td><?=$row['owner_name']?></td>  
						  
                           <td><?=$row['mobile_number']?></td>

                            <td><?=$row['emailid']?></td>

                           <?php  if($admina["type"] !='Marketing Employee')  {  ?>
						  <td><?php 

                            $hjk=mysqli_query($con,"select fname,lname from  admin where id='".$row['assign_user_id']."'  
                     					 ");
                             $hjkr=mysqli_fetch_array($hjk) ;
						  
						    echo  $hjkr['fname'].' '.$hjkr['lname']  ;

						   ?>
						   </td>  
						   
						   <?php } if($admina["type"] !='Operation Employee')  { ?>
						   
						   
						     <td><?php  
							 
							 $art=mysqli_query($con,"select fname,lname from  admin where id='".$row['user_id']."'  
                     					 ");
                             $artt=mysqli_fetch_array($art) ;
						  
						    echo  $artt['fname'].' '.$artt['lname']  ;
							 
							?>
						  </td>
						  <?php }  ?>
						  
						  
						  
						  
							
							
						 <td><?php  echo ($row['status']=='Rejected')?"<span class='label label-warning'>".$row['status']."</span>" :"<span class='label label-primary'>".$row['status']."</span>" ; ?></td>
							
                       
                         <td class="center">
						
						
						 	
						
						<a href="lead-view.php?tz=<?php echo $row['id'] ; ?>"
						title="View">  <button class="btn-white btn btn-xs">View</button></a>
						
						
						
						<a href="lead-edit.php?tz=<?php echo $row['id'] ; ?>"
						title="Edit">  <button class="btn-white btn btn-xs">Edit</button> </a>
					
						 
						 
						 
					 <?php	  if($admina["type"]=='Marketing Team Lead' ||  $admina["type"]=='Operation Team Lead'  || $admina ["usertype"]=='admin'   )
	                             {       ?>
					
						<a  onclick="return confirm('Are you sure you want to delete this !')" href="action.php?del=1&tabl=lead&pgname=leads_near_expire.php?&salln=<?php echo $row['id']; ?>"

						  title="Delete">  <button class="btn-white btn btn-xs">Delete</button></a>
						  
						  
								 <?php } ?>
						  
						  
						  
						  </td>
                       
                     </tr>
                  
							<?php  $i++;  }   }  ?>
                  
                    </tbody>
                    <tfoot>
                     <tr>
                        <th>No.</th>
					 
					   
                        <th>Licence type </th>
						
						 <th>Licence Number </th>
						  <th>Licence Issue Date </th>
						   <th>Licence Exp Date </th>
						
						
						 <th>Company name</th>
						  
						<th>Owner Name </th>
						<th>Mobile No </th>
						<th>Email id </th>
						
						
						
						
						<?php  if($admina["type"] !='Marketing Employee')  {
						echo '<th>Assigned to</th>';   }  
						
						
						if($admina["type"] !='Operation Employee')  {
							
						echo ' <th>Lead By</th> ' ; } ?>
						
						
						
						<th>Lead Status</th>
						 
                        <th>Manage</th>
                    </tr>
                    </tfoot>
                    </table>
                        </div>

                    </div>
                </div>
            </div>
            </div>







<!--------------body end---------------------->                   
                   
                   

            </div>
         
		<?php include_once('include/footer.php'); ?>

   <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

   <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
	  <!-- Data picker -->
   <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
  <!-- Date range use moment.js same as full calendar plugin -->
    <script src="js/plugins/fullcalendar/moment.min.js"></script>
   <script src="js/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

      <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('#dataTables-example').DataTable({
			
			  "scrollY": true,
              "scrollX": true,
                pageLength: 50,
                responsive: true,
                
            });

         });
		 
		 
		 
		  $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
				
            }); 

    </script>


  
</body>
</html>
