<?php 
include("dbconfig.php");
if(isset($_POST['projectid']))
{
$status='';
$message='';
$row_id=$_POST['projectid'];
$query = "select count(id) from  project_team   WHERE 1 and role_type=2 and project_id = ".$row_id;
echo $query;die;
$exeInsert =mysqli_query($conn, $query);
$rowCount = mysqli_num_rows($exeInsert);
	if(!empty($exeInsert)){
		$status=1;
		$message="Project Member Count.";
	}else{
	    $status=0;
		$message="Project Member Count did not Count.";
	}
$data1= array("Status"=>$status,"Message"=>$message,"Count"=>$rowCount);
echo json_encode($data1);
}
?>