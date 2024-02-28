<?php
session_start();
if(!isset($_SESSION['proj_team_id']))
{
  header("location: index.php");
}
include('header.php');
$sql = "SELECT id, project_name from project_information where id=".$_SESSION['proj_info_id']." order by id desc";
$result = mysqli_query($conn,$sql);
$notemamember='';
$sql1 = "SELECT id from project_team where role_type=3 and  project_id=".$_SESSION['proj_info_id']." order by id desc";
 
$result1 = mysqli_query($conn,$sql1);
if ($result1)
    {
        $notemamember = mysqli_num_rows($result1);
    }
 $sql2 = "SELECT id, project_name from project_information order by id desc";
 $result2 = mysqli_query($conn,$sql2);
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
    <!-- Main content -->
<section class="content">
  <div class="card-header" style="margin-bottom:10px;">
          <div class="row">
            <div class="col-md-6">Project List</div>
            <div class="col-md-3">
    <?php if(intval($notemamember)<6){ ?>            
                 <button type="button" class="btn theme-btn pull-right " data-toggle="modal" data-target="#add_tag_list_modal" style="margin-bottom: 10px;margin-right: 10px;color: #fff!important;
    background-color: #1893e6;
    border-color: #158bda;">New Project <i class="fa fa-plus-circle"></i>
    </button>
    <?php }
    ?>
</div>
            <div class="col-md-3">
<div class="team_member_password_change_modal">
    <div class="modal fade" id="project_edit_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Project</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form id="updateform" enctype="multipart/form-data" method="post" class="form-inline" >
             
<input type="hidden" name="project_id" id="project_id" value=""/>
             
                     <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Name:-</strong></label>
                    <input type="text" name="edit_name" class="form-control" id="edit_name"/>
                </div>
                
                 <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Project Url:-</strong></label>
                    <input type="text" name="edit_project_url" class="form-control" id="edit_project_url"/>
             </div>
             <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Project Image Url:-</strong></label>
                    <input type="text" name="edit_project_image_url" class="form-control" id="edit_project_image_url"/>
             </div>
            
                  <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Client Name:-</strong></label>
                    <input type="text" name="edit_client_name" class="form-control" id="edit_client_name"/>
             </div>
            
              <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>User Name:-</strong></label>
                    <input type="text" name="edit_user_name" class="form-control" id="edit_user_name"/>
             </div>
            
                    
                     <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Password:-</strong></label>
                    <input type="password" name="edit_password" class="form-control" id="edit_password"/>
                </div>


                <hr/>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
           <button type="button" class="btn theme-btn" id="add-company-btn" onClick="updateProject();">Update</button>
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
    border-color: #158bda;">Create New Project</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>
          <div class="modal-body">
            <div class="user-info-area">
              <form enctype="multipart/form-data" method="post" class="form-inline" id="createprojectform">
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
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Project Url:-</strong></label>
                    <input type="text" name="project_url" class="form-control" id="project_url"/>
             </div>
             <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Project Image Url:-</strong></label>
                    <input type="text" name="project_image_url" class="form-control" id="project_image_url"/>
             </div>
            
                  <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Client Name:-</strong></label>
                    <input type="text" name="client_name" class="form-control" id="client_name"/>
             </div>
            
              <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>User Name:-</strong></label>
                    <input type="text" name="user_name" class="form-control" id="user_name"/>
             </div>
            
                    
                     <div class="form-group" style="margin-bottom:10px;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Password:-</strong></label>
                    <input type="password" name="password" class="form-control" id="password"/>
                </div>

                <hr/>
              </form>
            </div>
          </div>
          <div class="modal-footer">
             <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
          <button  style="color: #fff!important;
    background-color: #1893e6;
    border-color: #158bda;" type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewProject();">Create</button>
          
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
              <table id="example1" class="table table-bordered table-striped table-responsive">
                <thead>
                <tr>
                                    <th>Id</th>
                  <th>Project Name</th>
                  <th>Client Name</th>
                <!--  <th>Team Member Count</th>
                  <th>Admin Count</th>-->
                
                  <th>Project Image</th>
                  
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
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  

<script src="dist/js/demo.js"></script>

<script>


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
        url:"fetchproject.php",
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

function passwordchange(projectid)
{
    $("#project_id").val(projectid);
    
      $.ajax({
        url:"getprojectdetails.php",
        method:"POST",
        data:{"projectid":projectid},  
          async: true,
       dataType:'json',
       success: function(response){
         console.log(response);
    var status=response['Status'];
    var projectname=response['ProjectName'];
    var clientname=response['ClientName'];
    var username=response['UserName'];
    var projectimageurl=response['ProjectImageUrl'];
    var projecturl=response['ProjectUrl'];
    var password=response['Password']; 
    
   /* alert(response['Message']);*/
    if(status==1){
       $("#edit_name").val(projectname);
       $("#edit_project_url").val(projecturl);
       $("#edit_project_image_url").val(projectimageurl);
         $("#edit_url").val(projecturl);
       $("#edit_client_name").val(clientname);
       $("#edit_user_name").val(username);
       /*$("#edit_password").val(password);*/
    }
    }
});   
 
    
   
    
$("#project_edit_modal").modal('show');
}

function deleteproject(projectid)
{
   if (confirm("Are you sure to delete this Project?")) {
   $.ajax({
        url:"deleteproject.php",
        method:"POST",
        data:{"projectid":projectid},  
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

function   updateProject()
{ 
    var fd=document.getElementById('updateform');
    var form_data1 = new FormData(fd);  
    if ($('#edit_name').val()== '') {
    alert("Please Enter Password");
  }
  else if ($('#edit_user_name').val()== '') {
    alert("Please Enter User Name");
  }

 else if ($('#edit_password').val()== '') {
    alert("Please Enter Password");
  }
   else if ($('#edit_project_image_url').val()== '') {
    alert("Please Enter Project Image Url");
  }
  else
  {
      $.ajax({
        url:"getproject.php",
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

 function addNewProject(){ 
 var fd2=document.getElementById('createprojectform');
  var form_data = new FormData(fd2);  
   if ($('#name').val()== '') {
    alert("Please Enter Name");
  }

 else if ($('#user_name').val()== '') {
    alert("Please Enter User Name");
  }

 else if ($('#password').val()== '') {
    alert("Please Enter Password");
  }
   else if ($('#project_image_url').val()== '') {
    alert("Please Enter Project Image Url");
  }
  else{
 $.ajax({
  url:"AjaxCreateProject.php", 
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
</script>
 <script type="application/javascript" src="https://api.ipify.org?format=jsonp&callback=getIP"></script>

</body>
</html>
