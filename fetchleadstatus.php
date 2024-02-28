<?php

error_reporting(1);
ini_set('display_errors', 1);
//fetch.php
include("dbconfig.php");
session_start();

 

$sess_id= intval($_SESSION['proj_info_id']);

 

$role_type= intval($_SESSION['role_type']);

$project_team_id=0;
if($_POST['member_id']!=null || $_POST['member_id']!=""){
  $project_team_id= intval($_POST['member_id']);
  
}

else{
if($role_type==2||$role_type==1)
{
 $project_team_id=0;   
}
else{
$project_team_id= intval($_SESSION['proj_team_id']);
}

}
 
$query='';
//superadmin

if( $role_type==1){
    
    if($project_team_id==0){
$query="CALL GetLeadStatusCountAdmin($project_team_id)";
}
else
{
  $query="CALL GetLeadStatusCount($project_team_id,$sess_id)";  
}
    
    
}
else if($role_type==3  || $role_type==2 || $role_type==1){
/*$query = "SELECT * FROM leads WHERE lead_hidden_status=0";*/ 
$query="CALL GetLeadStatusCount($project_team_id,$sess_id)";
}


	$exeInsert = mysqli_query($conn,$query);
  // output data of each row
  while($row = $exeInsert->fetch_assoc()) {
	if(!empty($exeInsert)){
      	$status=1;
      
	 $rowleads= $row['RawLeads'];
     $hotleads= $row['HotLeads'];
     $warmleads= $row['WarmLeads'];
      $coldleads= $row['ColdLeads'];
      $nonreleventleads= $row['NonReleventLeads'];
  		}		
	
	else{
	    $status=0;
	     $rowleads= 0;
         $hotleads= 0;
        $warmleads= 0;
        $coldleads= 0;
        $nonreleventleads= 0;

	}
echo json_encode(array("Status"=>$status,"RawLeads"=>$rowleads,"WarmLeads"=>$warmleads,"HotLeads"=>$hotleads,"ColdLeads"=>$coldleads,"NonReleventLeads"=>$nonreleventleads));

      
  }



?>