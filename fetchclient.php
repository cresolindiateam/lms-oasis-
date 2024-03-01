<?php
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);
//fetch.php
include "dbconfig.php";
session_start();
//$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");
$column = ["id", "name", "type", "email", "members", "expiry", "created_at"];

$sess_id = intval($_SESSION["proj_info_id"]);
$role_type = intval($_SESSION["role_type"]);
$query = "";
$query2 = "";
if ($role_type == 1) {
    $query =
        "SELECT clients.id,clients.name,clients.type,clients.email,clients.members,clients.expiry,clients.created_at FROM clients 
             where clients.client_hidden_status=0";
}



if (isset($_POST["search"]["value"])) {
    $query .=
        '
     AND (  
      clients.id LIKE "%' .
        $_POST["search"]["value"] .
        '%" 
    OR clients.name LIKE "%' .
        $_POST["search"]["value"] .
        '%" 
    OR clients.email LIKE "%' .
        $_POST["search"]["value"] .
        '%" 
    OR clients.created_at LIKE "%' .
        $_POST["search"]["value"] .
        '%" ) 
    ';
}

if (isset($_POST["order"])) {
    $query .=
        " ORDER BY " .
        $column[$_POST["order"]["0"]["column"]] .
        " " .
        $_POST["order"]["0"]["dir"] .
        " ";
} else {
    $query .= " ORDER BY id DESC ";
}

$query1 = "";

if ($_POST["length"] != -1) {
    $query1 = " LIMIT " . $_POST["start"] . ", " . $_POST["length"];
}


/*$statement = $conn->prepare($query);
 $statement->execute();*/
/*$result=mysqli_query($conn, $query);*/

$statement = $conn->prepare($query);
$statement->execute();
$number_filter_row = $statement->get_result()->num_rows;
$result = $conn->query($query . $query1);
$data = [];
//$result = /*$conn->query($query . $query1);*/
//mysqli_query($conn,$query . $query1);
//$number_filter_row= mysqli_num_rows($result);
/*$number_filter_row = $count;*/
/*echo $count;die;*/
/*$data = array();*/
foreach ($result as $row) {
    $sub_array = [];
    $sub_array[] = $row["id"];
    $sub_array[] = $row["name"];

    if($row["type"]==1){
    $sub_array[] = "Company";
    }
    else
    {
        $sub_array[] = "Freelancer"; 
    }

    $sub_array[] = $row["email"];
    $sub_array[] = $row["members"];
    $sub_array[] = $row["created_at"];
    $sub_array[] =
        "
        <span title='client edit' style='font-size:10px;' class='fa-passwd-reset fa-stack' onclick='clientedit(" .
        $row["id"] .
        ")'>
        <i class='fa fa-pencil fa-stack-2x'></i>
      
        </span><span onclick='deleteclient(" .
        $row["id"] .
        ")' title='delete client' class='fa-passwd-reset fa-stack'>
        <i class='fa fa-trash fa-stack-1x'></i>
       </span>";
    $data[] = $sub_array;
}

function count_all_data($conn)
{
    $sess_id1 = intval($_SESSION["proj_info_id"]);
    /*$query = "SELECT * FROM leads WHERE project_info_id = ".$sess_id;
    $result=mysqli_query($conn, $query);
    $count= mysqli_num_rows($result);
    return $count;*/

    $role_type1 = intval($_SESSION["role_type"]);

    if ($role_type1 == 1) {
        $query2 = $query =
            "SELECT clients.id,clients.name,clients.type,clients.email,clients.members,clients.expiry,clients.created_at FROM clients where clients.client_hidden_status=0";
    }

    /*  $query2 = "SELECT * FROM project_team WHERE   project_id = ".$sess_id1;*/
    $statement2 = $conn->prepare($query2);
    $statement2->execute();
    return $statement2->get_result()->num_rows;
}

$output = [
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => intval(count_all_data($conn)),
    "recordsFiltered" => intval($number_filter_row),
    "data" => $data,
];

echo json_encode($output);

?>
