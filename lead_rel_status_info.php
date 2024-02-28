<?php
session_start();
include("dbconfig.php");

if(isset($_POST['lead_rel_status_lead_id']))
{
$lead_id=$_POST['lead_rel_status_lead_id'];
$lead_status =$_POST['lead_rel_status'];
/*$team_id=$_SESSION['proj_team_id'];
$project_id=$_SESSION['proj_info_id'];*/
$message=$_POST['reasonmessage'];

$query="CALL lead_rel_status(".$lead_id.','."".$lead_status."".','."'".$message."')";

$status='';
$message='';
$lead_status_value='';
/*$lead_id='';*/
if (mysqli_query($conn, $query)) {
  $status=1;
$message='lead status updated successfully.!';
    if($lead_status==0)
    {
        $lead_status_value="Relevent";
    }
   else if($lead_status==1)
   {
         $lead_status_value="Non Relevent";
   }
   
   
  
    
    
}

else {
   $status=0;
$message='lead status did not updated';
$lead_status_value='';
$lead_id='';
}

$data1= array("Status"=>$status,"Message"=>$message,"lead_rel_status_value"=>$lead_status_value,"lead_id"=>$lead_id);
echo json_encode($data1);

}


?>