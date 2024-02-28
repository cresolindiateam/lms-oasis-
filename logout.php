<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
    unset($_SESSION["companyid"]);
    
      unset($_SESSION["role_type"]);
   unset($_SESSION["project_name"]);
    unset($_SESSION["project_image_url"]);
       unset($_SESSION["proj_info_id"]);
     unset($_SESSION["project_info_id"]);
  
     
   unset($_SESSION['proj_team_id']);
   unset($_SESSION['team_member_name']);

  	
echo "<script> window.location = 'index.php'</script>";

?>