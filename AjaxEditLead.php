<?php
require 'dbconfig.php';
$lead_id=$_REQUEST["lead_edit_lead_id"];
$name=$_REQUEST["name"];
$email=$_REQUEST["email"];
$phone_number=$_REQUEST["phone"];
$interested_location=$_REQUEST["interested_location"];
$interested_for=$_REQUEST["interested_for"];
$budget=$_REQUEST["budget"];
$project_type=$_REQUEST["project_type"];
$created_at_date=$_REQUEST["created_at_date"];
$form_type=$_REQUEST["form_type"];
$reference_by=$_REQUEST["reference_by"];

/*$sqlInsert = "INSERT INTO leads(name,email,phone_number,project_info_id,lead_source,created_at,ip_address,platform_type,team_id)"." 
VALUES('$name','$email','$phone_number','$project_type','$form_type',now(),'$ipAddress','$platformType',$teammemberid)";
*/
$sqlInsert = "update leads set name='".$name."',email='".$email."',phone_number='".$phone_number."',location='".$interested_location."',interested_for='".$interested_for."',budget='".$budget."',project_assigned='".$project_type."',lead_source='".$form_type."',reference_by='".$reference_by."',created_at='".$created_at_date."',reference_by='".$reference_by."' where id=".$lead_id;  

	$exeInsert = mysqli_query($conn,$sqlInsert);
	$last_id = $conn->insert_id;
	if(!empty($exeInsert)){
		$status=1;
		$message="Lead has been Updated.";
	}else{
		$message="Lead did not Updated.";
	}
/*}*/
/*$db->close(); */

$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>