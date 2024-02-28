<style>
  body {
    padding: 0px !important;
  }
</style> <?php 
$classIndex = "treeview";
$classCompanies = "treeview";
$classCompanyClients = "treeview";
$classCompanyTeam="treeview";
$classProject="treeview";
if(basename($_SERVER['PHP_SELF'])=="leads_list.php"){
  $classIndex="treeview active";
}
else if(basename($_SERVER['PHP_SELF'])=="lead_count_list.php"){
  $classCompanies="treeview active";
}
else if(basename($_SERVER['PHP_SELF'])=="visitor_entries.php"){
  $classCompanyClients="treeview active";
}

else if(basename($_SERVER['PHP_SELF'])=="team_member.php"){
  $classCompanyTeam="treeview active";
}

else if(basename($_SERVER['PHP_SELF'])=="project.php"){
  $classProject="treeview active";
}
?> 
<!--<div class="container">
  <div class="modal fade" id="change-password-modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <!--<div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Change Your Password</h4>
        </div>
        <div class="modal-body">
          <div class="theme-form">
            <div class="row mt-15">
              <div class="col-md-12">
                <label>Current Password</label>
                <i class="fa fa-lock form-inner-icon"></i>
                <input type="text" class="form-control" id="old_password">
              </div>
              <div class="col-md-12">
                <label>New Password</label>
                <i class="fa fa-lock form-inner-icon"></i>
                <input type="text" class="form-control" id="new_password">
              </div>
              <div class="col-md-12">
                <label>Re-enter New Password</label>
                <i class="fa fa-lock form-inner-icon"></i>
                <input type="text" class="form-control" id="new_password_confirm">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <center>
            <button type="button" class="btn theme-btn btn-default" id="password_submit">Save Changes</button>
          </center>
        </div>
      </div>
    </div>
  </div>
</div>-->
<aside class="main-sidebar">
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="image admin-img " style=""> <?php 
        if($_SESSION['role_type']==3 || $_SESSION['role_type']==2){?> 
        <img src="<?php echo $_SESSION['image_url']; ?>" /> <?php }?> 
        <div class="admin-name">
          <p style="color:#000000"> <?php echo $_SESSION['team_member_name']; 
          echo "<br/>";
          if($_SESSION['role_type']==1)
          {echo "(Super Admin)";}
          else if($_SESSION['role_type']==2)
          {echo "(Admin)";}
          else if($_SESSION['role_type']==3)
          {echo "(Team Member)";} ?> <br> <?php
          if($_SESSION['role_type']==3 || $_SESSION['role_type']==2){?> <small> <?php echo $_SESSION['project_name']; ?> </small> <?php }?> </p>
        </div>
      </div>
      <hr />
      <div></div>
    </div>
    <!-- search form -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="
									<?php echo $classIndex; ?>">
        <a href="leads_list.php">
          <i class="fa fa-check-circle-o"></i>
          <span>Lead </span>
        </a>
      </li> <?php if($_SESSION['role_type']==1){?> <li class="
									<?php echo $classCompanies; ?>">
        <a href="lead_count_list.php">
          <i class="fa fa-check-circle-o"></i>
          <span>Lead Count</span>
        </a>
      </li> <?php }?> <?php if($_SESSION['role_type']==1){?> <li class="
									<?php echo $classCompanyClients; ?>">
        <a href="visitor_entries.php">
          <i class="fa fa-check-circle-o"></i>
          <span>Visitor Entries</span>
        </a>
      </li>
      <li class="
									<?php echo $classProject; ?>">
        <a href="project.php">
          <i class="fa fa-check-circle-o"></i>
          <span>Projects</span>
        </a>
      </li> <?php }?> <?php if($_SESSION['role_type']==2 || $_SESSION['role_type']==1){?> <li class="
									<?php echo  $classCompanyTeam; ?>">
        <a href="team_member.php">
          <i class="fa fa-check-circle-o"></i>
          <span>Team Member</span>
        </a>
      </li> <?php }?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>