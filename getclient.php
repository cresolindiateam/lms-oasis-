<?php
include("dbconfig.php");
if(isset($_POST['edit_client_name']))
{
$row_id=$_POST['edit_client_id'];
$name=$_POST['edit_client_name'];
$client_email=$_POST['edit_client_email'];
$client_type=$_POST['edit_client_type'];
$client_expire=$_POST['edit_client_expiry'];
$client_members=$_POST['edit_client_members'];
 
$query = "update  clients set name ='".$name."',type ='".$client_type."',email ='".$client_email."',expiry ='".$client_expire."', members ='".$client_members."' WHERE id = ".$row_id;



if (mysqli_query($conn, $query)) {
  	$status=1;
		$message="Client Updated.";
} else {
 
  $message=" client did not Updated.";
}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
}
?>

