<?php
require 'dbconfig.php';
/*print_r($_POST);die;*/

$created_at_date='';
if($_POST['created_at_date']){
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


$sqlUniqueEmail="SELECT  id FROM leads WHERE phone_number = '$phone_number'";
  
$exeEmail = $conn->query($sqlUniqueEmail);


if($exeEmail->num_rows>0){
    
	$message="phone Number already used.";
}else{
	
$sqlInsert="CALL insertdatalead('$name','$email','$phone_number','$ipAddress','$platformType','$project_type',0,'$form_type',$teammemberid,'$created_at_date')";


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