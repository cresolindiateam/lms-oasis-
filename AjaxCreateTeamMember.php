<?php
require 'dbconfig.php';

session_start();

$name=$_REQUEST["name"];
$email=$_REQUEST["email"];
$phone_number=$_REQUEST["phone_number"];


	$client_id=$_REQUEST["client_id"];


$role_type=$_REQUEST["role_type"];
$expiry_date=$_REQUEST["teammemberexpiry"];
$password=md5($_REQUEST["password"]);
$sqlUniqueEmail="SELECT email FROM project_team WHERE email = '$email'";
$exeEmail = $conn->query($sqlUniqueEmail);
if($exeEmail->num_rows>0)
{
	$message="email already used";
}
else
{
  $sqlInsert = "INSERT INTO client_team_members(name,username,email,phone_number,client_id,role_type,password,created_at,expiry_date)"." VALUES('$name','$name','$email','$phone_number','$client_id','$role_type','$password',now(),'$expiry_date')";


/*echo $sqlInsert;die;*/

 
	$exeInsert = mysqli_query($conn,$sqlInsert);


	$last_id = $conn->insert_id;
	





 if($role_type==4 )
  {
  
		 if($_SESSION['role_type'] == 3 )
		 {
		 	$team_leader_id=	$_SESSION['proj_team_id'];
		 }
		 else
		 {
		  $team_leader_id=	$_REQUEST['proj_team_id'];
		 }


 $sqlInsert = "INSERT INTO client_team_sub_members(client_id,team_leader_id,team_member_id)"." VALUES('$client_id','$team_leader_id','$last_id')";
	$exeInsert = mysqli_query($conn,$sqlInsert);
  }


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