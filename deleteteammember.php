<?php 
include("dbconfig.php");
if(isset($_POST['teammemberid']))
{
$status='';
$message='';
$row_id=$_POST['teammemberid'];
$query = "update  client_team_members set team_hidden_status = 1  WHERE id = ".$row_id;
$exeInsert =mysqli_query($conn, $query);
	if(!empty($exeInsert)){
		$status=1;
		$message="Team Member Deleted.";
	}else{
	    $status=0;
		$message="Team Member did not Deleted.";
	}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
}
?>