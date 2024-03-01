<?php
include("dbconfig.php");
if(isset($_POST['clientid']))
{
$row_id=$_POST['clientid'];
$query = "select name,type,email,members,expiry,created_at from clients  WHERE id = ".$row_id;

if (mysqli_query($conn, $query)) {
  	$status=1;
  	$result=mysqli_query($conn, $query);
  	$row = mysqli_fetch_assoc($result);
		$message="Client Get.";
} else {
 
  $message=" Client did not Get.";
}

$data1= array("Status"=>$status,"Message"=>$message,"ClientName"=>$row['name'],"ClientType"=>$row['type'],"ClientEmail"=>$row['email'],"ClientMember"=>$row['members'],"ClientExpiry"=>$row['expiry'],"ClientCreated"=>$row['created_at']);
echo json_encode($data1);
}
?>