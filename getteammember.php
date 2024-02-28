<?php
include("dbconfig.php");
if(isset($_POST['teammemberpassword']))
{
$row_id=$_POST['team_member_id'];
$password=md5($_POST['teammemberpassword']);
$name=$_POST['edit_name'];
$email=$_POST['edit_email'];
$phone=$_POST['edit_phone_number'];
$role=$_POST['edit_role_type'];
$projectid=$_POST['project_id'];
$query = "update  project_team set  project_id ='".$projectid."', role_type ='".$role."',name ='".$name."',email ='".$email."',phone_number ='".$phone."',password ='".$password."' WHERE id = ".$row_id;


if (mysqli_query($conn, $query)) {
  	$status=1;
		$message="Team Member Updated.";
} else {
 
  $message=" Team Memeber did not Updated.";
}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
}
?>