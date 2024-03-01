<?php
include("dbconfig.php");
if(isset($_POST['edit_name']))
{

	

	$row_id=$_POST['project_id'];
	$name=$_POST['edit_name'];
	$client_name=$_POST['edit_client_name'];
	$project_image_url=$_POST['edit_project_image_url'];
	$project_url=$_POST['edit_project_url'];
    $project_desc=$_POST['edit_project_desc'];



	$query = "update  project_information set project_desc ='".$project_desc."',project_name ='".$name."',project_url ='".$project_url."',project_image_url ='".$project_image_url."',client_id ='".$client_name."' WHERE id = ".$row_id;
	if (mysqli_query($conn, $query)) 
	{
	  	$status=1;
			$message="Project Updated.";
	} 
	else 
	{
	 
	    $message=" Project did not Updated.";
	}
 $data1= array("Status"=>$status,"Message"=>$message);
 echo json_encode($data1);
}
?>