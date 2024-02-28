<?php
include("dbconfig.php");

if(isset($_POST['leadfollowid']))
{
$leadfollowid=$_POST['leadfollowid'];


$query = "update  lead_followup set lead_follow_hidden_status=1 where id=".$leadfollowid;



$status='';
$message='';
if (mysqli_query($conn, $query)) {
 
  $status=1;
$message='lead follow has been deleted';
  
  
  
} else {
   $status=0;
$message='lead follow not deleted';
}

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);

}


?>