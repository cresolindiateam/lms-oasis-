<?php
include("dbconfig.php");
if(isset($_POST['teamid']))
{
$row_id=$_POST['teamid'];
$query = "select name,email,phone_number,role_type,project_id from  project_team  WHERE id = ".$row_id;

if (mysqli_query($conn, $query)) {
  	$status=1;
  	$result=mysqli_query($conn, $query);
  	$row = mysqli_fetch_assoc($result);
		$message="Project Get.";
} else {
 
  $message=" Project did not Get.";
}


$data1= array("Status"=>$status,"Message"=>$message,"TeamName"=>$row['name'],"TeamEmail"=>$row['email'],"TeamPhone"=>$row['phone_number'],"TeamRole"=>$row['role_type'],"ProjectId"=>$row['project_id']);
echo json_encode($data1);
}
?>