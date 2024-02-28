<?php
session_start();


if(!isset($_SESSION['proj_team_id']))
{
 
  header("location: index.php");
}

include('header.php');
//include('fetch.php');
/*$db=db_connect();*/

  $sql = "SELECT id, project_name,project_image_url from project_information where id=".$_SESSION['proj_info_id']." order by id desc";
 
$projectresult = mysqli_query($conn,$sql);

if ($projectresult->num_rows > 0) {
  // output data of each row
  while($row = $projectresult->fetch_assoc()) {
   $_SESSION['image_url']= $row["project_image_url"];
    $_SESSION['project_name']= $row["project_name"];
  }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Lead Management</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <!--  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!--   <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css"> -->
   <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->

<!-- 

    <script src="plugins/dattables/jquery.dataTables.min.js"></script>
    <script src="plugins/dattables/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" href="plugins/dattables/dataTables.bootstrap.css" /> -->

      
    

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
     
     

  <div class="card-header" style="margin-bottom:10px">
          <div class="row">

          

            <div class="col-md-6" style="display:flex;justify-content:space-around;margin-top:8px;">
                <div>
                <strong>Lead status List</strong>
            </div>
           
 </div>
            
           
            <div class="col-md-3">

<div class="add_tag_list_modal">
    <div class="modal fade" id="lead_status_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="width:680px">
          <div class="modal-header">
            <h4 class="modal-title">Lead Status Details</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>
          <div class="modal-body" >
            <div class="user-info-area" id="lead_follow_form_modal_body">
              <form enctype="multipart/form-data" method="post" class="form-inline" id="lead_status_form">
             
<div class="form-group" style="margin-bottom:10px">
    
            <input type="hidden" value="" name="lead_status_lead_id" id="lead_status_lead_id">      
             
                <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Lead Status:-</strong></label>
         <select id="lead_status" name="lead_status">
          <option value="">Please Select Status</option>
          <option value="0">Raw Lead</option>
          <option value="1">Cold Lead</option>
         <option value="2">Warm Lead</option>
          <option value="3">Hot Lead</option>
         </select>

                <hr/>
              </form>





            </div>
          </div> 


</div>

          <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
       
            <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewLeadStatus();" style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">Create</button>

              </div>
        </div>
      </div>
    </div>
  </div>




<div class="add_tag_list_modal">
    <div class="modal fade" id="lead_follow_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content" style="width:680px">
          <div class="modal-header">
            <h4 class="modal-title">Lead FollowUp Details</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            
          </div>
          <div class="modal-body" >
            <div class="user-info-area" id="lead_follow_form_modal_body">
              <form enctype="multipart/form-data" method="post" class="form-inline" id="lead_follow_form">
             
<div class="form-group" style="margin-bottom:10px">
    
            <input type="hidden" value="" name="lead_followup_lead_id" id="lead_followup_lead_id">      
             
                <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Lead Followup Message:-</strong></label>
           <textarea  required name="folowupmessage" id="folowupmessage"></textarea>

                <hr/>
              </form>
            </div>
          </div> 


  <div id="view_lead_follow_history" style="display: none;">
            <div class="user-info-area">
 <div>
              <table id="example2" class="table table-bordered table-striped table-responsive" style="overflow:unset;border:unset; width:100%!important">
                <thead>
                <tr>
                                    <th>Id</th>
                  <th>Lead Id</th>
                  <th>Team Id</th>
                  <th>Message</th>
                  <th>Created At</th>
                
                </tr>
                </thead>
              </table>
            </div>
  </div>  </div>
</div>

          <div class="modal-footer">
               <button type="button" class="btn btn-danger" data-dismiss="modal" >Cancel</button>
       
            <button type="button" class="btn theme-btn" id="add-company-btn" onClick="addNewLeadFollowUp();" style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">Create</button>

             <button type="button" class="btn theme-btn addNewLeadFollowUpHistory"   style="color: #fff!important;background-color: #1893e6;border-color: #158bda;">View</button>
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

                    <select name="project_team_member" class="form-control" id="project_team_member">
                    <option value="0">not assign</option>
                     <?php 

                     $sql = "SELECT id,name from project_team where role_type=3 and project_id=".$_SESSION['proj_info_id']." order by id desc";
 
$result = mysqli_query($conn,$sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {?>
                      <option 
                     <?php  //if(intval($member_access_id)==intval($row['id'])){echo 'selected';}?>
                      
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
    <div class="modal fade" id="add_tag_list_modal" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Create New Lead</h4>
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
             <div class="form-group" style="margin-bottom:10px;display: none;">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Project Type:-</strong></label>

                    <select name="project_type" class="form-control" id="project_type">
                     <?php 
                     $sql = "SELECT id, project_name,project_image_url from project_information where id=".$_SESSION['proj_info_id']." order by id desc";
 
$result = mysqli_query($conn,$sql);
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {?>
                      <option value="<?php echo $row['id'];?>"><?php echo $row['project_name'];?></option>
                    <?php }}?>
                    </select>
                  </div>

                   <div class="form-group" style="margin-bottom:10px">
                    <label class="personal-info-label" style="margin-right:5px;width:150px;"><strong>Created At:-</strong></label>
                    <!-- <input type="text" name="phone_number" class="form-control" id="phone_number"/> -->

                    <input type="text" name="created_at_date" id = "datepicker-13">
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
              <table id="example1" class="table table-bordered table-striped table-responsive" style="overflow:unset;">
                <thead>
                <tr>
                                    <th>RawLeads</th>
                  <th>ColdLeads</th>
                   <th>WarmLeads</th>
                   
                  <th>HotLeads</th>
            

               
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

    <!-- ✅ load jQuery ✅ -->


    <!-- ✅ load jquery UI ✅ -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
      integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
      


    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
  



<script src="dist/js/demo.js"></script>

   
<script type="text/javascript" language="javascript">
    var ipAddress="";
  function getIP(json) {
      //document.write("My public IP address is: ", json.ip);
        ipAddress=json.ip;
       /* SendVisitorEntries(ipAddress,platformType);*/
        console.log("PlatformType "+platformType+"IP Address "+ipAddress);
      }


$(document).ready(function(){

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
    var dataTable = $('#example1').DataTable({
      "processing" : true,
      "serverSide" : true,
      "order" : [],
      "retrieve": true,
      "ajax" : {
        url:"fetchleadstatus.php",
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






 /* load_data1();*/









$(function() {

 $(".menu > i").toggleClass("fa-bars fa-close", 300);
    $(".sidebar-menu").toggleClass("show-sidebar", 5000);
    $("body").toggleClass("push-body", 5000);
  // info button transitions
  $(".menu").on("click", function() {
    $(".menu > i").toggleClass("fa-bars fa-close", 300);
    $(".sidebar-menu").toggleClass("show-sidebar", 5000);
    $("body").toggleClass("push-body", 5000);
  });
});



$(function() {
$("#lead_follow_modal").on("hidden.bs.modal", function(){
    
   window.location.reload();
});
});
</script>
 <script type="application/javascript" src="https://api.ipify.org?format=jsonp&callback=getIP"></script>


</body>
</html>
