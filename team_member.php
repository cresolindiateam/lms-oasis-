<?php
session_start();
if(!isset($_SESSION['proj_team_id']))
{
  header("location: index.php");
}

include('header.php');
$sql = "SELECT id, project_name from project_information where id=".$_SESSION['proj_info_id']." order by id desc";
$result = mysqli_query($conn,$sql);



function count_members($client_id){
$notemamember='';
$sql1 = "select count(id) as count from client_team_members where 1 and role_type=4 and client_id=".$client_id;
$servername="localhost";
$username="newleadusersub";
$password="#rOQ7lYILxnu";
$dbname = "newoasisproperty_LeadManagementDB";
$conn = mysqli_connect($servername, $username, $password, $dbname);
 
$result1 = mysqli_query($conn,$sql1);
$data = mysqli_fetch_assoc($result1);
return $data['count'];

  }

$sql2 = "SELECT id, name, members from clients where 1 and client_hidden_status=0 order by id desc";
$result2 = mysqli_query($conn,$sql2);
$sql3='';
    
if($_SESSION['role_type']==1)
 {
    $sql3 = "SELECT id, name,members from clients where 1 and client_hidden_status=0 order by id desc";
  }

else
 {
            $sql3 = "SELECT id, name,members from clients where 1 and client_hidden_status=0 and id=".$_SESSION['proj_info_id']." order by id desc";
  }


$result3 = mysqli_query($conn,$sql3);   



$sql4 = "SELECT id, username from client_team_members where 1 and role_type=3  and client_id=".$_SESSION['proj_info_id']." order by id desc";
$result4 = mysqli_query($conn,$sql4);

$sql5 = "SELECT id, username from client_team_members where 1 and role_type=3   order by id desc";
$result5 = mysqli_query($conn,$sql5);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Lead Mangement</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
</head>

<style>
  body{
    padding: 0px !important;
  }
</style>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 
  <?php include('left_side_bar.php');?>
  <div class="content-wrapper" style="height:auto;min-height:0px;"> 
  <!--   <section class="content-header">
      <h1 class="make-inline">
        Lead List
      </h1>
    </section> -->
    <!-- Main content -->
<section class="content">
     
     

  <div class="card-header" style="margin-bottom:10px;">
          <div class="row">

          

            <div class="col-md-6">Team Member List</div>
            <div class="col-md-3">
    
    <?php //if(intval($notemamember) < $limit_members){ ?>            
                 <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_tag_list_modal" style="margin-bottom: 10px;margin-right: 10px;color: #fff!important;
    background-color: #1893e6;
    border-color: #158bda;">New Team Member <i class="fa fa-plus-circle"></i>
    </button>
    <?php //}
    
    ?>


</div>
            <div class="col-md-3">

                

<div class="team_member_password_change_modal">
    <div class="modal fade" id="team_member_password_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Team Member</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form id="updateform" enctype="multipart/form-data" method="post" class="form-inline" >
             
<input type="hidden" name="team_member_id" id="team_member_id" value=""/>
             
              <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Name:-</strong></label>
                    <input type="text" name="edit_name" class="form-control" id="edit_name"/>
             </div>
             
              <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Email:-</strong></label>
                    <input type="text" name="edit_email" class="form-control" id="edit_email"/>
             </div>
             <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Phone Number:-</strong></label>
                    <input type="text" name="edit_phone_number" class="form-control" id="edit_phone_number"/>
             </div>
             <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Role</strong></label>

                    <select name="edit_role_type" class="form-control" id="edit_role_type"  onchange="teammemberexpiryaccessbility();get_role_val_edit(this);" >
            
            <option value="">Please Select Role Type</option>

            <?php if($_SESSION['role_type']==1){?>
                      <option value="2">Admin</option>
            <?php }?>
            <?php if($_SESSION['role_type']==1 || $_SESSION['role_type']==2){?>
                      <option value="3">Team Leader</option>
            <?php }?>

            <?php if($_SESSION['role_type']==1 || $_SESSION['role_type']==2 || $_SESSION['role_type']==3){?>
                      <option value="4">Team Member</option>
            <?php }?>
                    </select>
                    
                    
                    
                  </div>
                  
                      <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Client</strong></label>

                   <?php if($_SESSION['role_type']==1 || $_SESSION['role_type']==2 || $_SESSION['role_type']==3){?>
                   
                   
                   
             <select name="client_id" class="form-control limit_select_edit" id="editidClient">
                 
    <?php        
  
     $result_role_edit = []; //create array
                            while($result_role_info_edit=mysqli_fetch_assoc($result2)) {
                                $result_role_edit[] = $result_role_info_edit; //assign whole values to array
                            }
    
              if (mysqli_num_rows($result2) > 0) {
  // output data of each row
  foreach($result_role_edit as $row) {

      $client_id_edit= $row['id'];

                                 $members_limit_edit= $row['members'];
                          

                           if($members_limit_edit>count_members($client_id_edit)){
    ?>
      
                      <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    
            
      
      
      <?php }}?>  
         </select>
      <?php }?>


           <select name="client_id" class="form-control wt_limit_select_edit" id="editidClient">
                 
    <?php        
  
    
              if (mysqli_num_rows($result2) > 0) {
  
  foreach($result_role_edit as $row111111) {?>
      
                      <option value="<?php echo $row111111['id']; ?>"><?php echo $row111111['name']; ?></option>
                    
            
      
      
      <?php }}?>  
         </select>
      <?php }?>
                   
                    
                    
                    
                  </div>
            
             
             
                     <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Password:-</strong></label>
                    <input type="text" name="teammemberpassword" class="form-control" id="teammemberpassword"/>
                </div>

                 <div class="form-group" style="margin-bottom:10px;visibility:hidden;" id="teammemberexpirydivedit">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Expiry:-</strong></label>
                    <input type="text" name="teammemberexpiryedit" class="form-control" id="teammemberexpiryedit"/>
                    </div>

                   
              

                <hr/>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
           <button type="button" class="btn theme-btn" id="add-company-btn" onClick="updateTeamMemberPassword();">Update</button>
           
          </div>
        </div>
      </div>
    </div>
  </div>


    <div class="add_tag_list_modal">
    <div class="modal fade" id="add_tag_list_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" style="color: #fff!important;
    background-color: #1893e6;
    border-color: #158bda;">Create New Team Member</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form enctype="multipart/form-data" method="post" class="form-inline" id="creatememberform">
             
<div class="form-group" style="margin-bottom:10px">
    
     <?php if($_SESSION['role_type']!=1){?>
                      <input type="hidden" name="project_id" class="form-control" value="<?php echo $_SESSION['proj_info_id']; ?>" id="idProject"/>
       
            <?php }
            ?>
                   <input type="hidden" name="ipAddress" class="form-control" id="ipAddress"/>   
                    <input type="hidden" name="platformType" class="form-control" id="platformType"/>          
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Name:-</strong></label>
                    <input type="text" name="name" class="form-control" id="name"/>
                    </div>
             
             <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Email:-</strong></label>
                    <input type="text" name="email" class="form-control" id="email"/>
             </div>
             <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Phone Number:-</strong></label>
                    <input type="text" name="phone_number" class="form-control" id="phone_number"/>
             </div>
             <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Role</strong></label>

                    <select name="role_type" class="form-control" id="role_type" onchange="teammemberexpiryaccessbility();get_role_val(this);">
            <option value="">Please Select Role Type</option>
            <?php if($_SESSION['role_type']==1){?>
                      <option value="2">Admin</option>
            <?php }?>
            <?php if($_SESSION['role_type']==1 || $_SESSION['role_type']==2){?>
                      <option value="3">Team Leader</option>
            <?php }?>
             <?php if($_SESSION['role_type']==1 || $_SESSION['role_type']==2 || $_SESSION['role_type']==3){?>
                      <option value="4">Team Member</option>
            <?php }?>

                    </select>
                    
                    
                    
                  </div>


 <?php 

 if($_SESSION['role_type']==2) {?>
<div class="form-group" style="margin-bottom:10px;display:none;" id="team_leader_id_div" >
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Team Leader</strong></label>

                    <select required name="proj_team_id" class="form-control" id="team_leader_id" >
            <option value="">Please Select Team Leader</option>
   
   <?php        
 while($row4 = $result4->fetch_assoc()) {?>

                      <option value="<?php echo $row4['id'];?>"><?php echo $row4["username"];?></option>
          
          <?php }?>

                    </select>
                    
                    
                    
                  </div>

                <?php }?>


 <?php 

 if($_SESSION['role_type']==1) {?>
<div class="form-group" style="margin-bottom:10px;display:none;" id="team_leader_id_div" >
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Team Leader</strong></label>

                    <select name="proj_team_id" class="form-control" id="team_leader_id" required>
            <option value="">Please Select Team Leader</option>
   
   <?php        
 while($row5 = $result5->fetch_assoc()) {?>

                      <option value="<?php echo $row5['id'];?>"><?php echo $row5["username"];?></option>
          
          <?php }?>

                    </select>
                    
                    
                    
                  </div>

                <?php }?>




                  
                  <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Clients</strong></label>
                   <?php if($_SESSION['role_type']==1 ||$_SESSION['role_type']==2 || $_SESSION['role_type']==3){



                        ?>
                    


                         <select name="client_id" class="form-control limit_select" id="idProject">
                             <?php  


                            $result_role = []; //create array
                            while($result_role_info=mysqli_fetch_assoc($result3)) {
                                $result_role[] = $result_role_info; //assign whole values to array
                            }

                          if (mysqli_num_rows($result3) > 0) 
                          {
                            // output data of each row
                            foreach($result_role as $row) { 
                                 $client_id= $row['id'];
                                 $members_limit= $row['members'];
                           if($members_limit>count_members($client_id)){

                              ?>
                                  <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                      <?php } }}?>  
                          </select>
                    <?php }?>
                  


   <?php if($_SESSION['role_type']==1 ||$_SESSION['role_type']==2 || $_SESSION['role_type']==3){?>
                         <select name="client_id" class="form-control wt_limit_select" id="idProject">
                             <?php        
                          if (mysqli_num_rows($result3) > 0) 
                          {
                            foreach($result_role as $row1111) { 
                      
                              ?>
                                  <option value="<?php echo $row1111['id']; ?>"><?php echo $row1111['name']; ?></option>
                      <?php  }}?>  
                          </select>
                    <?php }?>



                  </div>


                     <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Password:-</strong></label>
                    <input type="password" name="password" class="form-control" id="password"/>
                </div>

                  <div class="form-group" style="margin-bottom:10px;visibility:hidden;" id="teammemberexpirydiv">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Expiry:-</strong></label>
                    <input type="text" name="teammemberexpiry" class="form-control" id="teammemberexpiry"/>
                    </div>

                <hr/>
              </form>
            </div>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
          <button  style="color: #fff!important;
    background-color: #1893e6;
    border-color: #158bda;" type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewLead();">Create</button>
          
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
              <div class="input-group">
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
        </div>

     
            
            <!-- /.box-header -->
            <div>
              <table id="example1" class="table table-bordered table-striped ">
                <thead>
                <tr>
                                    <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone Number </th>
                  <th>Role Type</th>
                   <th>Expiry Date</th>
                   <th>Client </th>
                  <th>Created At</th>
                   <th>Action</th>
                 
               
                </tr>
                </thead>
               <!--  <tbody> -->

<?php
/*
if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {


  $count=$key+1;
  
        echo'<tr>'; 
        echo'<td>'.$count.'</td>';
        echo'<td>'.$row['name'].'</td>';
        echo'<td>'.$row['email'].'</td>';
        echo'<td>'.$row['phone_number'].'</td>';
        echo'<td>'.$row['form_type'].'</td>';
        echo'<td>'.$row['ip_address'].'</td>';
        echo'<td>'.$row['platform_type'].'</td>';
        echo'<td>'.$row['created_at'].'</td>';
}     

}   
*/   

?>

             <!--  </tbody> -->
               
              </table>
            </div>
            <!-- /.box-body -->
        
      

    </section>
    </section>
  </div>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<!-- <script src="plugins/jQuery/jquery-2.2.3.min.js"></script> -->
<!-- jQuery UI 1.11.4 -->
<!-- <script src="plugins/jQuery/jquery-ui.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- <script>
  $.widget.bridge('uibutton', $.ui.button);
</script> -->
<!-- Bootstrap 3.3.6 -->
<!-- <script src="bootstrap/js/bootstrap.min.js"></script> -->
<!-- Morris.js charts -->
<!-- <script src="plugins/jQuery/raphael-min.js"></script> -->

<!-- daterangepicker -->
<!-- <script src="plugins/jQuery/moment.min.js"></script> -->

<!-- Bootstrap WYSIHTML5 -->
<!-- <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script> -->

<!-- AdminLTE App -->
<!-- <script src="dist/js/app.min.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->

<!-- page script -->

<!-- <script src="plugins/jQuery/jquery-2.2.3.min.js"></script> -->
<!-- Bootstrap 3.3.6 -->
<!-- <script src="bootstrap/js/bootstrap.min.js"></script> -->
<!-- DataTables -->
<!-- <script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script> -->

<!-- AdminLTE App -->
<!-- <script src="dist/js/app.min.js"></script -->>
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
<script type="text/javascript" language="javascript">
$(document).ready(function(){
  function load_data(start, length)
  {
    var dataTable = $('#example1').DataTable({
      "processing" : true,
      "serverSide" : true,
      "order" : [],
      "retrieve": true,
      "ajax" : {
        url:"fetchteammember.php",
        method:"POST",
        data:{start:start, length:length}
      },
      "drawCallback" : function(settings){
        var page_info = dataTable.page.info();
        console.log(page_info);
        /*page_info.pages= Math.ceil(page_info.recordsTotal/page_info.length);*/
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
  }

  load_data();

  $('#pagelist').change(function(){
    var start = $('#pagelist').find(':selected').data('start');
    var length = $('#pagelist').find(':selected').data('length');
    load_data(start, length);
    var page_number = parseInt($('#pagelist').val());
    var test_table = $('#example1').dataTable();
    test_table.fnPageChange(page_number);
  });
}); 
$("#example1").parent().css('overflow-x','scroll');

function passwordchange(teammemberid)
{
    $("#team_member_id").val(teammemberid);
        $.ajax({
        url:"getteamdetails.php",
        method:"POST",
        data:{"teamid":teammemberid},  
        async: true,
        dataType:'json',
       success: function(response){
         console.log(response);
       var status=response['Status'];
       //alert(response['Message']);
       var teamemail=response['TeamEmail'];
       var teamname=response['TeamName'];
       var teamphone=response['TeamPhone'];
       var teamrole=response['TeamRole'];
       var clientid=response['ClientId'];
       var teamexpiry=response['TeamExpiry'];
      if(status==1){
        /*location.reload();*/
        $("#edit_name").val(teamname);
        $("#edit_phone_number").val(teamphone);
        $("#edit_email").val(teamemail);



        $("#edit_role_type").val(teamrole);

if(parseInt(teamrole)==4)
{
 
  var elems = document.getElementsByClassName('wt_limit_select_edit');

for (var i=0;i<elems.length;i+=1){
  elems[i].style.display = 'none';
  elems[i].disabled = true;
}

 var elems2 = document.getElementsByClassName('limit_select_edit');


  for (var i=0;i<elems2.length;i+=1){
  elems2[i].style.display = 'block';
  elems2[i].disabled = false;
   }
}
else
{
  var elems = document.getElementsByClassName('wt_limit_select_edit');

  for (var i=0;i<elems.length;i+=1){
  elems[i].style.display = 'none';
  elems[i].disabled = true;
    }


   var elems2 = document.getElementsByClassName('limit_select_edit');

     for (var i=0;i<elems2.length;i+=1){
       elems2[i].style.display = 'block';
        elems2[i].disabled = false;
    }
}


/*alert(teamrole);
alert(clientid);*/
if(parseInt(teamrole)==2)
{
 
  document.getElementById('teammemberexpirydivedit').style.visibility='visible';
}
else
{
  document.getElementById('teammemberexpirydivedit').style.visibility='hidden';
}

        $("#editidClient").val(clientid);


         $("#teammemberexpiryedit").datepicker('setDate', teamexpiry);
      }
    }
}); 
$("#team_member_password_modal").modal('show');
}

function deleteteammember(teammemberid)
{
 /*$("#team_member_id").val(teammemberid);
 $("#team_member_password_modal").modal('show');*/
   if (confirm("Are you sure to delete this team member?")) {
    $.ajax({
        url:"deleteteammember.php",
        method:"POST",
        data:{"teammemberid":teammemberid},  
        async: true,
        dataType:'json',
        success: function(response)
        {
          console.log(response);
          var status=response['Status'];
          alert(response['Message']);
          if(status==1){
            location.reload();
          }
        }
     });   
    }
}


function hiderow(rowid)
{

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

function teammemberexpiryaccessbility()
{

SESSION = { 
 "role_type": "<?php echo $_SESSION["role_type"]; ?>",

 };

var role_type=SESSION.role_type;  // will output "abc"

/*alert("hejh");*/
  d = document.getElementById("role_type").value;
  console.log(d);

  ed = document.getElementById("edit_role_type").value;
  console.log(ed);

  
  if(d=='2' && role_type=='1'){
    document.getElementById('teammemberexpirydiv').style.visibility = "visible";
  }

  else if((d=='3'||d=='4') && role_type=='2'){
    document.getElementById('teammemberexpirydiv').style.visibility = "visible";
  }

  else if((d=='4') && role_type=='3'){
    document.getElementById('teammemberexpirydiv').style.visibility = "visible";
  }

  else
  {
     document.getElementById('teammemberexpirydiv').style.visibility = "hidden";
  }


  d = document.getElementById("role_type").value;
  console.log(d);


  
  if(ed=='2'){
    
    /*var t_m_i= parseInt(document.getElementById('team_member_id'));
    passwordchange(t_m_i);*/
    document.getElementById('teammemberexpirydivedit').style.visibility = "visible";
  }
  else
  {
     document.getElementById('teammemberexpirydivedit').style.visibility = "hidden";
  }

}

function   updateTeamMemberPassword()
{ 
    var fd=document.getElementById('updateform');
    var form_data1 = new FormData(fd);  
    if ($('#teammemberpassword').val()== '') {
    alert("Please Enter Password");
  }
  else
  {
      $.ajax({
        url:"getteammember.php",
        method:"POST",
        data:form_data1,
          async: true,
  dataType:'json',
  contentType: false,
  cache: false,
  processData: false,
       success: function(response){
       
         console.log(response);
    var status=response['Status'];
    alert(response['Message']);
    if(status==1){
      location.reload();
    }
    }
});   
  }
}

 function addNewLead(){ 
  var fd2=document.getElementById('creatememberform');
  var form_data = new FormData(fd2);  
   if ($('#name').val()== '') {
    alert("Please Enter Name");
  }

 else if ($('#email').val()== '') {
    alert("Please Enter Email");
  }

 else if ($('#phone_number').val()== '') {
    alert("Please Enter Phone Number");
  }



// else if ($('#team_leader_id').val()== '') {

//     if($("#role_type").val()==2){ 
//     alert("Please Select Team Leader");
//   }
//   else
//   {
//     return true;
//   }
// }


/*   else if ($('#project_type').val()== '') {
    alert("Please Select Project Type");
  }

    else if ($('#form_type').val()== '') {
    alert("Please Select Form Type");
  }*/

  else{
  //form_data.append('file',files[0]);
  // form_data.append("file", document.getElementById('file').files[0]);
  // alert('statrttt');
 $.ajax({
  url:"AjaxCreateTeamMember.php", 
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
/* $(".menu > i").toggleClass("fa-bars fa-close", 300);
    $(".sidebar-menu").toggleClass("show-sidebar", 5000);
    $("body").toggleClass("push-body", 5000);*/
  // info button transitions
  $(".menu").on("click", function() {
    $(".menu > i").toggleClass("fa-bars fa-close", 300);
    $(".sidebar-menu").toggleClass("show-sidebar", 5000);
    $("body").toggleClass("push-body", 5000);
  });
});
</script>
 
 <script>
   $(function()
         {
             $( "#teammemberexpiry" ).datepicker({ dateFormat: 'yy-mm-dd' });
             $( "#teammemberexpiryedit" ).datepicker({ dateFormat: 'yy-mm-dd' });
             $("#datepicker_13_edit" ).datepicker({ dateFormat: 'yy-mm-dd' });

var t_id=$("#team_member_id").val();

teammemberexpiryaccessbility(t_id);

   $("#example1_wrapper").parent().css('overflow','unset');
                      $("#example1").parent().css('overflow-x','scroll');

$(".limit_select").attr('disabled','disabled');
$(".limit_select").css('display','none');


$(".wt_limit_select").show();

$(".wt_limit_select").css('display','block');


       });

   function get_role_val(current_val)
{

var current_role_type= current_val.value;

/*alert(current_role_type);*/

if(current_role_type=='4')
{

  


$("#team_leader_id_div").css('display','flex');


  $(".limit_select").removeAttr('disabled');
$(".limit_select").css('display','block');

$(".wt_limit_select").attr('disabled','disabled');
$(".wt_limit_select").css('display','none');
}
else
{

$("#team_leader_id_div").css('display','none');

  $(".limit_select").attr('disabled','disabled');
  $(".limit_select").css('display','none');
$(".wt_limit_select").removeAttr('disabled','disabled');

$(".wt_limit_select").css('display','block');
}

}

   function get_role_val_edit(current_val)
{

var current_role_type= current_val.value;

alert(current_role_type);

if(current_role_type=='4')
{
  $(".limit_select_edit").removeAttr('disabled');
$(".limit_select_edit").css('display','block');

$(".wt_limit_select_edit").attr('disabled','disabled');
$(".wt_limit_select_edit").css('display','none');
}
else
{
  $(".limit_select_edit").attr('disabled','disabled');
  $(".limit_select_edit").css('display','none');
$(".wt_limit_select_edit").removeAttr('disabled','disabled');

$(".wt_limit_select_edit").css('display','block');
}

}
</script>
 <script type="application/javascript" src="https://api.ipify.org?format=jsonp&callback=getIP"></script>
</body>
</html>
