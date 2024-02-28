<?php
require 'dbconfig.php';
$lead_id=$_REQUEST["lead_edit_lead_id"];

$name=$_REQUEST["name"];
$email=$_REQUEST["email"];
$phone_number=$_REQUEST["phone"];

/*$sqlInsert = "INSERT INTO leads(name,email,phone_number,project_info_id,lead_source,created_at,ip_address,platform_type,team_id)"." 
VALUES('$name','$email','$phone_number','$project_type','$form_type',now(),'$ipAddress','$platformType',$teammemberid)";
*/
$sqlInsert = "update leads set name='".$name."',email='".$email."',phone_number='".$phone_number."' where id=".$lead_id;  






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