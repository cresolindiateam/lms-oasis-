<?php
require 'dbconfig.php';
$created_at_date='';
if($_POST['created_at_date'])
{
  $created_at_date=$_POST['created_at_date'];
}
else
{
  $created_at_date=date("Y-m-d");
}

$name=$_REQUEST["name"];
$email=$_REQUEST["email"];
$phone_number=$_REQUEST["phone_number"];
$project_type=$_REQUEST["project_type"];
$form_type=$_REQUEST["form_type"];
$platformType='';
$ipAddress='';   
$platformType=$_REQUEST["platformType"];
$ipAddress=$_REQUEST["ipAddress"];
$teammemberid=$_REQUEST['teammemberid'];
$reference_by=$_REQUEST['reference_by'];
$location=$_REQUEST["location"];
$budget=$_REQUEST['budget'];
$interested_for=$_REQUEST['interested_for'];
$client_id=$_REQUEST['client_type'];

$sqlUniqueEmail="SELECT  id FROM leads WHERE phone_number = '$phone_number'";
$exeEmail = $conn->query($sqlUniqueEmail);


if($exeEmail->num_rows>0)
{
  $message="phone Number already used.";
}
else
{
  $sqlInsert="CALL insertdatalead('$name','$email','$phone_number','$ipAddress','$platformType','$project_type',0,'$form_type',$teammemberid,'$created_at_date','$reference_by','$location','$budget','$interested_for','$client_id')";



	$exeInsert = mysqli_query($conn,$sqlInsert);
	$last_id = $conn->insert_id;
	if(!empty($exeInsert)){
		$status=1;
		$message="New Lead Created.";
	}else{
		$message="Lead did not Created.";
	}
}


$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>