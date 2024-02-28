<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include("dbconfig.php");

session_start();



$column = array("id", "name", "email", "phone_number", "role_type","project_id","created_at");

$sess_id= intval($_SESSION['proj_info_id']);
$role_type= intval($_SESSION['role_type']);
$query='';
$query2='';
if($role_type==1 ){
$query = "SELECT project_team.*,project_information.project_name FROM project_team left join project_information on project_information.id=project_team.project_id where 1 and project_team.role_type!=1";
}
else if($role_type==2)
{
$query = "SELECT project_team.*,project_information.project_name FROM project_team left join project_information on project_information.id=project_team.project_id where 1 and project_team.team_hidden_status=0 and project_team.role_type=3 and  project_id = ".$sess_id;

    
}
else
{
   $query = "SELECT project_team.*,project_information.project_name FROM project_team left join project_information on project_information.id=project_team.project_id where 1 and project_team.team_hidden_status=0  and  project_id = ".$sess_id;

     
}





if(isset($_POST["search"]["value"]))
{
	$query .= '
	 AND (  
      project_team.id LIKE "%'.$_POST["search"]["value"].'%" 
	OR project_team.name LIKE "%'.$_POST["search"]["value"].'%" 
	OR project_team.email LIKE "%'.$_POST["search"]["value"].'%" 
	OR project_team.phone_number LIKE "%'.$_POST["search"]["value"].'%" 
		OR project_team.role_type LIKE "%'.$_POST["search"]["value"].'%" 
		
		OR project_information.project_name LIKE "%'.$_POST["search"]["value"].'%" 
	OR project_team.created_at LIKE "%'.$_POST["search"]["value"].'%" ) 
	';
}

if(isset($_POST['order']))
{
	$query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY project_team.id DESC ';
}



$query1 = '';

if($_POST['length'] != -1)
{
	$query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}


$statement = $conn->prepare($query);

$statement->execute();

$number_filter_row = $statement->get_result()->num_rows;

$result = $conn->query($query . $query1);

$data = array();





	foreach($result as $row)
{


$sub_array = array();
	
$sub_array[] = $row['id'];

	$sub_array[] = $row['name'];

	$sub_array[] = $row['email'];

	$sub_array[] = $row['phone_number'];

if($row['role_type']==1){
$sub_array[] = 'Super Admin';
}else if($row['role_type']==2)
{$sub_array[] = 'Admin';}
else if($row['role_type']==3)
{
    $sub_array[] = 'Team Member';
}

$color="color:green";
	



	
	
	if($row['expiry_date']==='0000-00-00'){
	 $sub_array[] = '-';
}
else
{
    $datediff=0;
    $days;
    $your_date=0;
	$now = time(); 
$your_date = strtotime($row['expiry_date']);
$datediff = $now - $your_date;
$days= round($datediff / (60 * 60 * 24));

if($days<=7)
{
 $color="color:red";   
}

if($days<=0)
{
 $sql = "UPDATE project_team SET team_hidden_status=1 WHERE id=".$row['id'];
if(mysqli_query($conn, $sql)){
    echo "";
}   
}



    $sub_array[] = '<span style="'.$color.'">'.date('Y-m-d',strtotime($row['expiry_date'])).'</span>';
}

	
	$sub_array[] = $row['project_name'];

	$sub_array[] = $row['created_at'];

		$sub_array[] = "
		<span title='password reset' style='font-size:10px;' class='fa-passwd-reset fa-stack' onclick='passwordchange(".$row['id'].")'>
        <i class='fa fa-undo fa-stack-2x'></i>
        <i class='fa fa-lock fa-stack-1x'></i>
    </span><span onclick='deleteteammember(".$row['id'].")' title='delete member' class='fa-passwd-reset fa-stack'>
        <i class='fa fa-trash fa-stack-1x'></i>
        
    </span>";

	$data[] = $sub_array;
}






function count_all_data($conn)
{
	$sess_id1= intval($_SESSION['proj_info_id']);

$role_type1= intval($_SESSION['role_type']);

if($role_type1==1){
$query2 = "SELECT project_team.*,project_information.project_name FROM project_team left join project_information on project_information.id=project_team.project_id where 1 and project_team.team_hidden_status=0 and project_team.role_type=1";
}
else if($role_type1==2)
{
    //$query2 = "SELECT * FROM project_team WHERE  role_type=3 and team_hidden_status=0 and  project_id = ".$sess_id1;

    $query2 = "SELECT project_team.*,project_information.project_name FROM project_team left join project_information on project_information.id=project_team.project_id where 1 and project_team.team_hidden_status=0 and project_team.role_type=3 and  project_id = ".$sess_id1;

    
}
else
{ 
     /*$query2 = "SELECT * FROM project_team where project_id = ".$sess_id1;*/
     $query2 = "SELECT project_team.*,project_information.project_name FROM project_team left join project_information on project_information.id=project_team.project_id where 1 and project_team.team_hidden_status=0  and  project_id = ".$sess_id1;

}

	$statement2 = $conn->prepare($query2);

	$statement2->execute();

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