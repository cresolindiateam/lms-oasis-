<?php

session_start();
include("dbconfig.php");
$lead_id='';

if(isset($_POST['lead_edit_id']))
{
    $lead_id=$_POST['lead_edit_id'];
}
$sql="select name,email,phone_number from leads where id=".$lead_id;

$result = $conn->query($sql);



if ($result->num_rows > 0) {
 
  while($row = $result->fetch_assoc()) {
    
    $output = array(
	"name"		=>	$row["name"],
	"email"		=>	$row["email"],
		"phone"		=>	$row["phone_number"]
);

echo json_encode($output);
    
  }
} else {
  
  $output = array(
	"data"		=>''
);

echo json_encode($output);
}



?>