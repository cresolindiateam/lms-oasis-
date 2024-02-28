<?php
include("dbconfig.php");
if(isset($_POST['edit_name']))
{
$row_id=$_POST['project_id'];
$password=md5($_POST['edit_password']);
$name=$_POST['edit_name'];
$user_name=$_POST['edit_user_name'];
$client_name=$_POST['edit_client_name'];
$user_name=$_POST['edit_user_name'];
$project_image_url=$_POST['edit_project_image_url'];
$project_url=$_POST['edit_project_url'];
 
$query = "update  project_information set password ='".$password."',username ='".$user_name."',project_name ='".$name."',project_url ='".$project_url."',project_image_url ='".$project_image_url."',client_name ='".$client_name."' WHERE id = ".$row_id;

if (mysqli_query($conn, $query)) {
  	$status=1;
		$message="Project Updated.";
} else {
 
  $message=" Project did not Updated.";
}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
}
?>