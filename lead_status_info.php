<?php
session_start();
include("dbconfig.php");

if(isset($_POST['lead_status_lead_id']))
{
$lead_id=$_POST['lead_status_lead_id'];
$lead_status =$_POST['lead_status'];
$team_id=$_SESSION['proj_team_id'];
$project_id=$_SESSION['proj_info_id'];
$message=$_POST['folowupmessage'];

$nextfollowupdate=$_POST['next_follow_up_date'];

$nextfollowuptime='';
$nextfollowuptime= date("H:i:s", strtotime($_POST['next_follow_up_time']));


$follow_up_closing_status=$_POST['follow_up_closing_status'];
 
$query='';
if($lead_status!=''){ 

if($lead_status==0 && $message==''){
$query ="update leads set lead_status=".$lead_status." where id =".$lead_id;
 
}

else if($lead_status==0 && $message!=''){
$query =" update leads set lead_status=".$lead_status." where id =".$lead_id.";"." CALL lead_followup_status(".$lead_id.','.$team_id.','.$lead_status.','."'".$message."'".','.$project_id.','."'".$nextfollowupdate."'".','.$follow_up_closing_status.','."'".$nextfollowuptime."'".");";
 
}

else{
$query =" CALL lead_followup_status(".$lead_id.','.$team_id.','.$lead_status.','."'".$message."'".','.$project_id.','."'".$nextfollowupdate."'".','.$follow_up_closing_status.','."'".$nextfollowuptime."'".")";
}    
    
}
else
{
    
$query="CALL lead_followup_status(".$lead_id.','.$team_id.','."''".','."'".$message."'".','.$project_id.','."'".$nextfollowupdate."'".','.$follow_up_closing_status.','."'".$nextfollowuptime."'".")";
    
}

/*echo $query;die;
*/$status='';
$message='';
$lead_status_value='';
/*$lead_id='';*/
if (mysqli_multi_query($conn, $query)) {
  $status=1;
$message='lead status updated successfully.!';
    if($lead_status==0)
    {
        $lead_status_value="Raw";
    } 
   else if($lead_status==1)
   {
         $lead_status_value="Cold";
   }
   else if($lead_status==2)
   {
        $lead_status_value="Warm";
   } 
    else if($lead_status==3)
    {
            $lead_status_value="Hot";
    } 
     else if($lead_status==4)
    {
            $lead_status_value="Non-Relevent";
    } 
    
    
}

else {
   $status=0;
$message='lead status did not updated';
$lead_status_value='';
$lead_id='';
}

$data1= array("Status"=>$status,"Message"=>$message,"lead_status_value"=>$lead_status_value,"lead_id"=>$lead_id);
echo json_encode($data1);

}


?>