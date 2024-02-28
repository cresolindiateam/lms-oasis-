<?php
include("dbconfig.php");

if(isset($_POST['rowid']))
{
$row_id=$_POST['rowid'];

$query = "update  leads set lead_hidden_status = 1  WHERE id = ".$row_id;

if (mysqli_query($conn, $query)) {
  echo json_encode("success",TRUE);
} else {
  echo json_encode("success",FALSE);
}

}


?>