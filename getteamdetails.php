<?php
include("dbconfig.php");
if(isset($_POST['teamid']))
{
$row_id=$_POST['teamid'];
$query = "select name,email,phone_number,role_type,client_id,expiry_date from  client_team_members  WHERE id = ".$row_id;

if (mysqli_query($conn, $query)) {
  	$status=1;
  	$result=mysqli_query($conn, $query);
  	$row = mysqli_fetch_assoc($result);
		$message="Client Get.";
} else {
 
  $message=" Client did not Get.";
}


$data1= array("Status"=>$status,"Message"=>$message,"TeamName"=>$row['name'],"TeamEmail"=>$row['email'],"TeamPhone"=>$row['phone_number'],"TeamRole"=>$row['role_type'],"ClientId"=>$row['client_id'],"TeamExpiry"=>$row['expiry_date']);
echo json_encode($data1);
}
?>