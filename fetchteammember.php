<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include("dbconfig.php");
session_start();


$column = array("id", "name", "email", "phone_number", "role_type","project_id","created_at");
$sess_id= intval($_SESSION['proj_info_id']);
$role_type= intval($_SESSION['role_type']);
$team_member_id= intval($_SESSION['proj_team_id']);
$query='';
$query2='';
if($role_type==1 ){
$query = "SELECT client_team_members.created_at, client_team_members.id,client_team_members.name,client_team_members.email,client_team_members.phone_number,client_team_members.role_type,client_team_members.client_id,client_team_members.expiry_date,client_team_members.client_id,clients.name as client_name FROM client_team_members left join clients on clients.id=client_team_members.client_id where 1  and client_team_members.team_hidden_status=0 and client_team_members.role_type!=1";
}
else if($role_type==2)
{
  $query = "SELECT client_team_members.created_at,client_team_members.id,client_team_members.name,client_team_members.email,client_team_members.phone_number,client_team_members.role_type,client_team_members.expiry_date,client_team_members.client_id,clients.name as client_name FROM client_team_members left join clients on clients.id=client_team_members.client_id where 1 and client_team_members.team_hidden_status=0 and (client_team_members.role_type=3 or client_team_members.role_type=4)  and client_id = ".$sess_id;
}

else if($role_type==3)
{
  $query = "SELECT client_team_members.created_at,client_team_members.id,client_team_members.name,client_team_members.email,client_team_members.phone_number,client_team_members.role_type,client_team_members.expiry_date,client_team_members.client_id,clients.name as client_name FROM client_team_members left join clients on clients.id=client_team_members.client_id where 1 and client_team_members.team_hidden_status=0 and  client_team_members.role_type=4  and client_id = ".$sess_id;
}

else
{
   $query = "SELECT client_team_members.*,project_information.project_name FROM client_team_members left join project_information on project_information.id=client_team_members.client_id where 1 and client_team_members.team_hidden_status=0  and  project_id = ".$sess_id;

}




if(isset($_POST["search"]["value"]))
{
	$query .= '
	 AND (  
      client_team_members.id LIKE "%'.$_POST["search"]["value"].'%" 
	OR client_team_members.name LIKE "%'.$_POST["search"]["value"].'%" 
	OR client_team_members.email LIKE "%'.$_POST["search"]["value"].'%" 
	OR client_team_members.phone_number LIKE "%'.$_POST["search"]["value"].'%" 
		OR client_team_members.role_type LIKE "%'.$_POST["search"]["value"].'%" 
		OR client_team_members.name LIKE "%'.$_POST["search"]["value"].'%" 
	OR client_team_members.created_at LIKE "%'.$_POST["search"]["value"].'%" ) 
	';
}

if(isset($_POST['order']))
{
	$query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY client_team_members.id DESC ';
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

	if($row['role_type']==1)
	{
	  $sub_array[] = 'Super Admin';
	}
	else if($row['role_type']==2)
	{
	  $sub_array[] = 'Admin';
	}
	else if($row['role_type']==3)
	{
	  $sub_array[] = 'Team Leader';
	}
	else if($row['role_type']==4)
	{
	  $sub_array[] = 'Team Member';
	}
    $color="color:green";
	if($row['expiry_date']==='0000-00-00')
	{
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
		 $sql = "UPDATE client_team SET team_hidden_status=1 WHERE id=".$row['id'];
			if(mysqli_query($conn, $sql))
			{
			    echo "";
			}   
		}
	 $sub_array[] = '<span style="'.$color.'">'.date('Y-m-d',strtotime($row['expiry_date'])).'</span>';
	}

	$sub_array[] = $row['client_name'];
	$sub_array[] = $row['created_at'];

		$sub_array[] = "
		<span title='password reset' style='font-size:10px;' class='fa-passwd-reset fa-stack' onclick='passwordchange(".$row['id'].")'>
        
        <i class='fa fa-pencil fa-stack-2x'></i>
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
$query2 = "SELECT client_team_members.created_at,client_team_members.id,client_team_members.name,client_team_members.email,client_team_members.phone_number,client_team_members.role_type,client_team_members.expiry_date,client_team_members.client_id,clients.name as client_name FROM client_team_members left join clients on clients.id=client_team_members.client_id where 1  and client_team_members.team_hidden_status=0 and client_team_members.role_type!=1";
}
else if($role_type1==2)
{
    //$query2 = "SELECT * FROM client_team_members WHERE  role_type=3 and team_hidden_status=0 and  project_id = ".$sess_id1;

   $query2 = "SELECT client_team_members.created_at,client_team_members.id,client_team_members.name,client_team_members.email,client_team_members.phone_number,client_team_members.role_type,client_team_members.expiry_date,client_team_members.client_id,clients.name as client_name FROM client_team_members left join clients on clients.id=client_team_members.client_id where 1 and client_team_members.team_hidden_status=0 and (client_team_members.role_type=3 or client_team_members.role_type=4)  and client_id = ".$sess_id1;

    
}

else if($role_type1==3)
{
    //$query2 = "SELECT * FROM client_team_members WHERE  role_type=3 and team_hidden_status=0 and  project_id = ".$sess_id1;

   $query2 = "SELECT client_team_members.created_at,client_team_members.id,client_team_members.name,client_team_members.email,client_team_members.phone_number,client_team_members.role_type,client_team_members.expiry_date,client_team_members.client_id,clients.name as client_name FROM client_team_members left join clients on clients.id=client_team_members.client_id where 1 and client_team_members.team_hidden_status=0 and client_team_members.role_type=4  and client_id = ".$sess_id1;

    
}

else
{ 
     /*$query2 = "SELECT * FROM client_team_members where project_id = ".$sess_id1;*/
     $query2 = "SELECT client_team_members.*,project_information.project_name FROM client_team_members left join project_information on project_information.id=client_team_members.client_id where 1 and client_team_members.team_hidden_status=0  and  project_id = ".$sess_id1;

}

/*echo $query2;die;*/


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