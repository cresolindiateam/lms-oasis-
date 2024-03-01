<?php
session_start();
require 'dbconfig.php';
require 'insertleadsexcel.php'; 
if (isset($_POST['importsubmit'])) 
{
  importExcelData($_FILES['file'],$conn);
}
 if(!isset($_SESSION['proj_team_id']))
   {
     header("location: index.php");
   }
   /*$sql = "SELECT id, project_name,project_image_url from project_information where id=".$_SESSION['proj_info_id']." order by id desc";
   */
   $sql = "SELECT id, project_name,project_image_url from project_information where team_member_id=".$_SESSION['proj_team_id']." order by id desc";
   $projectresult = mysqli_query($conn,$sql);
   if ($projectresult->num_rows > 0) 
   {
     while($row = $projectresult->fetch_assoc())
     {
       $_SESSION['image_url']= $row["project_image_url"];
       $_SESSION['project_name']= $row["project_name"];
     }
   }
   $sql777;
   if($_SESSION['role_type']==1)
   {
    $sql777 = "SELECT id, name from client_team_members where 1  and (role_type=4) and (team_hidden_status=0  or team_hidden_status=1) order by id desc";
   }
   else
   {
    $sql777 = "SELECT id, name from client_team_members where 1 and client_id=".$_SESSION['proj_info_id']." and role_type=4 and (team_hidden_status=0  or team_hidden_status=1) order by id desc";
   }



   $projectteamresult = mysqli_query($conn,$sql777);


    if($_SESSION['role_type']==2||$_SESSION['role_type']==3||$_SESSION['role_type']==4)
   {
   $sql1 = "SELECT id, lead_status_name from lead_status_info where 1 and client_id=".$_SESSION['proj_info_id']."   order by id desc";


   $projectstatusresult = mysqli_query($conn,$sql1);

    $sql111 = "SELECT id, lead_status_name from lead_status_info where 1 and client_id=".$_SESSION['proj_info_id']."   order by id desc";


   $projectstatusresult1 = mysqli_query($conn,$sql111);
}
else
{
$sql1 = "SELECT id, lead_status_name from lead_status_info where 1 order by id desc";


   $projectstatusresult = mysqli_query($conn,$sql1);

    $sql111 = "SELECT id, lead_status_name from lead_status_info where 1 order by id desc";


   $projectstatusresult1 = mysqli_query($conn,$sql111);

}


   $sql12='';
   if($_SESSION['role_type']==1)
   {
    $sql12 = "select count(id) as countpendingfollowlead,concat(`next_last_followup_date`, ' ', `next_last_followup_time`) as pendingleadfollowdata from leads where concat(`next_last_followup_date`, ' ', `next_last_followup_time`)<= now() and `lead_hidden_status` = 0  and `next_last_followup_date` !='' ORDER BY `id` DESC";
   }
   else
   {
    $sql12 = "select count(id) as countpendingfollowlead,concat(`next_last_followup_date`, ' ', `next_last_followup_time`) as pendingleadfollowdata from leads where concat(`next_last_followup_date`, ' ', `next_last_followup_time`)<= now() and `project_info_id`=".$_SESSION['proj_info_id']." and `lead_hidden_status` = 0 and `next_last_followup_date` !='' ORDER BY `id` DESC";
   }
   $pendingleadfollowupresult = mysqli_query($conn,$sql12);
   $sql122='';
   if($_SESSION['role_type']==2||$_SESSION['role_type']==3||$_SESSION['role_type']==4)
   {
    $sql122 = "select expiry_date from client_team_members where 1 and id=".$_SESSION['proj_team_id']." ORDER BY `id` DESC";
   }
   $expirtyteamresult = mysqli_query($conn,$sql122);
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Lead Management</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
      <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
      <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
      <link rel="stylesheet" href="dist/css/jquery.timepicker.min.css">
   </head>
   <?php include('header.php');?>
   <style>
.modal{display:none;}
      .ui-timepicker-standard
      {
      z-index:1000000!important;
      }
      body{
      padding: 0px !important;
      }
      .dropdown-check-list {
      display: inline-block;
      }
      .pendingfollow
      {
      background:#ff9292!important;
      }
      .dropdown-check-list .anchor {
      position: relative;
      cursor: pointer;
      display: inline-block;
      padding: 6px 40px 6px 10px;
      border: 1px solid #ccc;
      /* margin-top: 10px;*/
      background: #fff;
      border-radius: 5px;
      color: #495057;
      width:135px;
      }
      .dropdown-check-list .anchor:after {
      position: absolute;
      content: "";
      border-left: 2px solid #6b7076;
      border-top: 2px solid #6b7076;
      padding: 3px;
      right: 10px;
      top: 40%;
      -moz-transform: rotate(-135deg);
      -ms-transform: rotate(-135deg);
      -o-transform: rotate(-135deg);
      -webkit-transform: rotate(-135deg);
      transform: rotate(-135deg);
      }
      .dropdown-check-list .anchor:active:after {
      right: 8px;
      top: 21%;
      }
      .dropdown-check-list ul.items {
      padding: 2px;
      display: none;
      margin: 0;
      border: 1px solid #ccc;
      border-top: none;
      position:absolute;
      background:#ffffff;
      z-index:100;
      width:135px;
      }
      .dropdown-check-list ul.items li {
      list-style: none;
      }
      .dropdown-check-list1 {
      display: inline-block;
      }
      .dropdown-check-list1 .anchor {
      position: relative;
      cursor: pointer;
      display: inline-block;
      padding: 5px 40px 5px 10px;
      border: 1px solid #ccc;
      /* margin-top: 10px;*/
      background: #fff;
      border-radius: 5px;
      color: #495057;
      }
      .dropdown-check-list1 .anchor:after {
      position: absolute;
      content: "";
      border-left: 2px solid black;
      border-top: 2px solid black;
      padding: 5px;
      right: 10px;
      top: 20%;
      -moz-transform: rotate(-135deg);
      -ms-transform: rotate(-135deg);
      -o-transform: rotate(-135deg);
      -webkit-transform: rotate(-135deg);
      transform: rotate(-135deg);
      }
      .dropdown-check-list1 .anchor:active:after {
      right: 8px;
      top: 21%;
      }
      .dropdown-check-list1 ul.items {
      padding: 2px;
      display: none;
      margin: 0;
      border: 1px solid #ccc;
      border-top: none;
      position:absolute;
      background:#ffffff;
      z-index:100;
      width:140px;
      }
      .dropdown-check-list1 ul.items li {
      list-style: none;
      }
   </style>
   <body class="hold-transition skin-blue sidebar-mini" >
      <div class="wrapper">
      <?php include('left_side_bar.php');?>
      <div class="content-wrapper" style="height:auto;min-height:0px;">
      <!-- Main content -->
      <section class="content">
         <div class="card-header" style="margin-bottom:10px">
            <div class="row ">
               <div  class="mobile_page_header">
                  <h4><strong>Lead List</strong></h4>



                  <?php if($_SESSION['role_type']!=1){?>    
                  <div style="position: absolute;right: 40px;text-transform: capitalize;font-weight: 600;font-size: 18px;top:40px
                     ">    
                     expiry date:-
                     <?php 
                        $color="color:green"; 
                        $expiry_str='';
                        if ($expirtyteamresult->num_rows > 0) {
                        // output data of each row
                        while($row90122 = $expirtyteamresult->fetch_assoc()) {
                        $expiry_str=$row90122['expiry_date'];
                        $datediff=0;
                        $days;
                        $your_date=0;
                        $now = time(); 
                        $your_date = strtotime($row90122['expiry_date']);
                        $datediff =  $your_date - $now;
                        $days= round($datediff / (60 * 60 * 24));
                        if($days<=7)
                        {
                        $color="color:red";   
                        }
                        ?>
                     <span style="<?php  echo $color;?>"><?php 
                        if($expiry_str==='0000-00-00'){
                             echo '';
                        }
                        else
                        {
                            echo date('Y-m-d',strtotime($row90122['expiry_date']));
                        }
                        ?></span>      
                     <?php }}?>
                  </div>
                  <?php } ?>
               </div>
            </div>

<?php if($_SESSION['role_type']==3 || $_SESSION['role_type']==2){?>
               <div class="row p-3">
    <!-- Import link -->
    <div class="col-md-12 head">
        <div class="float-end">
            <a href="javascript:void(0);" class="btn btn-success" onclick="formToggle('importFrm');"><i class="fa fa-plus"></i> Import Excel</a>
        </div>
    </div>
    <!-- Excel file upload form -->
    <div class="col-md-12" id="importFrm" style="display: none;">
        <form class="row g-3"  method="post" enctype="multipart/form-data" style="margin-top:10px">
            <div class="col-auto">
               <!--  <label for="fileInput" class="visually-hidden">File</label> -->
                <input type="file" class="form-control" name="file" id="fileInput" />
            </div>
            <div class="col-auto">
                <input type="submit" class="btn btn-primary mb-3" name="importsubmit" value="Import">
            </div>
        </form>
    </div>
     </div>

<?php }?>

            <?php if($_SESSION['role_type']==1||$_SESSION['role_type']==3 || $_SESSION['role_type']==2){?>
            <div class="row subheading_info">
               <div style="margin-left:8px;">
                  <strong>Total:</strong><span style="margin-top: 5px;" id="total_leads_value"></span> 
                  <br>
               </div>
               <div style="margin-left:8px;">
                  <strong>Total Follow-up:</strong><span id="pending_follow_count_number" style="margin-top: 5px;" >
                  <?php if ($pendingleadfollowupresult->num_rows > 0) {
                     // output data of each row
                     while($row9012 = $pendingleadfollowupresult->fetch_assoc()) {
                     ?>
                  <span  value=<?php echo  $row9012['id'];?> ><?php echo  $row9012['countpendingfollowlead'];?></span>
                  <?php }}?>
                  </span> 
                  <br>
               </div>
            </div>


            <div class="row">
               <div class="col-md-5" style="padding:0px;margin-top:8px;">
                  <div class="list_view" >
                     <div style="margin-left:8px;">
                        <strong>Raw:</strong><span style="margin-top: 5px;" id="raw_leads_value"></span> 
                        <br>
                     </div>
                     <div style="margin-left:8px;">
                        <strong>Warm:</strong><span style="margin-top: 5px;" id="warm_leads_value"></span>
                        <br>
                     </div>
                     <div style="margin-left:8px;">
                        <strong>Cold:</strong><span style="margin-top: 5px;" id="cold_leads_value"></span> 
                        <br>
                     </div>
                     <div style="margin-left:8px;">
                        <strong>Hot:</strong><span style="margin-top: 5px;" id="hot_leads_value"></span> 
                        <br>
                     </div>
                     <div style="margin-left:8px;">
                        <strong>Non-Relevent:</strong><span style="margin-top: 5px;" id="non_relevent_leads_value"></span> 
                        <br>
                     </div>
                  </div>
                 </div>

               <div class="col-md-5 filter_section" >
                   <div class="mobile_lead_member_select_div">
                     <?php if($_SESSION['role_type']==1||$_SESSION['role_type']==2){ 
                        ?>
                     <input type="hidden" value="" id="leadmemberid2">
                     <select id="leadmemberid" class="form-control" >
                        <option  value=0 >Selelct all</option>
                        <?php if ($projectteamresult->num_rows > 0) {
                           // output data of each row
                           while($row = $projectteamresult->fetch_assoc()) {?>
                        <option  value=<?php echo  $row['id'];?> ><?php echo  $row['name'];?></option>
                        <?php }}?>
                     </select>
                     <?php }?>
                   </div> 
                  <div id="list1" class="dropdown-check-list" tabindex="100">
                     <span class="anchor">Column</span>
                     <ul id="items" class="items">
                        <li><input type="checkbox" name="list"  data-target ="3" value="Phone Number" checked  />  
                           <label for="list">Phone</label>
                        </li>
                        <li><input type="checkbox" name="list"  data-target ="8" value="Ip Address" checked /> 
                         <label for="list">Ip Address</label>
                        </li>
                        <li><input type="checkbox" name="list" data-target ="9" value="Plateform Type" checked />  
                         <label for="list">Plateform Type</label>
                        </li>
                        <li><input type="checkbox" name="list" data-target ="10" value="Project Info Id" checked /> <label for="list">Project Info Id</label> </li>
                     </ul>
                  </div>
                  <div class="mobile_lead_status_select_div">
                     <input type="hidden" id="lead_status_check_id" value="">
                     <select id="items2" class="form-control" >
                        <option  value='' >Selelct all</option>
                        <?php if ($projectstatusresult->num_rows > 0) {
                           // output data of each row
                           while($row = $projectstatusresult->fetch_assoc()) {?>
                        <option  value=<?php echo  $row['id'];?> ><?php echo  $row['lead_status_name'];?></option>
                        <?php }}?>
                     </select>
                  </div>
               </div>



               <div class="col-md-2">
                  <button type="button" class="mobile_add_visit btn theme-btn pull-right " data-toggle="modal" data-target="#add_tag_list_modal" >New Lead <i class="fa fa-plus-circle"></i>
                  </button>

                   
            







                <!--           <form method="POST" action="insertleadsexcel.php" enctype="multipart/form-data">
                <div class="form-group">
                        <label>Upload Excel File</label>
                        <input type="file" name="file" class="form-control">
                </div>
                <div class="form-group">
                        <button type="submit" name="Submit" class="btn btn-success">Upload</button>
                </div>
                <p>Download Demo File from here : <a href="demo.ods"><strong>Demo.ods</strong></a></p>
               </form> -->
                
               </div>
                <?php }?>

                  <div class="add_tag_list_modal">
                     <div class="modal fade" id="lead_edit_modal" role="dialog">
                        <div class="modal-dialog">
                           <!-- Modal content-->
                           <div class="modal-content" >
                              <div class="modal-header">
                                 <h4 class="modal-title">Edit Lead Details</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body" >
                                 <div class="user-info-area" id="lead_edit_form_modal_body">
                                    <form enctype="multipart/form-data" method="post" class="form-inline" id="lead_edit_form">
                                       <div  style="margin-bottom:10px;margin: 0 auto;">
                                          <input type="hidden" value="" name="lead_edit_lead_id" id="lead_edit_lead_id">      
                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong>Name:-</strong></label>
                                             <input type="name" name="name" class="form-control" id="edit_name"/>
                                          </div>
                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong>Email:-</strong></label>
                                             <input type="email" name="email" class="form-control" id="edit_email"/>
                                          </div>
                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong>Phone:-</strong></label>
                                             <input type="text" name="phone" class="form-control" id="edit_phone"/>
                                          </div>
                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong> Location:-</strong></label>
                                             <input type="text" name="interested_location" class="form-control" id="interested_location_edit"/>
                                          </div>

                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong> Interested For:-</strong></label>
                                             <input type="text" name="interested_for" class="form-control" id="interested_for_edit"/>
                                          </div>

                                            <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong> Budget:-</strong></label>
                                             <input type="text" name="budget" class="form-control" id="budget_edit"/>
                                          </div>



                                          <?php
                                             if($_SESSION['role_type']==1||$_SESSION['role_type']==2){?>
                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong>Project Type:-</strong></label>
                                             <select name="project_type" class="form-control" id="project_type_edit">
                                                <?php 
                                                   $sql='';
                                                   if($_SESSION['role_type']==1){
                                                   $sql = "SELECT id, project_name,project_image_url from project_information where 1 order by id desc";
                                                   }
                                                   else if($_SESSION['role_type']==2){
                                                   $sql = "SELECT id, project_name,project_image_url from project_information where 1 and client_id=".$_SESSION['proj_info_id']." order by id desc";
                                                   }
                                                   
                                                   $result = mysqli_query($conn,$sql);
                                                   if ($result->num_rows > 0) {
                                                   // output data of each row
                                                   while($row = $result->fetch_assoc()) {?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['project_name'];?></option>
                                                <?php }}?>
                                             </select>
                                          </div>
                                          <?php }
                                             else{?>
                                          <div class="form-group" style="margin-bottom:10px;display:none;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong>Project Type:-</strong></label>
                                             <select name="project_type" class="form-control" id="project_type_edit">
                                                <?php 
                                                   $sql = "SELECT id, project_name,project_image_url from project_information where 1 order by id desc";
                                                   
                                                   $result = mysqli_query($conn,$sql);
                                                   if ($result->num_rows > 0) {
                                                   // output data of each row
                                                   while($row = $result->fetch_assoc()) {?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['project_name'];?></option>
                                                <?php }}?>
                                             </select>
                                             <?php } ?>
                                             <div class="form-group" style="margin-bottom:10px">
                                                <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong>Created At:-</strong></label>
                                                <!-- <input type="text" name="phone_number" class="form-control" id="phone_number"/> -->
                                                <input type="text" class="form-control" name="created_at_date" id = "datepicker-13_edit">
                                             </div>
                                             <div class="form-group" style="margin-bottom:10px;">
                                                <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong>Lead Source:-</strong></label>
                                                <!--<input type="text" name="form_type" class="form-control" id="form_type"/>-->
                                                <select name="form_type" class="form-control" id="form_type_edit">
                                                   <option value="PPC">PPC</option>
                                                   <option value="FACEBOOK">Facebook</option>
                                                   <option value="INSTAGRAM">Instagram</option>
                                                   <option value="DIRECTCALL">DirectCall</option>
                                                   <option value="WHATSAPPCHAT">Whatsappchat</option>
                                                   <option value="IVR">IVR</option>
                                                </select>
                                             </div>
                                             
                                              <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:175px;"><strong>Reference by:-</strong></label>
                                             <input type="text" name="reference_by" class="form-control" id="reference_by_edit"/>
                                          </div>



                                         
                                    </form>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                                 <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewLeadEdit();" style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">Update</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="add_tag_list_modal">
                     <div class="modal fade" id="lead_status_modal" role="dialog">
                        <div class="modal-dialog ">
                           <!-- Modal content-->
                           <div class="modal-content mobile_lead_status_details_modal" >
                              <div class="modal-header">
                                 <h4 class="modal-title">Lead Status Details</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body" >
                                 <div class="user-info-area" id="lead_follow_form_modal_body">
                                    <form enctype="multipart/form-data" method="post" class="form-inline" id="lead_status_form">
                                       <div class="form-group" style="margin-bottom:10px">
                                          <input type="hidden" value="" name="lead_status_lead_id" id="lead_status_lead_id">      
                                          <label class="personal-info-label lead_follow_up_message_label" ><strong>Lead Follow Up Message:-</strong></label>
                                          <textarea class="form-control" required name="folowupmessage" id="folowupmessage"></textarea>
                                          <label class="personal-info-label lead_status__drop_label"><strong>Lead Status:-</strong></label>
                                         <!--  <select id="lead_status" name="lead_status" class="form-control">
                                             <option value="">All Lead</option>
                                             <option value="0">Raw Lead</option>
                                             <option value="1">Cold Lead</option>
                                             <option value="2">Warm Lead</option>
                                             <option value="3">Hot Lead</option>
                                             <option value="4">Non-Relevent Lead</option>
                                          </select> -->


                                       <select id="lead_status" name="lead_status" class="form-control" >
                        <option  value='' >Selelct all</option>
                        <?php if ($projectstatusresult->num_rows > 0) {
                           // output data of each row
                           while($row = $projectstatusresult1->fetch_assoc()) {?>
                        <option  value=<?php echo  $row['id'];?> ><?php echo  $row['lead_status_name'];?></option>
                        <?php }}?>
                     </select>

                                          <hr/>
                                       </div>
                                       <div class="form-group" style="margin-bottom:10px">
                                          <label class="personal-info-label lead_follow_up_message_label" ><strong>Next Follow Up Date:-</strong></label>
                                          <input class="form-control"  type="text" name="next_follow_up_date" id = "datepicker-14">
                                          <label class="personal-info-label lead_follow_up_message_label close_status_follow" ><strong>Follow Up closing status:-</strong></label>
                                          <input type="hidden" name="follow_up_closing_status" value="0">
                                          <input  type="checkbox" name="follow_up_closing_status" value="1">
                                       </div>
                                       <div class="form-group" style="margin-bottom:10px">
                                          <label class="personal-info-label lead_follow_up_message_label" ><strong>Next Follow Up Time:-</strong></label>
                                          <input class="form-control" type="text" name="next_follow_up_time" id = "timepicker-14">
                                       </div>
                                 </div>
                              </div>
                              </form>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                                 <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewLeadStatus();" style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">Update</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="add_tag_list_modal">
                     <div class="modal fade" id="lead_relevent_status_modal" role="dialog">
                        <div class="modal-dialog">
                           <!-- Modal content-->
                           <div class="modal-content" style="width:680px">
                              <div class="modal-header">
                                 <h4 class="modal-title">Lead Relevent Status Details</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body" >
                                 <div class="user-info-area" id="lead_follow_form_modal_body">
                                    <form enctype="multipart/form-data" method="post" class="form-inline" id="lead_rel_status_form">
                                       <div class="form-group" style="margin-bottom:10px">
                                          <input type="hidden" value="" name="lead_rel_status_lead_id" id="lead_rel_status_lead_id">      
                                          <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Lead Status:-</strong></label>
                                          <select id="lead_rel_status" name="lead_rel_status" class="form-control">
                                             <option value="2">Please Select Lead Relevent Status</option>
                                             <option value="0">Non Relevent</option>
                                             <option value="1">Relevent</option>
                                          </select>
                                          <hr/>
                                    </form>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                                 <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewLeadRelStatus();" style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">Create</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="add_tag_list_modal">
                     <div class="modal fade" id="lead_follow_modal" role="dialog">
                        <div class="modal-dialog mobile_lead_follow_details_modal" >
                           <!-- Modal content-->
                           <div class="modal-content"  >
                              <div class="modal-header">
                                 <h4 class="modal-title">Lead FollowUp Details</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body" >
                                 <div class="user-info-area" id="lead_follow_form_modal_body">
                                    <form enctype="multipart/form-data" method="post" class="form-inline" id="lead_follow_form" style="margin:0px">
                                       <div class="form-group">
                                          <input type="hidden" value="" name="lead_followup_lead_id" id="lead_followup_lead_id">      
                                          <!-- <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Lead Followup Message:-</strong></label>
                                             -->    <!--<textarea  required name="folowupmessage" id="folowupmessage"></textarea>-->
                                          <!--  <hr/>-->
                                    </form>
                                    </div>
                                 </div>


                                 <div id="view_lead_follow_history" >
                                    <div class="user-info-area">
                                       <div style="overflow-x:auto;">
                                          <table id="example2" class="table table-bordered table-striped " style="overflow:unset;border:unset;width:unset!important">
                                             <thead>
                                                <tr>
                                                   <th>Id</th>
                                                   <th>Lead Id</th>
                                                   <th>Team Id</th>
                                                   <th>Created By</th>
                                                   <th>Message</th>
                                                   <th>Created At</th>
                                                   <th>Next Followup Date</th>
                                                   <th>Next Followup time</th>
                                                   <th>Action</th>
                                                </tr>
                                             </thead>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="add_tag_list_modal">
                     <div class="modal fade" id="add_lead_member_access_modal" role="dialog">
                        <div class="modal-dialog">
                           <!-- Modal content-->
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h4 class="modal-title">Lead Member Access</h4>
                                 <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                              <div class="modal-body">
                                 <div class="user-info-area">
                                    <form enctype="multipart/form-data" method="post" class="form-inline" id="leadmemberaccessform">
                                       <div class="form-group" style="margin-bottom:10px">
                                          <input type="hidden" value="" name="member_access_lead_id" id="member_access_lead_id">      
                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Team Member:-</strong></label>
                                             <?php 

                                             // echo $_SESSION['proj_info_id'];
                                                $member_access_id='';
                                                $sql111='';

                                                //client_team_members.role_type=3
                                                      $sql111 = "SELECT leads.team_member_access_id from client_team_members 
                                                                      left join leads on leads.team_member_id=client_team_members.id
                                                                      where  client_team_members.client_id=".$_SESSION['proj_info_id']." order by client_team_members.id desc";

                                               
                                                $result12 = mysqli_query($conn,$sql111);
                                                if ($result12->num_rows > 0) 
                                                {
                                                    while($rowaccess = $result12->fetch_assoc()) {
                                                        $member_access_id=$rowaccess['team_member_access_id'];
                                                    }
                                                }
                                                ?>
                                             <select name="project_team_member" class="form-control" id="project_team_member">
                                                <option value="0">not assign</option>
                                                <?php 
                                                   $sql1212='';
                                                   if($_SESSION['role_type']==1){
                                                   $sql1212 = "SELECT id,name from client_team_members where role_type=4  order by id desc";
                                                   }
                                                    else if($_SESSION['role_type']==2){
                                                   $sql1212 = "SELECT id,name from client_team_members where role_type=4 and client_id=".$_SESSION['proj_info_id']." order by id desc";
                                                   }
                                                   else if($_SESSION['role_type']==3)
                                                   {
                                                   $sql1212 = "SELECT client_team_sub_members.team_member_id from client_team_members left join client_team_sub_members on client_team_sub_members.team_leader_id=client_team_members.id where client_team_members.role_type=3 and client_team_members.client_id=".$_SESSION['proj_info_id']."

                                                     
                                                    order by client_team_members.id desc";


                                                   }   
                                                   
                                                   $result = mysqli_query($conn,$sql1212);
                                                   if ($result->num_rows > 0) {
                                                   // output data of each row
                                                   while($row = $result->fetch_assoc()) {?>
                                                <option 
                                                   <?php  if(intval($member_access_id)==intval($row['id'])){echo 'selected';}?>
                                                   value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                                <?php }}?>
                                             </select>
                                          </div>
                                          <hr/>
                                    </form>
                                    </div>
                                 </div>
                                 <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                                    <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewLeadMemeberAccess();" style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">Create</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="add_tag_list_modal">
                        <div class="modal fade add_t_l_modal" id="add_tag_list_modal" role="dialog" > 
                           <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h4 class="modal-title"> New Leads</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                 </div>
                                 <div class="modal-body">
                                    <div class="user-info-area">
                                       <form enctype="multipart/form-data" method="post" class="form-inline" id="leadform">
                                          <div class="form-group" style="margin-bottom:10px">
                                             <input type="hidden" name="teammemberid" value="<?php echo $_SESSION['proj_team_id']; ?>">
                                             <input type="hidden" name="userrole" class="form-control" value="<?php echo  $_SESSION['role_type']; ?>"/> 
                                             <input type="hidden" name="ipAddress" class="form-control" id="ipAddress"/>   
                                             <input type="hidden" name="platformType" class="form-control" id="platformType"/>          
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Name:-</strong></label>
                                             <input type="text" name="name" class="form-control" id="tag_name"/>
                                          </div>
                                          <div class="form-group" style="margin-bottom:10px">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Email:-</strong></label>
                                             <input type="text" name="email" class="form-control" id="email"/>
                                          </div>
                                          <div class="form-group" style="margin-bottom:10px">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Phone Number:-</strong></label>
                                             <input type="text" name="phone_number" class="form-control" id="phone_number"/>
                                          </div>


                                          <div class="form-group" style="margin-bottom:10px">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Location:-</strong></label>
                                             <input type="text" name="location" class="form-control" id="location"/>
                                          </div>

                                          <div class="form-group" style="margin-bottom:10px">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Interested For:-</strong></label>
                                             <input type="text" name="interested_for" class="form-control" id="interested_for"/>
                                          </div>


                                          <div class="form-group" style="margin-bottom:10px">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Budget:-</strong></label>
                                             <input type="text" name="budget" class="form-control" id="budget"/>
                                          </div>

                                            <?php
                                             if($_SESSION['role_type']==1){?>
                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Client Type:-</strong></label>
                                             <select  name="client_type" class="form-control" id="client_type">
                                                <?php 
                                                   $sql='';
                                                   if($_SESSION['role_type']==1){
                                                   $sql = "SELECT id, name from clients where 1 order by id desc";
                                                   }
                                                  
                                                   
                                                   $result = mysqli_query($conn,$sql);
                                                   if ($result->num_rows > 0) {
                                                   // output data of each row
                                                   while($row = $result->fetch_assoc()) {?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                                                <?php }}?>
                                             </select>
                                          </div>
                                          <?php }
                                           
                                           elseif($_SESSION['role_type']==2 || $_SESSION['role_type']==3 || $_SESSION['role_type']==4){?>

<input type="hidden" name="client_type" value="<?php  echo $_SESSION['proj_info_id'];?>">

                                          <?php  }?>

                                          <?php
                                             if($_SESSION['role_type']==1||$_SESSION['role_type']==2){?>
                                          <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Project Type:-</strong></label>
                                             <select name="project_type" class="form-control" id="project_type">
                                                <?php 
                                                   $sql='';
                                                   if($_SESSION['role_type']==1){
                                                   $sql = "SELECT id, project_name,project_image_url from project_information where 1 order by id desc";
                                                   }
                                                   else if($_SESSION['role_type']==2){
                                                   $sql = "SELECT id, project_name,project_image_url from project_information where 1 and client_id=".$_SESSION['proj_info_id']." order by id desc";
                                                   }
                                                   
                                                   $result = mysqli_query($conn,$sql);
                                                   if ($result->num_rows > 0) {
                                                   // output data of each row
                                                   while($row = $result->fetch_assoc()) {?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['project_name'];?></option>
                                                <?php }}?>
                                             </select>
                                          </div>
                                          <?php }
                                             else{?>
                                          <div class="form-group" style="margin-bottom:10px;display:none;">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Project Type:-</strong></label>
                                             <select name="project_type" class="form-control" id="project_type">
                                                <?php 
                                                   $sql = "SELECT id, project_name,project_image_url from project_information where 1 order by id desc";
                                                   
                                                   $result = mysqli_query($conn,$sql);
                                                   if ($result->num_rows > 0) {
                                                   // output data of each row
                                                   while($row = $result->fetch_assoc()) {?>
                                                <option value="<?php echo $row['id'];?>"><?php echo $row['project_name'];?></option>
                                                <?php }}?>
                                             </select>
                                             <?php } ?>
                                             <div class="form-group" style="margin-bottom:10px">
                                                <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Created At:-</strong></label>
                                                <!-- <input type="text" name="phone_number" class="form-control" id="phone_number"/> -->
                                                <input type="text" class="form-control" name="created_at_date" id = "datepicker-13">
                                             </div>
                                             <div class="form-group" style="margin-bottom:10px;">
                                                <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Lead Source:-</strong></label>
                                                <!--<input type="text" name="form_type" class="form-control" id="form_type"/>-->
                                                <select name="form_type" class="form-control" id="form_type">
                                                   <option value="PPC">PPC</option>
                                                   <option value="FACEBOOK">Facebook</option>
                                                   <option value="INSTAGRAM">Instagram</option>
                                                   <option value="DIRECTCALL">DirectCall</option>
                                                   <option value="WHATSAPPCHAT">Whatsappchat</option>
                                                   <option value="IVR">IVR</option>
                                                </select>
                                             </div>
                                             
                                              <div class="form-group" style="margin-bottom:10px;">
                                             <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Reference by:-</strong></label>
                                             <input type="text" name="reference_by" class="form-control" id="reference_by"/>
                                          </div>


                                             <hr/>
                                       </form>
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
                                       <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewLead();" style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">Create</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="input-group" style="display:none;">
                           <div class="input-group-prepend">
                              <span class="input-group-text">Page</span>
                           </div>
                           <select name="pagelist" id="pagelist" class="form-control"></select>
                           <div class="input-group-append">
                              <span class="input-group-text">of&nbsp;<span id="totalpages"></span></span>
                           </div>
                        </div>
                     </div>
                  </div>
               <!-- /.box-header -->
                  <table border="0" cellspacing="5" cellpadding="5" style="width:100%">
                     <tbody>
                        <tr>
                           <td style="position: relative;">
                              <i class="lead_calendar_filter_icon fa fa-calendar" id="min" name="min">
                           </td>
                        </tr>
                     </tbody>
                  </table>
               <div>
               
                  <table id="example1" class="table table-bordered table-striped" style="overflow:unset;margin-bottom:20px;">
                     <thead>
                        <tr>
                           <th>Id</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Phone Number </th>
                           <th>Lead Source</th>
                           <th>Status</th>
                           <th>Next Followup</th>
                           <th>Followup message</th>
                           <th>Ip Address</th>
                           <th>Platform Type</th>
                           <th>Project Info id</th>
                           <th>Created At</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                   </table>
               </div>
               <!-- /.box-body -->
      </section>
      </section>
      </div>
      <div class="control-sidebar-bg"></div>
      </div>
      <script  src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
      <!-- CSS only -->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
      <link
         href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css"
         rel="stylesheet"
         />
      <script
         src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
         integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
         crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
      <script src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script>
      <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
      <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.2.0/css/dataTables.dateTime.min.css
         " />
      <script src="dist/js/demo.js"></script>
    
  <script>
function formToggle(ID){
    var element = document.getElementById(ID);
    if(element.style.display === "none"){
        element.style.display = "block";
    }else{
        element.style.display = "none";
    }
}
</script>
      <script type="text/javascript" language="javascript">
         var ipAddress="";
         function getIP(json) {
             ipAddress=json.ip;
             console.log("PlatformType "+platformType+"IP Address "+ipAddress);
           }
         $(document).ready(function(){
         var leadmemberid222;
         var platformType="none";
         var isMobile = {
             Android: function() {
               return navigator.userAgent.match(/Android/i);
             },
             BlackBerry: function() {
               return navigator.userAgent.match(/BlackBerry/i);
             },
             iOS: function() {
               return navigator.userAgent.match(/iPhone|iPad|iPod/i);
             },
             Opera: function() {
               return navigator.userAgent.match(/Opera Mini/i);
             },
             Windows: function() {
               return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
             },
             any: function() {
               return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() ||                                         isMobile.Windows());
             }
              };
         if( isMobile.any() )
         {
           platformType="mobile";
         }
         else{
           platformType="Desktop";
         }
         $("#ipAddress").val(ipAddress);
         $("#platformType").val(platformType);
         function load_data(start, length)
         {
           var minDate;
          minDate = new DateTime($('#min'), {
                 format: 'YYYY-MM-DD'
             });
         var dataTable = $('#example1').DataTable({
           "processing" : true,
           "serverSide" : true,
            "bPaginate": true,
             "bFilter": true,
             "bInfo": true,
           "order" : [],
           "retrieve": true,
           "ajax" : {
             url:"fetch.php",
             method:"POST",
             data:{start:start, length:length, leadmemberid:$("#leadmemberid2").val() ,status:2, leadcheckid:$("#lead_status_check_id").val()}
           },
           "columnDefs": [
         { "visible": false, "targets": [3,8,9,10] }
         ],
           "drawCallback" : function(settings){
             var page_info = dataTable.page.info();
               console.log(page_info);
           $('#totalpages').text(page_info.pages);
             var html = '';
             var start = 0;
             var length = page_info.length;
             for(var count = 1; count <= page_info.pages; count++)
             {
               var page_number = count - 1;
               html += '<option value="'+page_number+'" data-start="'+start+'" data-length="'+length+'">'+count+'</option>';
               start = start + page_info.length;
             }
             $('#pagelist').html(html);
             $('#pagelist').val(page_info.page);
           }
         });
            $('#min, #max').on('change', function () {
                   var date_value=$(this).val();
                  /* $('input[type="search"]').val(date_value);*/ 
                   dataTable.search(date_value).draw();
                     var interval = setInterval(function() {
                 if ( $(".pending").length) {
                  $(".pending").parent().parent().addClass('pendingfollow');
                     clearInterval(interval);
                 }
                  $("#pending_follow_count_number").text($(".pending").length);
             }, 1000);
               $("#example1_wrapper").parent().css('overflow','unset');
                      $("#example1").parent().css('overflow-x','scroll');
                       $("#example2_wrapper").parent().css('overflow','unset');
                      $("#example2").parent().css('overflow-x','scroll');
         });
         $('ul.items>li>input[type="checkbox"]').on('change', function(e) {
         var col = dataTable.column($(this).attr('data-target'));
         col.visible(!col.visible());
         });
         dataTable.ajax.reload();
         }    
         $('#pagelist').change(function(){
         var start = $('#pagelist').find(':selected').data('start');
         var length = $('#pagelist').find(':selected').data('length');
         load_data(start, length);
         var page_number = parseInt($('#pagelist').val());
         var test_table = $('#example1').dataTable();
         test_table.fnPageChange(page_number);
         });
         
         $("#leadmemberid").on("change", function() 
         {
         var leadmemberid = $("#leadmemberid").val();
          $("#leadmemberid2").val(leadmemberid);  
         leadstatusdetails(leadmemberid); 
         if ($.fn.DataTable.isDataTable("#example1")) {
         $('#example1').DataTable().clear().destroy();
         }
         
         load_data(); 
         
         var interval = setInterval(function() {
                 if ( $(".pending").length) {
                  $(".pending").parent().parent().addClass('pendingfollow');
                     clearInterval(interval);
                 }
                 $("#pending_follow_count_number").text($(".pending").length);
             }, 1000);
               $("#example1_wrapper").parent().css('overflow','unset');
                      $("#example1").parent().css('overflow-x','scroll');
                       $("#example2_wrapper").parent().css('overflow','unset');
                      $("#example2").parent().css('overflow-x','scroll');
         });
         
         
         $('#items2').on('change', function(e) {
         var col = $(this).val();
         $("#lead_status_check_id").val(col);
         if ($.fn.DataTable.isDataTable("#example1")) {
         $('#example1').DataTable().clear().destroy();
         }
         
         load_data();
         
         var interval = setInterval(function() {
                 if ( $(".pending").length) {
                  $(".pending").parent().parent().addClass('pendingfollow');
                     clearInterval(interval);
                 }
                   $("#pending_follow_count_number").text($(".pending").length);
             }, 1000);
               $("#example1_wrapper").parent().css('overflow','unset');
                      $("#example1").parent().css('overflow-x','scroll');
                       $("#example2_wrapper").parent().css('overflow','unset');
                      $("#example2").parent().css('overflow-x','scroll');
         });
         load_data();
         });
         $("#example1").parent().css('overflow-x','scroll');
         function teammemberaccess(leadid)
         {
         $("#member_access_lead_id").val(leadid);
         
         $.ajax({
         url:"AjaxLeadaccessuser.php", 
         data:{"lead_id":leadid},
         type:'post',
         async: true,
         dataType:'json',
         
         success:function(response){
         console.log(response);
         var status=response['Status'];
         $("#project_team_member").val(response.TeamMemeberAccessId);
         },
         error: function(xhr, status, error) {
         var err = eval("(" + xhr.responseText + ")");
         alert(err.Message);
         }
         });
         }
         
         function updateinfoedit(){
           var lead_edit_id= $("#lead_edit_lead_id").val();
         $.ajax({
         url:"AjaxLeadEditInfoData.php", 
         data:{"lead_edit_id":lead_edit_id},
         type:'post',
         async: true,
         dataType:'json',
         success:function(response){
         console.log(response);
         var status=response['Status'];
         $("#edit_name").val(response.name);
         $("#edit_email").val(response.email);
         $("#edit_phone").val(response.phone);
         $("#interested_location_edit").val(response.location);
         $("#interested_for_edit").val(response.interested_for);
         $("#budget_edit").val(response.budget);
         $("#project_type_edit").val(response.project_assigned);
         $("#form_type_edit").val(response.lead_source);
         $("#reference_by_edit").val(response.reference_by);
         $("#datepicker-13_edit").datepicker('setDate', response.created_at);
         },
         error: function(xhr, status, error) {
         var err = eval("(" + xhr.responseText + ")");
         alert(err.Message);
         }
         });
         }
         
         function leadstatusdetails(member_id)
         {
         $.ajax({
             url:"fetchleadstatus.php",
              data:{"member_id":member_id},
         type:'post',
         dataType:'json',
          success:function(response){
              console.log("data");
         console.log(response);
         var status=response['Status'];
         /*   alert(response['Message']);*/
         if(status==1){
         
         var rawleads=0;
         var hotleads=0;
         var coldleads=0;
         var warmleads=0;
         var nonreleventleads=0;
         var totalleads=0;
         if(rawleads!=null)
         {
           rawleads=response['RawLeads'];  
           totalleads=totalleads+parseInt(rawleads);
         }
         if(hotleads!=null)
         {
            hotleads=response['HotLeads']; 
            totalleads=totalleads+parseInt(hotleads);
         }
         if(coldleads!=null)
         {
            coldleads=response['ColdLeads'];  
            totalleads=totalleads+parseInt(coldleads);
         }
         if(warmleads!=null)
         {
            warmleads=response['WarmLeads'];  
            totalleads=totalleads+parseInt(warmleads);
         }
         
         if(nonreleventleads!=null)
         {
            nonreleventleads=response['NonReleventLeads'];  
            totalleads=totalleads+parseInt(nonreleventleads);
         }
           $("#raw_leads_value").text(rawleads);
            $("#hot_leads_value").text(hotleads);
             $("#cold_leads_value").text(coldleads);
              $("#warm_leads_value").text(warmleads);
              $("#non_relevent_leads_value").text(nonreleventleads);
               $("#total_leads_value").text(totalleads);
           
         }
         },
         })   
         } 
         leadstatusdetails(null);
         
         function load_data1(start, length)
         {
         var lead_id =$("#lead_followup_lead_id").val();
         var dataTable = $('#example2').DataTable({
             rowCallback: function(row, data, index) {
             $(row).find('td:eq(2)').css('width', '60px');
                $(row).find('td:eq(2)').css('max-width', '60px');
                $(row).find('td:eq(2)').css('overflow-x', 'scroll');
                   $(row).find('td:eq(1)').css('width', '60px');
                $(row).find('td:eq(1)').css('max-width', '60px');
                $(row).find('td:eq(1)').css('overflow-x', 'scroll');
                 $(row).find('td:eq(0)').css('width', '60px');
                $(row).find('td:eq(0)').css('max-width', '60px');
                  $(row).find('td:eq(3)').css('width', '60px');
                $(row).find('td:eq(3)').css('max-width', '60px');
                  $(row).find('td:eq(4)').css('width', '60px');
                $(row).find('td:eq(4)').css('max-width', '60px');
                   $(row).find('td:eq(5)').css('width', '60px');
                $(row).find('td:eq(5)').css('max-width', '60px');
                    $(row).find('td:eq(6)').css('width', '60px');
                $(row).find('td:eq(6)').css('max-width', '60px');
                    $(row).find('td:eq(7)').css('width', '60px');
                $(row).find('td:eq(7)').css('max-width', '60px');
                  $(row).find('td:eq(8)').css('width', '60px');
                $(row).find('td:eq(8)').css('max-width', '60px');
                
         },
         
           "processing" : true,
           "serverSide" : true,
            "bPaginate": false,
             "bFilter": true,
             "bInfo": false,
           "order" : [],
           "retrieve": true,
           "ajax" : {
             url:"fetchleadfollow.php",
             method:"POST",
             data:{start:start, length:length,lead_id:lead_id}
           },
           "columnDefs": [
         { "visible": false, "targets": [1,2] ,"className": 'dt-body-right' }
         ],
         
           "drawCallback" : function(settings){
             var page_info = dataTable.page.info();
             console.log(page_info);
             $('#totalpages').text(page_info.pages);
             var html = '';
             var start = 0;
             var length = page_info.length;
             for(var count = 1; count <= page_info.pages; count++)
             {
               var page_number = count - 1;
               html += '<option value="'+page_number+'" data-start="'+start+'" data-length="'+length+'">'+count+'</option>';
               start = start + page_info.length;
             }
         
             $('#pagelist').html(html);
             $('#pagelist').val(page_info.page);
           }
         });
         dataTable.ajax.reload();
         }
         function leadfollowup(leadid)
         {
         $("#lead_follow_modal").modal('show');
         $("#lead_followup_lead_id").val(leadid);
         if ($.fn.DataTable.isDataTable("#example2")) {
         $('#example2').DataTable().clear().destroy();
         } 
         load_data1();
         }
         
         function leadstatus(leadid)
         {
          $("#lead_status_modal").modal('show');
          $("#folowupmessage").val("");
          $("#lead_status").val("");
          $("#folowupmessage").val("");
          $("#datepicker-14").val("");
          $("#timepicker-14").val("");
          $("#lead_status_lead_id").val(leadid);
         }
         function leadreleventstatus(leadid)
         {
         /*alert(leadid);*/
         $("#lead_relevent_status_modal").modal('show');
         $("#lead_rel_status_lead_id").val(leadid);
         }
         function editrow(leadid)
         {
         $("#lead_edit_modal").modal('show');
         $("#lead_edit_lead_id").val(leadid);
         updateinfoedit(null);
         }
         function addNewLeadStatus()
         {
         
         if($("#lead_status").val()=="" && $("#folowupmessage").val()=="")
         {
         alert("please select any one field");
         return false;
         }
         
         if($("#folowupmessage").val()!="")
         {
         /* alert("dhhd");*/
         if($("#datepicker-14").val()=="")
         {
             alert("please select followup date field");
         return false;
         }
         
         if($("#timepicker-14").val()=="")
         {
             alert("please select followup time field");
         return false;
         }
         }
         var fd7=document.getElementById('lead_status_form');
         var form_data8 = new FormData(fd7); 
         $.ajax({
             url:"lead_status_info.php",
              data:form_data8,
         type:'post',
         async: true,
         dataType:'json',
         contentType: false,
         cache: false,
         processData: false,
          success:function(response){
         console.log(response);
         var status=response['Status'];
          var lead_status_value=response['lead_status_value'];
          var lead_id=response['lead_id'];
         alert(response['Message']);
           
         if(status==1){
           /*location.reload();*/
         $("#folowupmessage").val("");
           $("#lead_status").val("");
           $("#datepicker-14").val("");
           $("#timepicker-14").val("");
           $("#lead_status_modal").modal('hide'); 
         var table = $('#example1').DataTable(); table.cell("#row_"+lead_id, 9).data('<button type="button" onclick="leadstatus('+lead_id+')">'+lead_status_value+'</button>').draw();
         
         var interval = setInterval(function() {
                 if ( $(".pending").length) {
                  $(".pending").parent().parent().addClass('pendingfollow');
                     clearInterval(interval);
                 }
                 $("#pending_follow_count_number").text($(".pending").length);
             }, 1000);
               $("#example1_wrapper").parent().css('overflow','unset');
                      $("#example1").parent().css('overflow-x','scroll');
                       $("#example2_wrapper").parent().css('overflow','unset');
                      $("#example2").parent().css('overflow-x','scroll');
         }

         },
         })   
         }
         
         function addNewLeadRelStatus()
         {
         
         if($("#lead_rel_status").val()=="")
         {
         alert("please select field");
         return false;
         }
         
         var fd71=document.getElementById('lead_rel_status_form');
         var form_data81 = new FormData(fd71); 
         $.ajax({
             url:"lead_rel_status_info.php",
              data:form_data81,
         type:'post',
         async: true,
         dataType:'json',
         contentType: false,
         cache: false,
         processData: false,
          success:function(response){
         console.log(response);
         var status=response['Status'];
          var lead_status_value=response['lead_status_value'];
          var lead_id=response['lead_id'];
         alert(response['Message']);
         if(status==1){
           $("#lead_status_modal").modal('hide'); 
         var table = $('#example1').DataTable(); table.cell("#row_"+lead_id, 9).data('<button type="button" onclick="leadstatus('+lead_id+')">'+lead_status_value+'</button>').draw();
         }
         },
         })   
         }
         function leadfollowstatus(leadfollowid)
         {
         if (confirm("Are you sure you want to delete this item?")) {
         $.ajax({
             url:"lead_followup_status.php",
              data:{"leadfollowid":leadfollowid},
         type:'post',
         async: true,
         dataType:'json',
          success:function(response){
         console.log(response);
         var status=response['Status'];
         alert(response['Message']);
         if(status==1){
           location.reload();
         }
         },
         })   
         }
         }
         
         function addNewLeadFollowUp()
         {
         $("#lead_follow_form_modal_body").show();
         var fd5=document.getElementById('lead_follow_form');
         var form_data6 = new FormData(fd5); 
         if($("#folowupmessage").val()=="")
         {
         alert("please fill the follow up message field");
         return false;
         }
         
         if($("#folowupmessage").val().length>50)
         {
         alert("follow up message length should not be greater than 50");
         return false;
         }
         
         $.ajax({
             url:"lead_followup_info.php",
              data:form_data6,
         type:'post',
         async: true,
         dataType:'json',
         contentType: false,
         cache: false,
         processData: false,
          success:function(response){
         console.log(response);
         var status=response['Status'];
         alert(response['Message']);
         if(status==1){  
             $("#folowupmessage").val("");
             $("#lead_follow_modal").modal("hide");
         }
         },
         })   
         }
         function addNewLeadMemeberAccess()
         { 

         var fd3=document.getElementById('leadmemberaccessform');
         var form_data2 = new FormData(fd3); 





         $.ajax({
             url:"lead_member_access.php",
              data:form_data2,
         type:'post',
         async: true,
         dataType:'json',
         contentType: false,
         cache: false,
         processData: false,
          success:function(response){
         console.log(response);
         var status=response['Status'];
         alert(response['Message']);
         if(status==1){
             $("#add_lead_member_access_modal").modal('hide');
         }
         },
         })   
         }
         
         
         function hiderow(rowid)
         {
         if (confirm("Are you sure you want to delete this item?")) {
         $.ajax({
             url:"hiderow.php",
             method:"POST",
             data:{rowid:rowid},
            success: function(data){
             var dataObject = $.parseJSON(data);
             console.log(dataObject);
              if(dataObject==="success"){
             $("#row_"+rowid).removeClass('fa fa-eye');
                  $("#row_"+rowid).addClass('fa fa-eye-slash');
                  window.location.reload();
              }else{
                  alert("can't delete the row")
              }
         }
         });
         }
         }
         
         function addNewLeadEdit()
         {
         var fd2=document.getElementById('lead_edit_form');
         var form_data = new FormData(fd2); 
         if ($('#edit_name').val()== '') {
         alert("Please Enter Name");
         }
         else{
         $.ajax({
         url:"AjaxEditLead.php", 
         data:form_data,
         type:'post',
         async: true,
         dataType:'json',
         contentType: false,
         cache: false,
         processData: false,
         success:function(response){
         console.log(response);
         var status=response['Status'];
         alert(response['Message']);
         if(status==1){
           location.reload();
         }
         },
         error: function(xhr, status, error) {
         var err = eval("(" + xhr.responseText + ")");
         alert(err.Message);
         }
         });
         }
         }
         
         function addNewLead(){ 
         var fd2=document.getElementById('leadform');
         var form_data = new FormData(fd2); 
         /*var form_data = new FormData(document.querySelector('form'));  */
         if ($('#name').val()== '') {
         alert("Please Enter Name");
         }
         else if ($('#email').val()== '') {
         alert("Please Enter Email");
         }
         else if ($('#phone_number').val()== '') {
         alert("Please Enter Phone Number");
         }
         else if ($('#project_type').val()== '') {
         alert("Please Select Project Type");
         }
         else if ($('#form_type').val()== '') {
         alert("Please Select Form Type");
         }

         else if ($('#location').val()== '') {
         alert("Please Enter Location");
         }
         else if ($('#interested_for').val()== '') {
         alert("Please Select Interested-for");
         }
         else if ($('#budget').val()== '') {
         alert("Please Select Budget");
         }

         else if ($('#client_type').val()== '') {
         alert("Please Select Client");
         }

         else{
         $.ajax({
         url:"AjaxCreateLead.php", 
         data:form_data,
         type:'post',
         async: true,
         dataType:'json',
         contentType: false,
         cache: false,
         processData: false,
         success:function(response){
         console.log(response);
         var status=response['Status'];
         alert(response['Message']);
         if(status==1){
           location.reload();
         }
         },
         error: function(xhr, status, error) {
         var err = eval("(" + xhr.responseText + ")");
         alert(err.Message);
         }
         });
         }
         }
         $(function() {
         $(".menu").on("click", function() {
         $(".menu > i").toggleClass("fa-bars fa-close", 300);
         $(".sidebar-menu").toggleClass("show-sidebar", 5000);
         $("body").toggleClass("push-body", 5000);
         });
         });
         $(function() {
         $(".addNewLeadFollowUpHistory").on("click", function(e) {
         e.preventDefault();
          if ($.fn.DataTable.isDataTable("#example2")) {
         $('#example2').DataTable().clear().destroy();
         } 
         $("#lead_follow_form_modal_body").hide();
         $("#view_lead_follow_history").show();     
          load_data1();
         });
         });
         
         $(function() 
         {
         $("#lead_follow_modal").on("hidden.bs.modal", function()
         {
           if ($.fn.DataTable.isDataTable("#example2")) 
            {
           $('#example2').DataTable().clear().destroy();
            } 
            load_data1();
            $("#example2>tbody").html("");
         });
         });
         
      </script>
      <script type="application/javascript" src="https://api.ipify.org?format=jsonp&callback=getIP"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
      <script>
         $(function()
         {
             $( "#datepicker-13" ).datepicker({ dateFormat: 'yy-mm-dd' });
             $( "#datepicker-13_edit" ).datepicker({ dateFormat: 'yy-mm-dd' });
             $( "#datepicker-14" ).datepicker({ dateFormat: 'yy-mm-dd' });
             $('#timepicker-14').timepicker  
             ({  
                 timeFormat: 'h:mm p',  
                 interval: 60,  
                 dynamic: false,  
                 dropdown: true,  
                 scrollbar: true  
                 });  
             });
      </script> 
      <script>
         var checkList = document.getElementById('list1');
         var items = document.getElementById('items');
         checkList.getElementsByClassName('anchor')[0].onclick = function(evt) 
         {
           if (items.classList.contains('visible')) 
           {
             items.classList.remove('visible');
             items.style.display = "none";
           } else 
           {
             items.classList.add('visible');
             items.style.display = "block";
           }
         }
         items.onblur = function(evt) 
         {
           items.classList.remove('visible');
         }
      </script>
      <script type="text/javascript">
         $(document).ready(function() {
             
                 var interval = setInterval(function() {
                     if ( $(".pending").length) {
                      $(".pending").parent().parent().addClass('pendingfollow');
                         clearInterval(interval);
                     }
                 
                 }, 1000);
                 
         });
      </script>
        <script type="text/javascript">
          $(document).ready(function() {
                     $("#example1_wrapper").parent().css('overflow','unset');
                      $("#example1").parent().css('overflow-x','scroll');
                       $("#example2_wrapper").parent().css('overflow','unset');
                      $("#example2").parent().css('overflow-x','scroll');
         });
      </script>
        <script type="text/javascript">
          $(document).ready(function() {
              $(".custom-select").change(function(){
                  var interval = setInterval(function() {
                     if ( $(".pending").length) {
                      $(".pending").parent().parent().addClass('pendingfollow');
                         clearInterval(interval);
                     }
                 
                 }, 1000);
                     $("#example1_wrapper").parent().css('overflow','unset');
                      $("#example1").parent().css('overflow-x','scroll');

                       $("#example2_wrapper").parent().css('overflow','unset');
                      $("#example2").parent().css('overflow-x','scroll');
         });
          });
      </script>
    
   </body>
</html>