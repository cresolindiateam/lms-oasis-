<?php
error_reporting(1);
ini_set('display_errors', 1);
include("dbconfig.php");
session_start();
$column = array("id", "name", "email", "phone_number", "lead_source", "ip_address","platform_type","client_id","created_at","team_member_access_id");
$role_type= intval($_SESSION['role_type']);
$sess_id= intval($_SESSION['client_id']);
$project_team_id= intval($_SESSION['proj_team_id']);
//follow up pending dates
$followupsql = "select concat(`next_last_followup_date`, ' ', `next_last_followup_time`) as pendingleadfollowdata from leads where concat(`next_last_followup_date`, ' ', `next_last_followup_time`)<= now() and `next_last_followup_date` !='' ORDER BY `id` DESC";
$followupstatement = $conn->prepare($followupsql);
$followupstatement->execute();
$number_follow_row = $followupstatement->get_result()->num_rows;
$followresult = $conn->query($followupsql);
$data1234=array();


$client_id='';
$client_id=$_SESSION['proj_info_id'];


	foreach($followresult as $row5)
{
  $data1234[]=  $row5['pendingleadfollowdata'];
    
}
$query='';

if($role_type==1)
{
    
  $member_id=$_POST['leadmemberid'];
  if($member_id!=0 && $member_id!=null)
    {
      $data=mysqli_query($conn,"CALL `fetchleads`(".$member_id.", '', @p2,'', '','')");
      $res=mysqli_query($conn,"select @p2");
      $datares=mysqli_fetch_assoc($res);
      $query=$datares['@p2'];
    }
    else
    {
      $data=mysqli_query($conn,"CALL `fetchleads`('', '', @p2,'', '','')");
      $res=mysqli_query($conn,"select @p2");
      $datares=mysqli_fetch_assoc($res);
      $query=$datares['@p2'];
    }

}
else if($role_type==2|| $role_type==3)
{
    $member_id=$_POST['leadmemberid'];
    if($member_id!=0 && $member_id!=null)
    {
      $data=mysqli_query($conn,"CALL `fetchleads`(".$member_id.", ".$sess_id.", @p2,'', '',".$client_id.")");
      $res=mysqli_query($conn,"select @p2");
      $datares=mysqli_fetch_assoc($res);
      $query=$datares['@p2'];
    }
    else
    {
      $data=mysqli_query($conn,"CALL `fetchleads`('', ".$sess_id.", @p2,'', '',".$client_id.")");
      $res=mysqli_query($conn,"select @p2");
      $datares=mysqli_fetch_assoc($res);
      $query=$datares['@p2'];
    }
}
else
{

    $data=mysqli_query($conn,"CALL `fetchleads`(".$project_team_id.", ".$sess_id.", @p2,'', '',".$client_id.")");
    $res=mysqli_query($conn,"select @p2");
    $datares=mysqli_fetch_assoc($res);
    $query=$datares['@p2'];
}



if(isset($_POST["leadcheckid"]) && $_POST["leadcheckid"]!='')
{
	$query .= '
	 AND  leads.lead_status='.$_POST["leadcheckid"]; 
}

if(isset($_POST["search"]["value"]))
{
	$query .= '
	 AND (  
      leads.id LIKE "%'.$_POST["search"]["value"].'%" 
	OR leads.name LIKE "%'.$_POST["search"]["value"].'%" 
	OR leads.email LIKE "%'.$_POST["search"]["value"].'%" 
	OR leads.phone_number LIKE "%'.$_POST["search"]["value"].'%" 
	OR leads.lead_source LIKE "%'.$_POST["search"]["value"].'%" 
	OR leads.ip_address LIKE "%'.$_POST["search"]["value"].'%" 
	OR leads.platform_type LIKE "%'.$_POST["search"]["value"].'%" 
	OR lead_status_info.lead_status_name LIKE "%'.$_POST["search"]["value"].'%" 
	OR leads.project_info_id LIKE "%'.$_POST["search"]["value"].'%" 
    OR leads.next_last_followup_date LIKE "%'.$_POST["search"]["value"].'%"  
    OR leads.next_last_followup_time LIKE "%'.$_POST["search"]["value"].'%" 
	OR leads.created_at LIKE "%'.$_POST["search"]["value"].'%" ) 
	';
}
if(isset($_POST['order']))
{
	$query .= ' ORDER BY leads.'.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= ' ORDER BY leads.id DESC ';
}

$query1 = '';
if($_POST['length'] != -1)
{
	$query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

/*$statement = $conn->prepare($query);
$statement->execute();*/
/*$result=mysqli_query($conn, $query);*/

// print_r($query);die;
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
$bg='';
/*$data = array();*/
/*echo "<pre>";
print_r($result);*/
$resultfollowmessagedata='--';
	foreach($result as $row)
{
 //recent message
 $sqlfollowmessage = "SELECT lead_followup.message FROM `lead_followup`  WHERE lead_followup.lead_follow_hidden_status=0 and lead_followup.message!='' and `lead_id` =".$row['id']." ORDER BY lead_followup.`id` DESC limit 1";
 $resultfollowmessage = $conn->query($sqlfollowmessage);
  if($resultfollowmessage->num_rows > 0)
   {
      while($followrecentmessagerow = $resultfollowmessage->fetch_assoc())
       {
        $resultfollowmessagedata=$followrecentmessagerow['message'];
       }
   }
else
{
    $resultfollowmessagedata="--";
}

$sub_array = array();
$sub_array["DT_RowId"] = "row_".$row['id'];
$sub_array[] = $row['id'];
$sub_array[] = $row['name'];
$sub_array[] = $row['email'];
$sub_array[] = $row['phone_number'];
$sub_array[] = $row['lead_source'];
$lead_rel_status_text='';
if($row['lead_relevent']==1)
{
    $lead_rel_status_text="Relevent";
}
if($row['lead_relevent']==0)
{
   $lead_rel_status_text="Non Relevent"; 
}
if($row['lead_relevent']==2)
{
    $lead_rel_status_text="Status";
}

/*$sub_array[] = "<button type='button' onclick='leadreleventstatus(".$row['id'].")'>".$lead_rel_status_text."</button>";*/
$lead_status_text=$row['lead_status_name'];

// print_r($row);die;


// if($row['lead_status_name']==0)
// {
//     $lead_status_text="Raw";
// }
// if($row['lead_status_name']==1)
// {
//    $lead_status_text="Cold"; 
// }
// if($row['lead_status_name']==2)
// {
//   $lead_status_text="Warm";  
// }
// if($row['lead_status_name']==3)
// {
//   $lead_status_text="Hot";  
// }
// if($row['lead_status_name']==4)
// {
//   $lead_status_text="Non-relevent";  
// }
$sub_array[] = "<button type='button' onclick='leadstatus(".$row['id'].")'>".$lead_status_text."</button>";
            if($row['next_last_followup_date']!='')
            {
              if($number_follow_row>0)
                {
                  if (in_array($row['next_last_followup_date'].' '.$row['next_last_followup_time'], $data1234))
                  {
                    $sub_array[] = $row['next_last_followup_date'].' '.$row['next_last_followup_time'].'<input type="hidden" class="pending" value="pending"/>';
                  }
                 else
                  {
                    $sub_array[] = $row['next_last_followup_date'].' '.$row['next_last_followup_time'];
                  }
                }
                else
                {
                  $sub_array[] = '-';  
                }
            }
            else
            {
                $sub_array[] = '-';
            }
if(intval($row['team_member_access_id'])==0)
{
  if(intval($_SESSION['role_type'])!=3)
  {
  	$sub_array[] = "<div style='display:flex;'>
	<a href='javascript:void(0)' style='margin-top: -3px;margin-right: 10px;color: blue!important;
    margin-left:10px;font-size:15px;'  onclick='event.preventDefault();leadfollowup(".$row['id'].")'>"
	.$resultfollowmessagedata."</a></div>";
  }
    else
    {
        $sub_array[] = "<div style='display:flex;'>
	<a href='javascript:void(0)' style='margin-top: -3px;margin-right: 10px;color: blue!important;
    margin-left:10px;font-size:15px;'  onclick='event.preventDefault();leadfollowup(".$row['id'].")'>
	".$resultfollowmessagedata."</a></div>";
     }
}
else
{
    if(intval($_SESSION['role_type'])!=3)
    {
    	$sub_array[] = "<div style='display:flex;'>
    <a href='javascript:void(0)' style='margin-top: -3px;margin-right: 10px;color: blue!important;
    margin-left:10px;font-size:15px;'  onclick='event.preventDefault();leadfollowup(".$row['id'].")'>
	".$resultfollowmessagedata."</a></div>";
    }
    else
    {
       $sub_array[] = "<div style='display:flex;'>
	<a href='javascript:void(0)' style='margin-top: -3px;margin-right: 10px;color: blue!important;
    margin-left:10px;font-size:15px;'  onclick='event.preventDefault();leadfollowup(".$row['id'].")'>
	".$resultfollowmessagedata."</a></div>";
    }
}
   	$sub_array[] = $row['ip_address'];
	$sub_array[] = $row['platform_type'];
	$sub_array[] = $row['project_info_id'];
    if($row['created_at']==='0000-00-00 00:00:00')
    {
      $sub_array[] = '-';
    }
    else
    {
      $sub_array[] = date('Y-m-d',strtotime($row['created_at']));
    }
   if(intval($row['team_member_access_id'])==0)
    {
     if(intval($_SESSION['role_type'])!=3)
     {
      $sub_array[] = "<div style='display:flex;'><i class='fa fa-pencil' id='row_".$row['id']."' onclick='editrow(".$row['id'].")'></i>&nbsp;&nbsp; <i class='fa fa-trash' aria-hidden='true' id='row_".$row['id']."' onclick='hiderow(".$row['id'].")'></i>&nbsp;&nbsp;<i title='member access' data-toggle='modal' data-target='#add_lead_member_access_modal' onclick='teammemberaccess(".$row['id'].")' style='font-size:15px' class='fa fa-users' id='row_".$row['id']."'></i></div>";
     }
    else
    {
     $sub_array[] = "<div style='display:flex;'>
	<i class='fa fa-trash' aria-hidden='true' id='row_".$row['id']."' onclick='hiderow(".$row['id'].")'></i>
	</div>";
    }
   }
else
{
    if(intval($_SESSION['role_type'])!=3)
    {
     	$sub_array[] = "<div style='display:flex;'><i class='fa fa-pencil' id='row_".$row['id']."' onclick='editrow(".$row['id'].")'></i>&nbsp;&nbsp;<i class='fa fa-trash' aria-hidden='true' id='row_".$row['id']."'  onclick='hiderow(".$row['id'].")'></i>&nbsp;&nbsp;<i title='member assigned' data-toggle='modal' data-target='#add_lead_member_access_modal' onclick='teammemberaccess(".$row['id'].")' class='fa fa-user-plus' id='row_".$row['id']."'></i></div>";
    }
    else
    {
       $sub_array[] = "<div style='display:flex;'><i class='fa fa-trsah' aria-hidden='true' id='row_".$row['id']."' onclick='hiderow(".$row['id'].")'></i>&nbsp;&nbsp;</div>";
    }
}
 	$sub_array[] = $row['lead_status_name'];
	$data[] = $sub_array;
}

function count_all_data($conn)
{
	$sess_id1= intval($_SESSION['proj_info_id']);
	/*$query = "SELECT * FROM leads WHERE project_info_id = ".$sess_id;
    $result=mysqli_query($conn, $query);
	$count= mysqli_num_rows($result);
	return $count;*/
    $role_type= intval($_SESSION['role_type']);
    $query2='';
    if($role_type==1)
    {
       $query2 = "SELECT * FROM leads WHERE lead_hidden_status=0";
    }
    else if($role_type==2)
    {
        $query2 = "SELECT * FROM leads WHERE lead_hidden_status=0 and project_info_id = ".$sess_id1;
    }
    else
    {
         $query2 = "SELECT * FROM leads WHERE lead_hidden_status=0 and project_info_id = ".$sess_id1;
    }
    /*	$query2 = "SELECT * FROM leads WHERE lead_hidden_status=0 and project_info_id = ".$sess_id1;*/
    	$statement2 = $conn->prepare($query2);
    	$statement2->execute();
       /*print_r($statement2->get_result());die;*/
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