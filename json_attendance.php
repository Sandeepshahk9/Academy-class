<?php
    include("include/config.inc.php");
    $do=mysqli_real_escape_string($con,$_REQUEST['do']);
    switch($do){
        case "Take":
            $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
            $q=mysqli_query($con,"select student_name,id,registration_no from register where session_id=$session_id");
            $response="";
            while($r=mysqli_fetch_array($q)){
                $response.="<tr>
                                <td>
                                    <div class='form-group'>
                                        <label>
                                            <small>Present</small>
                                            <input type='radio' name='status_".$r['id']."' value='1' class='present' required>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class='form-group'>
                                        <label>
                                            <small>Absent</small>
                                            <input type='radio' name='status_".$r['id']."' value='0' class='absent' required>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class='form-group'>
                                        <label>
                                            <small>Leave</small>
                                            <input type='radio' name='status_".$r['id']."' value='2' class='leave' required>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class='form-group'>
                                        <label>
                                            <input type='text' name='remark_".$r['id']."' class='form-control' placeholder='Enter Remarks'>
                                        </label>
                                    </div>
                                </td>
                                <td>".$r['registration_no']."</td>
                                <td>".$r['student_name']."</td>
                            <tr>";
            }
        break;
        case "View":
            $session_id=mysqli_real_escape_string($con,$_REQUEST['session_id']);
            $date=mysqli_real_escape_string($con,$_REQUEST['date']);
            $q=mysqli_query($con,"select status from attendance where session_id=$session_id
                AND date='$date'");
            $r=mysqli_fetch_array($q);
            $attendance=explode(",",$r['status']);
            $response="";
            for($i=0;$i<count($attendance)-1;$i++){
                if(explode("__",$attendance[$i])[1]==0){
                    $status="Absent";
                }else if(explode("__",$attendance[$i])[1]==1){
                    $status="Present";
                }else{
                    $status="Leave";
                }
                $studentR=mysqli_fetch_array(mysqli_query($con,"select student_name,parent_mobile,registration_no from register
                    where id=".explode("__",$attendance[$i])[0]));
                $response.="<tr>
                                <td>".$studentR['registration_no']."</td>
                                <td>".$studentR['student_name']."</td>
                                <td class='status'>".$status."</td>
                                <td><a href='tel:".$studentR['parent_mobile']."'>".$studentR['parent_mobile']."</td>
                                <td>".explode("__",$attendance[$i])[2]."</td>
                            <tr>";
            }
        break;
    }
    echo json_encode($response);
?>