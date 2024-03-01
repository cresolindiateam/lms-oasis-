<?php 
include("dbconfig.php");
if(isset($_POST['clientid']))
{
$status='';
$message='';
$row_id=$_POST['clientid'];
$query = "update  clients set client_hidden_status = 1  WHERE id = ".$row_id;
$exeInsert =mysqli_query($conn, $query);
	if(!empty($exeInsert)){
		$status=1;
		$message="Client Deleted.";
	}else{
	    $status=0;
		$message="Client did not Deleted.";
	}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
}
?>