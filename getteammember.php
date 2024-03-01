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
$clientid=$_POST['client_id'];
$expiry_date=$_POST['teammemberexpiryedit'];
$query = "update  client_team_members set  client_id ='".$clientid."', role_type ='".$role."',name ='".$name."',email ='".$email."',phone_number ='".$phone."',password ='".$password."',expiry_date ='".$expiry_date."' WHERE id = ".$row_id;





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