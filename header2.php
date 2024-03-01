<?php
require 'dbconfig.php';

/*ini_set("session.gc_maxlifetime", "3600");
ini_set("session.cookie_lifetime","3600");*/

/*session_start();
if(isset($_SESSION['proj_info_id'])){
  if($_SESSION['proj_info_id']==""){
    echo "<script> window.location = 'index.php'</script>";
  }
}else{
  echo "<script> window.location = 'leads_list.php'</script>";
}*/

$result='';
if(isset($_GET['id']) && $_GET['id']!="")
{
  $sql = "SELECT project_information.team_id,client_team.email as client_team_email,client_team.phone_number as client_team_phone,project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id

left join client_team on client_team.id=project_information.team_id
   where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";


   $result = mysqli_query($conn,$sql);
 }



?>
<style>
  .site-header { 
  border-bottom: 1px solid #ccc;
  padding: .5em 1em;
  background: #00adff;
}

.site-header::after {
  content: "";
  display: table;
  clear: both;
}

.site-identity {
  /*float: left;
      float: none;*/
      margin-top: 10px;
    margin-bottom: 10px;
    text-align: center;
    align-items: center;
    display: flex;
    justify-content: center;
    color: white;
}

.site-identity h1 {
  font-size: 1.5em;
  margin: .7em 0 .3em 0;
  display: inline-block;
}

.site-identity img {
  max-width: 55px;
  float: left;
  margin: 0 10px 0 0;
}

.site-navigation {
  float: right;
}

.site-navigation ul, li {
  margin: 0; 
  padding: 0;
}

.site-navigation li {
  display: inline-block;
  margin: 1.4em 1em 1em 1em;
}

.nav>li>a{color: white;}
</style>

<header class="site-header">
  <div class="site-identity">
    <?php
$project_image_url='';
while($row21 = mysqli_fetch_assoc($result)){  

  $project_name=$row21['project_name'];
  }?>
   <h2 class="text-center font-weight-bold text-white"><strong><?php echo $project_name;?></strong></h2>
 
  </div>  

  </nav>
</header>


