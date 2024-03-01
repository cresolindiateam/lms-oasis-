<?php
require 'dbconfig.php';
$name=$_REQUEST["name"];
$client_type=$_REQUEST["client_type"];
$client_email=$_REQUEST["client_email"];
$client_expiry=$_REQUEST["client_expiry"];
$client_members=$_REQUEST["client_members"];


$sqlUniqueEmail="SELECT id FROM clients WHERE name = '$name' and  email='$client_email'";
$exeEmail = $conn->query($sqlUniqueEmail);

if($exeEmail->num_rows>0)
{
	$status=2;
	$message="Client already exist";
}
else
{
   $sqlInsert = "INSERT INTO clients(name,type,email,expiry,members)"." VALUES('$name','$client_type','$client_email','$client_expiry',$client_members)";

   $exeInsert = mysqli_query($conn,$sqlInsert);
   $last_id = $conn->insert_id;
	if(!empty($last_id)){
		$status=1;
		$message="New Client Created.";
	}else{
		$status=2;
		$message="Client  did not Created.";
	}
}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>