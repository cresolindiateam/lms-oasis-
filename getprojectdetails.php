<?php
include("dbconfig.php");
if(isset($_POST['projectid']))
{
$row_id=$_POST['projectid'];
$query = "select project_name,project_url,project_image_url,client_name,username from  project_information  WHERE id = ".$row_id;

if (mysqli_query($conn, $query)) {
  	$status=1;
  	$result=mysqli_query($conn, $query);
  	$row = mysqli_fetch_assoc($result);
		$message="Project Get.";
} else {
 
  $message=" Project did not Get.";
}


$data1= array("Status"=>$status,"Message"=>$message,"ProjectName"=>$row['project_name'],"ClientName"=>$row['client_name'],"UserName"=>$row['username'],"ProjectImageUrl"=>$row['project_image_url'],"ProjectUrl"=>$row['project_url']);
echo json_encode($data1);
}
?>