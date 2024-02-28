<?php
include("dbconfig.php");

if(isset($_POST['member_access_lead_id']))
{
$lead_id=$_POST['member_access_lead_id'];
$team_id =$_POST['project_team_member'];

$query = "update  leads set TeamMemeberAccessId=".$team_id." where id=".$lead_id;



$status='';
$message='';
if (mysqli_query($conn, $query)) {
 
  $status=1;
$message='lead assigned to member';
  
  
  
} else {
   $status=0;
$message='lead not assigned to member';
}

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);

}


?>