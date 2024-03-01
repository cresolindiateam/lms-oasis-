<?php
include("dbconfig.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_POST['member_access_lead_id']))
{
  $lead_id=$_POST['member_access_lead_id'];
  $team_id =$_POST['project_team_member'];
  $leadname='';
  $leadmembername='';


 $sql1 = "SELECT leads.team_member_id,client_team_members.name as member_name,leads.name as lead_name from leads 
           left join client_team_members on leads.team_member_id=client_team_members.id
            where leads.id=".$lead_id;
            
   $projectresult1 = mysqli_query($conn,$sql1);
   if ($projectresult1->num_rows > 0) 
   {
      while($row1 = $projectresult1->fetch_assoc())
      {
          $leadname=$row1['lead_name'];
          $leadmembername=$row1['member_name'];
      }
   }



if($team_id!=''){

 $sql = "SELECT firebase_token from client_team_members where id=".$team_id;
   $projectresult = mysqli_query($conn,$sql);
   if ($projectresult->num_rows > 0) 
   {
  while($row = $projectresult->fetch_assoc())
     {

$jsonData = array(
    'to' => $row['firebase_token'],
    'notification' => array(
        'body' => 'New Lead '.$leadname.'has been assigned By '.$leadmembername,
        'title' => 'New Lead Assigned',
        'subtitle' => 'Lead Assigned'
    ),
    'data' => array(
        'type' => 'hello'
    )
);
$apiKey = 'AAAALswy7j0:APA91bH98yMSaFwe_zvntyxkEDh17ssBG47VjAF2xqJhfAPmzu0MRAIundWrIzvc6MLQjmT76IWoIfwgVp_2_1ncpgrcM6ZsFtuE7Z5mrV0wGaou__W6Q_ExS8-n4eQrXhGI2Fj4ap9K';

$ch = curl_init('https://fcm.googleapis.com/fcm/send');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($jsonData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: key=' . $apiKey
));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Curl error: ' . curl_error($ch);
}

curl_close($ch);

// echo $response;

}

}


}





  $query = "update  leads set team_member_access_id=".$team_id." where id=".$lead_id;
  $status='';
  $message='';
  if (mysqli_query($conn, $query)) 
  {
   $status=1;
   $message='lead assigned to member';
  }
   else 
  {
    $status=0;
    $message='lead not assigned to member';
  }
 
  $data1= array("Status"=>$status,"Message"=>$message);
  echo json_encode($data1);
}
?>