<?php
error_reporting(1);
ini_set('display_errors', 1);
include("dbconfig.php");
session_start();
$column = array("id", "lead_id", "team_member_id", "message", "created_at","next_followup_date","next_followup_time");
$sess_id= intval($_SESSION['proj_info_id']);
$role_type= intval($_SESSION['role_type']);
$project_team_id= intval($_SESSION['proj_team_id']);
$lead_id= intval($_POST['lead_id']);
$query='';
//superadmin
if($role_type==1||$role_type==2 || $role_type==3)
{
    //and team_member_id = ".$project_team_id
     $query = "SELECT lead_followup.next_followup_date,lead_followup.next_followup_time,lead_followup.id,lead_followup.message,lead_followup.created_at,lead_followup.lead_id,lead_followup.team_member_id,project_team.name FROM  lead_followup left join project_team on project_team.id=lead_followup.team_member_id WHERE lead_followup.lead_id=".$lead_id." and lead_followup.lead_follow_hidden_status=0";
}


if(isset($_POST["search"]["value"]))
{ 
	$query .= ' 
	 AND (  
      lead_followup.id LIKE "%'.$_POST["search"]["value"].'%" 
     OR lead_followup.message LIKE "%'.$_POST["search"]["value"].'%" 
   OR lead_followup.next_followup_date LIKE "%'.$_POST["search"]["value"].'%" 
    OR lead_followup.next_followup_time LIKE "%'.$_POST["search"]["value"].'%" 
    
	OR lead_followup.created_at LIKE "%'.$_POST["search"]["value"].'%" ) 
	';
}
if(isset($_POST['order']))
{
    	$query .= ' ORDER BY lead_followup.'.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';

}
else
{
	$query .= ' ORDER BY lead_followup.id DESC ';
}
$query1 = '';
if($_POST['length'] != -1)
{
	$query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

/*echo $query;die;*/
$statement = $conn->prepare($query);
$statement->execute();
$number_filter_row = $statement->get_result()->num_rows;
$result = $conn->query($query . $query1);
$data = array();
	foreach($result as $row)
{
    $sub_array = array();
	$sub_array[] = $row['id'];
	$sub_array[] = $row['lead_id'];
	$sub_array[] = $row['team_member_id'];

	$sub_array[] = $row['name'];
	$sub_array[] = $row['message'];
	$sub_array[] = date("Y-m-d", strtotime($row['created_at']));
		$sub_array[] = $row['next_followup_date'];
	$sub_array[] = $row['next_followup_time'];
	$sub_array[] = "<i onclick='leadfollowstatus(".$row['id'].")' class='fa fa-trash'></i>";
	$data[] = $sub_array;
}
function count_all_data($conn)
{
	$sess_id1= intval($_SESSION['proj_info_id']);
	$role_type1= intval($_SESSION['role_type']);
    $project_team_id1= intval($_SESSION['proj_team_id']);
$query2='';
$lead_id= intval($_POST['lead_id']);
if($role_type1==1 || $role_type1==2 || $role_type1==3)
{
 $query2 = "SELECT lead_followup.id,lead_followup.message,lead_followup.created_at,lead_followup.lead_id,lead_followup.team_member_id,project_team.name FROM  lead_followup left join project_team on project_team.id=lead_followup.team_member_id WHERE lead_followup.lead_id=".$lead_id." and lead_followup.lead_follow_hidden_status=0";
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