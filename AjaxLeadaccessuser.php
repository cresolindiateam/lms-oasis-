<?php

session_start();
include("dbconfig.php");
$lead_id='';

if(isset($_POST['lead_id']))
{
    $lead_id=$_POST['lead_id'];
}
$sql="select TeamMemeberAccessId from leads where id=".$lead_id;

$result = $conn->query($sql);



if ($result->num_rows > 0) {
 
  while($row = $result->fetch_assoc()) {
    
    $output = array(
	"TeamMemeberAccessId"		=>	$row["TeamMemeberAccessId"],

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