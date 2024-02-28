<?php 
include("dbconfig.php");
if(isset($_POST['projectid']))
{
$status='';
$message='';
$row_id=$_POST['projectid'];
$query = "update  project_information set project_hidden_status = 1  WHERE id = ".$row_id;
$exeInsert =mysqli_query($conn, $query);
	if(!empty($exeInsert)){
		$status=1;
		$message="Project Deleted.";
	}else{
	    $status=0;
		$message="Project did not Deleted.";
	}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
}
?>