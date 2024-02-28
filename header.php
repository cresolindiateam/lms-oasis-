<?php
require 'dbconfig.php';

/*ini_set("session.gc_maxlifetime", "3600");
ini_set("session.cookie_lifetime","3600");*/

session_start();
if(isset($_SESSION['proj_info_id'])){
  if($_SESSION['proj_info_id']==""){
    echo "<script> window.location = 'index.php'</script>";
  }
}else{
  echo "<script> window.location = 'leads_list.php'</script>";
}





?>

  <header class="main-header">
    <a href="#" class="logo">
      <span class="logo-mini"><b>A</b>LT</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="search-container" style="display: none;">
      <input type="text" class="search-input" placeholder="Search..."/>
      <span><button><i class="fa fa-search"></i></button></span>
      </div>
<div class="menu"><i class="fa fa-1x fa-bars" style="color:#ffffff;"></i></div>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            
            
            
            
          <li class="dropdown user user-menu pr-20 active">
            <a href="logout.php"><i class="fa fa-sign-out"></i>Logout</a>
          </li>
          <li class="dropdown notifications-menu" style=" display: none;">
            <a href="#" onclick="newNotification();" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-bell-o" ></i>
              <span class="label label-warning" id="notificationsCount"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header"><span id="notificationsMessage"></span></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          
         
        </ul>

       
      
      </div>
    </nav>
  </header>

