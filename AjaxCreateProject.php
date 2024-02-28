<?php
require 'dbconfig.php';
$name=$_REQUEST["name"];
$client_name=$_REQUEST["client_name"];
$user_name=$_REQUEST["user_name"];
$project_url=$_REQUEST["project_url"];
$project_image_url=$_REQUEST["project_image_url"];
$password=md5($_REQUEST["password"]);
$sqlUniqueEmail="SELECT project_name FROM project_information WHERE project_name = '$name' and username ='$user_name'";
$exeEmail = $conn->query($sqlUniqueEmail);
if($exeEmail->num_rows>0)
{
	$message="Project already used";
}
else
{
  $sqlInsert = "INSERT INTO project_information(project_name,project_url,project_image_url,username,password,client_name)"." VALUES('$name','$project_url','$project_image_url','$user_name','$password','$client_name')";
	$exeInsert = mysqli_query($conn,$sqlInsert);
	$last_id = $conn->insert_id;
	if(!empty($last_id)){
		$status=1;
		$message="New Project Created.";
	}else{
		$message="Project  did not Created.";
	}
}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>