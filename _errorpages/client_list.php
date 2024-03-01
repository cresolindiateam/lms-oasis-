<?php
session_start();
if (!isset($_SESSION["proj_team_id"])) {
    header("location: index.php");
}
include "header.php";
$sql =
    "SELECT clients.id, clients.name,clients.type,clients.email,clients.members,expiry,created_at from clients left join client_team on client_team.client_id = clients.id where client_team.id=" .
    $_SESSION["proj_info_id"] .
    " order by id desc";

$result = mysqli_query($conn, $sql);
$notemamember = "";
$sql1 =
    "SELECT id from project_team where role_type=3 and  client_id=" .
    $_SESSION["proj_info_id"] .
    " order by id desc";

$result1 = mysqli_query($conn, $sql1);
if ($result1) {
    $notemamember = mysqli_num_rows($result1);
}
$sql2 = "SELECT id, project_name from project_information order by id desc";
$result2 = mysqli_query($conn, $sql2);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Lead Mangement Project test demo</title>
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
  <?php include "left_side_bar.php"; ?>
  <div class="content-wrapper" style="height:auto;min-height:0px;"> 
    <!-- Main content -->
<section class="content">
  <div class="card-header" style="margin-bottom:10px;">
          <div class="row">
            <div class="col-md-6">Client List</div>
            <div class="col-md-3">
    <?php if (intval($notemamember) < 6) { ?>            
                 <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_tag_list_modal" style="margin-bottom: 10px;margin-right: 10px;color: #fff!important;
    background-color: #1893e6;
    border-color: #158bda;">New Client <i class="fa fa-plus-circle"></i>
    </button>
    <?php } ?>
</div>
            <div class="col-md-3">
<div class="team_member_password_change_modal">
    <div class="modal fade" id="project_edit_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Client</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form id="updateform" enctype="multipart/form-data" method="post" class="form-inline" >
                <input type="hidden" name="edit_client_id" id="edit_client_id" value=""/>
             
                     <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Name:-</strong></label>
                    <input type="text" name="edit_client_name" class="form-control" id="edit_client_name"/>
                </div>
                
                 <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Client Type:-</strong></label>
                     <select class="form-control" id="edit_client_type" name="edit_client_type">
                     <option value="1" selected>Company</option>
                     <option value="2">Broker</option>
                     <option value="3">Freelancer</option>
                   </select>

                    </div>
             <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Client Email:-</strong></label>
                    <input type="text" name="edit_client_email" class="form-control" id="edit_client_email"/>
             </div>
            
                   <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Expiry:-</strong></label>
                   <input type="text" name="edit_client_expiry" placeholder="" class="form-control" id="datepicker_13_edit"/>
                  
             </div>


   
                <hr/>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
           <button type="button" class="btn theme-btn" id="add-company-btn" onClick="updateClient();">Update</button>
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
            <h4 class="modal-title" style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">Create New Client</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form enctype="multipart/form-data" method="post" class="form-inline" id="createclientform">
              <div class="form-group" style="margin-bottom:10px">
                 <?php if ($_SESSION["role_type"] != 1) { ?>
                      <input type="hidden" name="client_id" class="form-control" value="<?php echo $_SESSION[
                          "proj_info_id"
                      ]; ?>" id="idProject"/>
                 <?php } ?>
                   <input type="hidden" name="ipAddress" class="form-control" id="ipAddress"/>   
                    <input type="hidden" name="platformType" class="form-control" id="platformType"/>   
                    <input type="hidden" name="team_id" class="form-control" id="<?php echo $_SESSION[
                     "proj_team_id"]; ?>"/>
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Name:-</strong></label>
                    <input type="text" name="name" class="form-control" id="name"/>
                </div>
                <input type="hidden" name="client_id" class="form-control" value="<?php echo $_SESSION[
                  "proj_info_id"]; ?>" />
              
             
                <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Client Type:-</strong></label>
                      <select class="form-control" id="client_type" name="client_type">
                     <option value="1" selected>Company</option>
                     <option value="2">Broker</option>
                     <option value="3">Freelancer</option>
                   </select>
               </div>

             <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Email:-</strong></label>
                    <input  id="client_email" name="client_email" type="text" class="form-control">
             </div>
    
               <div   class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Expiry:-</strong></label>
                     <input type="text" name="client_expiry" class="form-control" id="datepicker-13"/>
                  
              </div>

                 <div   class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Client Members:-</strong></label>
                     <input type="text" name="client_members" class="form-control" id="client_members"/>
                </div>

                <hr/>
              </form>
            </div>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
          <button  style="color: #fff!important;
    background-color: #1893e6;
    border-color: #158bda;" type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewClient();">Create</button>
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
              <table id="example1" class="table table-bordered table-striped dataTable no-footer">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Email</th>
                  <th>Members</th>
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

 document.getElementById("project_url_section").style.display = "flex";
  document.getElementById("project_media_section").style.display = "none";
function webstatuscheck()
{
  var x = document.getElementById("webstatusvalue").value;

if(x=="yes")
{
  document.getElementById("project_url_section").style.display = "flex";
  document.getElementById("project_media_section").style.display = "none";

}
else
{

document.getElementById("project_url_section").style.display = "none";
  document.getElementById("project_media_section").style.display = "block";
}
}

 function teamCount(id){

 alert(id);
   $.ajax({
        url:"AjaxProjectTeamCount.php",
        method:"POST",
        data:{"projectid":id},  
          async: true,
       dataType:'json',
       success: function(response){
         console.log(response);
    var status=response['Status'];
    //alert(response['Message']);
    var projectteamcount=response['Count'];
    if(status==1){
        $("#team_project_count_"+id).val(projectteamcount);
    /*  location.reload();*/
    }
    }
});
}
 function adminCount(id){
       $.ajax({
        url:"AjaxProjectAdminCount.php",
        method:"POST",
        data:{"projectid":id},  
          async: true,
       dataType:'json',
       success: function(response){
         console.log(response);
    var status=response['Status'];
   /* alert(response['Message']); */
    var projectadmincount=response['Count'];
    if(status==1){
    /*  location.reload();*/
     $("#team_project_count_"+id).val(projectadmincount);

    }
    }
       });
}
</script>
   
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
        url:"fetchclient.php",
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

function clientedit(clientid)
{
    $("#edit_client_id").val(clientid);
     $.ajax({
        url:"getclientdetails.php",
        method:"POST",
        data:{"clientid":clientid},  
          async: true,
       dataType:'json',
       success: function(response){
         console.log(response);
       var status=response['Status'];
       var clientname=response['ClientName'];
       var clientype=response['ClientType'];
       var clientexpiry=response['ClientExpiry'];
       /*alert(clientexpiry);*/
       var clientemail=response['ClientEmail'];
    if(status==1){
       $("#edit_client_name").val(clientname);
       $("#edit_client_type").val(clientype);
       
       $("#datepicker_13_edit").datepicker('setDate', clientexpiry);
       $("#edit_client_email").val(clientemail);
    }
    }
});   
 
    
   
    
$("#project_edit_modal").modal('show');
}

function deleteclient(clientid)
{
   if (confirm("Are you sure to delete this Client?")) {
   $.ajax({
        url:"deleteclient.php",
        method:"POST",
        data:{"clientid":clientid},  
          async: true,
       dataType:'json',
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

function   updateClient()
{ 
    var fd=document.getElementById('updateform');
    var form_data1 = new FormData(fd);  
    if ($('#edit_name').val()== '') {
    alert("Please Enter name");
  }
   else if ($('#edit_client_email').val()== '') {
    alert("Please Enter Email ");
  }

   else if ($('#edit_cient_type').val()== '') {
    alert("Please Choose Client Type");
  }

  else
  {
      $.ajax
      ({
        url:"getclient.php",
        method:"POST",
        data:form_data1,
        async: true,
        dataType:'json',
        contentType: false,
        cache: false,
        processData: false,
        success: function(response)
        {
          console.log(response);
          var status=response['Status'];
          alert(response['Message']);
          if(status==1)
          {
            location.reload();
          }
        }
      });   
  }
}

 function addNewClient(){ 
 var fd2=document.getElementById('createclientform');
  var form_data = new FormData(fd2);  
   if ($('#name').val()== '') {
    alert("Please Enter Name");
  }

 else if ($('#client_type').val()== '') {
    alert("Please Choose Client Type");
  }

 else if ($('#client_email').val()== '') {
    alert("Please Enter Email");
  }
 

  else{
 $.ajax({
  url:"AjaxCreateClient.php", 
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

  $(function()
         {
             $( "#datepicker-13" ).datepicker({ dateFormat: 'yy-mm-dd' });
$( "#datepicker_13_edit" ).datepicker({ dateFormat: 'yy-mm-dd' });

            $("#example1_wrapper").parent().css('overflow','unset');
                      $("#example1").parent().css('overflow-x','scroll');
            
       });

</script>
</body>
</html>
