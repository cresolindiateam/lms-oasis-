<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//fetch.php
include("dbconfig.php");

session_start();


//$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

$column = array("id", "project_name", "project_image_url", "client_name","created_at");

$sess_id= intval($_SESSION['proj_info_id']);
$role_type= intval($_SESSION['role_type']);
$query='';
$query2='';
if($role_type==1 ){
$query = "SELECT * FROM project_information where 1 and project_hidden_status=0";
}





if(isset($_POST["search"]["value"]))
{
	$query .= '
	 AND (  
      id LIKE "%'.$_POST["search"]["value"].'%" 
	OR project_name LIKE "%'.$_POST["search"]["value"].'%" 
	OR project_image_url LIKE "%'.$_POST["search"]["value"].'%" 
	OR client_name LIKE "%'.$_POST["search"]["value"].'%" 
	
	OR created_at LIKE "%'.$_POST["search"]["value"].'%" ) 
	';
}

if(isset($_POST['order']))
{
	$query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY id DESC ';
}



$query1 = '';

if($_POST['length'] != -1)
{
	$query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

/*echo $query;die;*/

/*$statement = $conn->prepare($query);



$statement->execute();*/
/*$result=mysqli_query($conn, $query);*/



$statement = $conn->prepare($query);

$statement->execute();

$number_filter_row = $statement->get_result()->num_rows;

$result = $conn->query($query . $query1);

$data = array();



//$result = /*$conn->query($query . $query1);*/
//mysqli_query($conn,$query . $query1);

//$number_filter_row= mysqli_num_rows($result);

/*$number_filter_row = $count;*/

/*echo $count;die;*/





/*$data = array();*/
	foreach($result as $row)
{


$sub_array = array();
	
$sub_array[] = $row['id'];

	$sub_array[] = $row['project_name'];

	$sub_array[] = $row['client_name'];

/*$sub_array[] = '<span onload="myFunction()"></span><button  id="team_project_count_'.$row['id'].'" onclick="teamCount('.$row['id'].')">View</button>';
$sub_array[] = '<button  id="admin_project_count_'.$row['id'].'" onclick="adminCount('.$row['id'].')">View</button>';
*/
	$sub_array[] = '<img style="height:40px;width:50px;" src='.$row['project_image_url'].'>';

	$sub_array[] = $row['created_at'];

		$sub_array[] = "
		<span title='password reset' style='font-size:10px;' class='fa-passwd-reset fa-stack' onclick='passwordchange(".$row['id'].")'>
        <i class='fa fa-undo fa-stack-2x'></i>
        <i class='fa fa-lock fa-stack-1x'></i>
    </span><span onclick='deleteproject(".$row['id'].")' title='delete project' class='fa-passwd-reset fa-stack'>
        <i class='fa fa-trash fa-stack-1x'></i>
        
    </span>";

	$data[] = $sub_array;
}






function count_all_data($conn)
{
	$sess_id1= intval($_SESSION['proj_info_id']);
	/*$query = "SELECT * FROM leads WHERE project_info_id = ".$sess_id;
    $result=mysqli_query($conn, $query);
	$count= mysqli_num_rows($result);
	return $count;*/


$role_type1= intval($_SESSION['role_type']);

if($role_type1==1){
$query2 = "SELECT * FROM project_information where 1";
}


/*	$query2 = "SELECT * FROM project_team WHERE   project_id = ".$sess_id1;*/


	$statement2 = $conn->prepare($query2);

	$statement2->execute();

/*print_r($statement2->get_result());
die;*/

	return $statement2->get_result()->num_rows;
}

$output = array(
	"draw"		=>	intval($_POST["draw"]),
	"recordsTotal"	=>	intval(count_all_data($conn)),
	"recordsFiltered"	=>	intval($number_filter_row),
	"data"		=>	$data
);

echo json_encode($output);

?>