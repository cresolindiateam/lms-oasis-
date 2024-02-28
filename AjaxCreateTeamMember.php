<?php
require 'dbconfig.php';
$name=$_REQUEST["name"];
$email=$_REQUEST["email"];
$phone_number=$_REQUEST["phone_number"];
$project_id=$_REQUEST["project_id"];
$role_type=$_REQUEST["role_type"];
$password=md5($_REQUEST["password"]);
$sqlUniqueEmail="SELECT email FROM project_team WHERE email = '$email'";
$exeEmail = $conn->query($sqlUniqueEmail);
if($exeEmail->num_rows>0)
{
	$message="email already used";
}
else
{
  $sqlInsert = "INSERT INTO project_team(name,email,phone_number,project_id,role_type,password,created_at)"." VALUES('$name','$email','$phone_number','$project_id','$role_type','$password',now())";
	$exeInsert = mysqli_query($conn,$sqlInsert);
	$last_id = $conn->insert_id;
	if(!empty($last_id)){
		$status=1;
		$message="New Team Member Created.";
	}else{
		$message="Project Team did not Created.";
	}
}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>