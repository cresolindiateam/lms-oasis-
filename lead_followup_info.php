
<?php
session_start();
include("dbconfig.php");

if(isset($_POST['lead_followup_lead_id']))
{
$lead_id=$_POST['lead_followup_lead_id'];
$folowupmessage =$_POST['folowupmessage'];

$team_id=$_SESSION['proj_team_id'];
$query = "INSERT INTO lead_followup(lead_id,team_member_id,message,created_at)"." 
VALUES('$lead_id','$team_id','$folowupmessage',now())";



$status='';
$message='';
if (mysqli_query($conn, $query)) {
 
  $status=1;
$message='lead follow up message inserted successfully!';
  
  
  
} else {
   $status=0;
$message='lead follow up message did not inserted';
}

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);

}


?>