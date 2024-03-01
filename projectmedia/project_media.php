<?php
require "../dbconfig.php";
$result = "";
if (isset($_GET["id"]) && $_GET["id"] != "") {
    $sql171 =
        "SELECT project_information.team_member_id,client_team_members.email as client_team_email,client_team_members.phone_number as client_team_phone,project_information.project_desc as project_desc,project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id left join client_team_members on client_team_members.id=project_information.team_member_id where 1 and project_information.project_hidden_status=0 and project_information.id=" .
        $_GET["id"] .
        " order by id desc";
    
    $result171 = mysqli_query($conn, $sql171);
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>   <?php
  $data567 = [];
  $data5678 = [];
  $data56789 = [];
  while ($row171 = $result171->fetch_assoc()) {
      $data567[] = $row171["project_name"];
      $data5678[] = $row171["project_image_url"];
      $data56789[] = $row171["project_desc"];
  }
  echo array_unique($data567)[0];
  ?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <meta name="viewport" content="width=device-width, initial-scale=1">
       <meta property="og:locale" content="en_US">
    <meta property="og:type" content="information">
    <meta property="og:title" content="<?php echo array_unique(
        $data567
    )[0]; ?>">
    <meta property="og:description" content="<?php echo array_unique(
        $data56789
    )[0]; ?>">
    <meta property="og:site_name" content="http://realstate.oasisproperty.in/">
      <meta property="og:image" content="<?php echo array_unique(
          $data5678
      )[0]; ?>" />
  <meta property="og:image:secure" content="<?php echo array_unique(
      $data5678
  )[0]; ?>" /><meta property="og:image:type" content="image/png" /> 
  <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
      <meta property="og:site_name" content="Realstate"/>
      <meta property="og:description" content="<?php echo array_unique(
          $data56789
      )[0]; ?>" />
      <meta name="twitter:image" content="<?php echo array_unique(
          $data5678
      )[0]; ?>" />
      <meta name="twitter:url" content="<?php echo array_unique(
          $data5678
      )[0]; ?>" />
      <meta name="twitter:card" content="" /> <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">



</head>

<style>
  body{
    padding: 0px !important;
  }

   .demo-code{ background-color:#ffffff; border:1px solid #333333; display:block; padding:10px;}
  .option-table td{ border-bottom:1px solid #eeeeee;}

   #pdf_container { background: #ccc; text-align: center; display: none; padding: 5px; height: 820px; overflow: auto; }

  .menu{display: none;}
  .navbar{width: 100%!important;display: block!important;padding: 0px!important;
    background: #1f9ef4!important;}

    @media only screen and (max-width: 767px) {
  .mobile-title {
    text-align: center;
  }
  .mobile-value {
    text-align: center;
  }
  .navbar{display: none!important}
}

.main-header .logo{height: 70px;}

.box{
    display: none;
    width: 100%;
}

a:hover + .box,.box:hover{
    display: block;
    position: relative;
    z-index: 100;
}
.carousel-caption{background: white;
    width: 93%;
    color: black;
    padding: 0px;
    position: absolute;
    left: 0!important;
    right: 0!important;
    bottom: 11px;
    opacity: 0.9;
    margin-left: auto;
    margin-right: auto;}
    .document_data{display: flex;
    justify-content: space-evenly;
    width: 100%;}
    .carousel-inner{
  width:100%;
 /* max-height: 500px !important;*/
}

.carousel-inner > .item > img,
.carousel-inner > .item > a > img {
  /*max-height: 500px;
  min-height: 500px;  */  /* Set slide height here */
   
}
canvas{
    border: 1px solid #ccc;
    height: 300px!important;
    width: 300px!important;
}
a:focus, a:hover {
    color: #23527c;
    text-decoration: none!important;
}
/* Scss Document */
.orange-fade {
    background: #ff910e;
    background: linear-gradient(135deg,#ff910e 0,#ffa841 100%);
}
.pos-r {
    position: relative!important;
}
.white {
    background: #fff;
}
.text-white {
    color: #fff!important;
}
.text-gray {
    color: #363636;
}
.testimonial {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
.separator {
    width: 14%;
    height: 3px;
    margin: 1.2em auto 1em;
    background: #ffc53a;
}
.one-slide {
  border-radius: 3px;
  margin-left: 1rem;
  margin-right: 1rem;
  font-size: 1.1rem;
  height: 300px;
}
.one-slide img {
  width: 60%;
}
.carousel-controls .control {
  position: absolute;
  cursor: pointer;
  top: 56.4%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
  c
}
.prev {
  left: -1.875rem;
}
.next {
  right: -1.875rem;
}
.testimonial-carousel { 
  &.slick-initialized { 
    display: block; 
  }
 .message {
    width: 100%;
    font-size: .9rem;
  }
  .brand {
    width: 100%;
  }
  @media (max-width: 575px) {
    .one-slide {
        height: 200px;
      }
    img {
        width: 40%;
      }
  }
}
#myBtn {
  display: none;
  position: fixed;
  bottom: 20px;
  right: 30px;
  z-index: 99;
  font-size: 18px;
  border: none;
  outline: none;
  background-color: red;
  color: white;
  cursor: pointer;
  padding: 15px;
  border-radius: 4px;
}

#myBtn:hover {
  background-color: #555;
}

a:hover,a:focus {
     color: unset!important;
   text-decoration: none!important; 
}

.scale3 { position: relative; /*overflow: hidden;*/ margin-top: 25px;}

.scale3 a img{border: 1px solid orange; border-radius:2px; }

.scale3 a:hover; { text-decoration: none!important; border: none!important;}
.scale3 a:active,.scale3 a:focus; { text-decoration: none; border: none;}
.scale3 a img { left: 0; right: 0;-webkit-transition: 1s ease; transition: 1s ease;}
.scale3 a img:hover {-webkit-transform: scale(1.05); transform: scale(1.05); border:1px solid #ccc;}


@media(hover: hover) and (pointer: fine) {
    #demo2:hover {
        background: yellow;
        margin-top: 20px;
    }
}

</style>
<?php 
include('../header2.php');?>
<body class="hold-transition skin-blue sidebar-mini">


    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

<div >
    <section class="orange-fade p-2 margin-top-xl pos-r" style="
    border-bottom: 1px solid white;">
     <div class="container" >
       <div class="row">
       <div class="col-md-12" >
   <h2 class="text-center font-weight-bold text-white"><strong>Project Gallery</strong></h2>
<p></p>
     <hr style="border-top: 3px solid white;
    width: 85px;"/>
 </div> 
  </div> 
  </div> 
    </section>

    <div id="demo1" >
       <?php          
            $result234='';
            $k=1;
            $data='';
            if(isset($_GET['id']) && $_GET['id']!="")
            {
               $sql = "SELECT project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";
               $result234 = mysqli_query($conn,$sql);
               $rowcount234=mysqli_num_rows($result234);

               if($rowcount234>0){
                while($row234 = mysqli_fetch_assoc($result234))
                {  
                  if($row234["type_of_media"]=='image')
                  {
                    /*if($k==1)
                      {
                        $data= 'class="item active"';

                      }
                      else
                       {
                         $data= 'class="item"';
                       } */
                 ?>
  <!--      <div class="slide">
          <img src="slides/1.jpg" /> -->
          <!--Slider Description example-->
            <!--<div class="slide-desc">
              <h2>Slider Title 1</h2>
              <p>Demo description here. Demo description here. Demo description here. Demo description here. Demo description here. <a class="more" href="#">more</a></p>
            </div>
      </div>  -->

        <div class="slide">
          <img src="<?php echo '../'.$row234["media_url"];?>" alt="<?php echo $row234["media_name"];?>" /> -->
          <!--Slider Description example-->
          <div class="slide-desc">
              <h2><?php echo $row234["media_name"];?></h2>
              <p><?php echo $row234["type_of_media"];?> <a class="more" href="#">more</a></p>
            </div>
      </div> 
  
     <?php  $k++;}}}


else{?>

    <div style="font-size:24px; margin-top:20px;margin-bottom: 20px; text-align:center;font-weight: bold;"> No Record Found</div>

<?php } }?>


    
    </div>



    
</div>






  



                      <!-- /.box-body -->
            
    </section>
 



<section class="orange-fade p-5 margin-top-xl pos-r" style="border-bottom:1px solid white;">
  <div class="container">
    <div class="row">
        <div class="col-sm-12">
        <h2 class="text-center font-weight-bold text-white">Project Brochure</h2>
        <p></p>
        <hr style="border-top: 3px solid white;
    width: 85px;"/>
       <div class="mt-5 pos-r">
          <div class="carousel-controls testimonial-carousel-controls">
            <div class="control prev"><i class="fa fa-chevron-left text-white">&nbsp;</i></div>
            <div class="control next"><i class="fa fa-chevron-right text-white">&nbsp;</i></div>
          </div>
          <div class="testimonial-carousel">
<?php 
   if(isset($_GET['id']) && $_GET['id']!="")
            {
               $sql = "SELECT project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";
               $result4 = mysqli_query($conn,$sql);


             $rowcount4=mysqli_num_rows($result4);

               if($rowcount4>0){
               $s=1;
               while($row4 = mysqli_fetch_assoc($result4))
               {
                 if($row4["type_of_media"]=='document')
                 {

                  $name=$row4['media_url'];
                  $hostName = $_SERVER['HTTP_HOST']; 
                  $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
                  /*$newFilePath1 = str_replace_first(".", "", $name);*/
                  $newFilePath1 = $name;
                  $url='`'.$protocol."://".$hostName.'/'.$newFilePath1.'`';
                  $url1=$protocol."://".$hostName.'/'.$newFilePath1;
                   ?>

            <div class="one-slide white">
              <div class="testimonial w-100 h-100  p-3 text-center">
                <div class="message text-center text-gray">
                    <a style="font-size: 28px;color:#ff9c41;"href="<?php echo $url1; ?>"><?php echo explode(".",$row4['media_name'])[0];?></a>
                </div>
                <div class="separator">&nbsp;</div>
               <!--  <div class="brand"> <a  class="mx-auto"  href="<?php echo $url1; ?>" download = "file">
       <button class="btn " style="padding: 10px;
    width: 100%;
    font-size: 15px;
    background: #ff9c41;
    border: 1px solid #ff9c41;color:white">Download File</button>
      </a>
       <img alt="Oneblood" src="https://raw.githubusercontent.com/solodev/slider-boxes/master/images/img-6.png" /> --><!--</div> -->


 <div class="brand scale3"> <a  class="mx-auto "  href="<?php echo $url1; ?>" download = "file">
     <!--   <button class="btn " style="padding: 10px;
    width: 100%;
    font-size: 15px;
    background: #ff9c41;
    border: 1px solid #ff9c41;color:white">Download File</button> -->



<img class="example-image img_responsive" src="src/image/download-pdf.png" style="background:#fff; margin:0 auto;" alt="pdf">

      </a>
      <!-- <img alt="Oneblood" src="https://raw.githubusercontent.com/solodev/slider-boxes/master/images/img-6.png" /> --></div>

              </div>
            </div>


  <?php $s++; }} } 


else{?>

    <div style="font-size:24px; margin-top:20px;margin-bottom: 20px;text-align:center; font-weight: bold;"> No Record Found</div>

<?php } } ?>


          </div>
        </div>
      </div>
    </div>
  </div>
</section>



  <section class="orange-fade p-2 margin-top-xl pos-r" style="border-bottom:1px solid white;">
     <div class="container" >
       <div class="row">
       <div class="col-md-12" >
   <h2 class="text-center font-weight-bold text-white"><strong>Project Floor Plan</strong></h2>
<p></p>
     <hr style="border-top: 3px solid white;
    width: 85px;"/>
 </div> 
  </div> 
 

    <div id="demo2" tabIndex="0" ontouchstart="myFunction(event)" ontouchmove="myFunction(event)" ontouchend="myFunction2(event)">
       <?php          
            $result234='';
            $k=1;
            $data='';
            if(isset($_GET['id']) && $_GET['id']!="")
            {
               $sql = "SELECT project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";
               $result234 = mysqli_query($conn,$sql);
               $rowcount234=mysqli_num_rows($result234);

               if($rowcount234>0){
                while($row234 = mysqli_fetch_assoc($result234))
                {  
                  if($row234["type_of_media"]=='image_floor')
                  {
                    /*if($k==1)
                      {
                        $data= 'class="item active"';

                      }
                      else
                       {
                         $data= 'class="item"';
                       } */
                 ?>
  <!--      <div class="slide">
          <img src="slides/1.jpg" /> -->
          <!--Slider Description example-->
            <!--<div class="slide-desc">
              <h2>Slider Title 1</h2>
              <p>Demo description here. Demo description here. Demo description here. Demo description here. Demo description here. <a class="more" href="#">more</a></p>
            </div>
      </div>  -->

        <div class="slide">
          <img src="<?php echo '../'.$row234["media_url"];?>" alt="<?php echo $row234["media_name"];?>" /> -->
          <!--Slider Description example-->
          <div class="slide-desc">
              <h2><?php echo $row234["media_name"];?></h2>
              <p><?php echo $row234["type_of_media"];?> <a class="more" href="#">more</a></p>
            </div>
      </div> 
  
     <?php  $k++;}}}


else{?>

    <div style="font-size:24px; margin-top:20px;margin-bottom: 20px; text-align:center;font-weight: bold;"> No Record Found</div>

<?php } }?>


    
    </div>


 </div> 
    </section>




      <section class="orange-fade p-2 margin-top-xl pos-r" style="border-bottom:1px solid white;">
     <div class="container" >
       <div class="row">
       <div class="col-md-12" >
   <h2 class="text-center font-weight-bold text-white"><strong>Project Location Map</strong></h2>
<p></p>
     <hr style="border-top: 3px solid white;
    width: 85px;"/>
 </div> 
  </div> 


    <div id="demo3" ontouchstart="myFunction(event)" ontouchmove="myFunction(event)" ontouchend="myFunction2(event)">
       <?php          
            $result234='';
            $k=1;
            $data='';
            if(isset($_GET['id']) && $_GET['id']!="")
            {
               $sql = "SELECT project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";
               $result234 = mysqli_query($conn,$sql);
               $rowcount234=mysqli_num_rows($result234);

               if($rowcount234>0){
                while($row234 = mysqli_fetch_assoc($result234))
                {  
                  if($row234["type_of_media"]=='image_map')
                  {
                    /*if($k==1)
                      {
                        $data= 'class="item active"';

                      }
                      else
                       {
                         $data= 'class="item"';
                       } */
                 ?>
  <!--      <div class="slide">
          <img src="slides/1.jpg" /> -->
          <!--Slider Description example-->
            <!--<div class="slide-desc">
              <h2>Slider Title 1</h2>
              <p>Demo description here. Demo description here. Demo description here. Demo description here. Demo description here. <a class="more" href="#">more</a></p>
            </div>
      </div>  -->

        <div class="slide">
          <img src="<?php echo '../'.$row234["media_url"];?>" alt="<?php echo $row234["media_name"];?>" /> -->
          <!--Slider Description example-->
          <div class="slide-desc">
              <h2><?php echo $row234["media_name"];?></h2>
              <p><?php echo $row234["type_of_media"];?> <a class="more" href="#">more</a></p>
            </div>
      </div> 
  
     <?php  $k++;}}}


else{?>

    <div style="font-size:24px; margin-top:20px;margin-bottom: 20px; text-align:center;font-weight: bold;"> No Record Found</div>

<?php } }?>


    
    </div>

  </div> 
    </section>

 

      <section class="orange-fade p-2 margin-top-xl pos-r" style="border-bottom:1px solid white;">
     <div class="container" >
       <div class="row">
       <div class="col-md-12" >
   <h2 class="text-center font-weight-bold text-white"><strong>Project Site Plan</strong></h2>
<p></p>
     <hr style="border-top: 3px solid white;
    width: 85px;"/>
 </div> 
  </div> 
 

    <div id="demo4" ontouchstart="myFunction(event)" ontouchmove="myFunction(event)" ontouchend="myFunction2(event)" >
       <?php          
            $result234='';
            $k=1;
            $data='';
            if(isset($_GET['id']) && $_GET['id']!="")
            {
               $sql = "SELECT project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";
               $result234 = mysqli_query($conn,$sql);
               $rowcount234=mysqli_num_rows($result234);

               if($rowcount234>0){
                while($row234 = mysqli_fetch_assoc($result234))
                {  
                  if($row234["type_of_media"]=='image_siteplan')
                  {
                   
                 ?>


        <div class="slide">
          <img src="<?php echo '../'.$row234["media_url"];?>" alt="<?php echo $row234["media_name"];?>" />
          <!--Slider Description example-->
          <div class="slide-desc">
              <h2><?php echo $row234["media_name"];?></h2>
              <p><?php echo $row234["type_of_media"];?> <a class="more" href="#">more</a></p>
            </div>
      </div> 
  
     <?php  $k++;}}}


else{?>

    <div style="font-size:24px; margin-top:20px;margin-bottom: 20px; text-align:center;font-weight: bold;"> No Record Found</div>

<?php } }?>


    
    </div>
 </div> 
    </section>




      <section class="orange-fade p-2 margin-top-xl pos-r" style="border-bottom:1px solid white;">
     <div class="container" >
       <div class="row">
       <div class="col-md-12" >
   <h2 class="text-center font-weight-bold text-white"><strong>Project Payment Plan</strong></h2>
<p></p>
     <hr style="border-top: 3px solid white;
    width: 85px;"/>
 </div> 
  </div> 
 

    <div id="demo5" ontouchstart="myFunction(event)" ontouchmove="myFunction(event)" ontouchend="myFunction2(event)">
       <?php          
            $result234='';
            $k=1;
            $data='';
            if(isset($_GET['id']) && $_GET['id']!="")
            {
               $sql = "SELECT project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";
               $result234 = mysqli_query($conn,$sql);
               $rowcount234=mysqli_num_rows($result234);

               if($rowcount234>0){
                while($row234 = mysqli_fetch_assoc($result234))
                {  
                  if($row234["type_of_media"]=='image_paymentplan')
                  {
                   
                 ?>
  

        <div class="slide">
          <img src="<?php echo '../'.$row234["media_url"];?>" alt="<?php echo $row234["media_name"];?>" /> 
          <!--Slider Description example-->
          <div class="slide-desc">
              <h2><?php echo $row234["media_name"];?></h2>
              <p><?php echo $row234["type_of_media"];?> <a class="more" href="#">more</a></p>
            </div>
      </div> 
  
     <?php  $k++;}}}


else{?>

    <div style="font-size:24px; margin-top:20px;margin-bottom: 20px; text-align:center;font-weight: bold;"> No Record Found</div>

<?php } }?>


    
    </div>

 </div> 
    </section>

    
</div>






  



                      <!-- /.box-body -->
            
    </section>

  </div>
  






 
  
  <div class="control-sidebar-bg"></div>
</div>
 <script  src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">   
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
    <script src="../dist/js/demo.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf_viewer.min.css"
        rel="stylesheet" type="text/css" />
  
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script>
    var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
</script>  
<script>
    const $jq = jQuery.noConflict();

$jq(document).ready(function () {

    $jq(".testimonial-carousel").slick({
        infinite: !0,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: !1,
        arrows:true,
        prevArrow: $(".testimonial-carousel-controls .prev"),
        nextArrow: $(".testimonial-carousel-controls .next"),
        responsive: [{
            breakpoint: 1200,
            settings: {
                slidesToShow: 3
            }
        }, {
            breakpoint: 992,
            settings: {
                slidesToShow: 2
            }
        }, {
            breakpoint: 600,
            settings: {
                slidesToShow: 1
            }
        }]
    });
});
</script>

    <script type="text/javascript">
        var pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.worker.min.js';
        var pdfDoc = null;
        var scale = 1; //Set Scale for zooming PDF.
        var resolution = 2; //Set Resolution to Adjust PDF clarity.

var demo_count=$('.demo').length;

function removepreview(item_number)
{
$('#pdf_container'+item_number).hide();
}

        function LoadPdfFromUrl(url,item_number) {
          $('#pdf_container'+item_number).show();
            //Read PDF from URL.
            pdfjsLib.getDocument(url).promise.then(function (pdfDoc_) {
                pdfDoc = pdfDoc_;

                //Reference the Container DIV.
                var pdf_container = document.getElementById("pdf_container"+item_number);
                pdf_container.style.display = "block";

                //Loop and render all pages.
                for (var i = 1; i <= pdfDoc.numPages; i++) {
                    RenderPage(pdf_container, i);
                }
            });
        };
        function RenderPage(pdf_container, num) {
            pdfDoc.getPage(num).then(function (page) {
                //Create Canvas element and append to the Container DIV.
                var canvas = document.createElement('canvas');
                canvas.id = 'pdf-' + num;
                ctx = canvas.getContext('2d');
                pdf_container.appendChild(canvas);

                //Create and add empty DIV to add SPACE between pages.
                var spacer = document.createElement("div");
                spacer.style.height = "20px";
                pdf_container.appendChild(spacer);

                //Set the Canvas dimensions using ViewPort and Scale.
                var viewport = page.getViewport({ scale: scale });
                canvas.height = resolution * viewport.height;
                canvas.width = resolution * viewport.width;

                //Render the PDF page.
                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport,
                    transform: [resolution, 0, 0, resolution, 0, 0]
                };

                page.render(renderContext);
            });
        };

    </script>


    <script src="http://code.jquery.com/jquery.js"></script>
<script src="src/skdslider.min.js"></script>
<link href="src/skdslider.css" rel="stylesheet">

<link href="src/skdslider.css" rel="stylesheet">

<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('#demo1').skdslider({
          slideSelector: '.slide',
          delay:5000,
          animationSpeed:2000,
          showNextPrev:true,
          showPlayButton:true,
          autoSlide:true,
          animationType:'fading'
        });
         jQuery('#demo2').skdslider({
          slideSelector: '.slide',
          delay:5000,
          animationSpeed:2000,
          showNextPrev:false,
          showPlayButton:false,
          autoSlide:true,
          animationType:'sliding',
          numericNav:true,
           pauseOnHover: true

        });
          jQuery('#demo3').skdslider({
          slideSelector: '.slide',
          delay:5000,
          animationSpeed:2000,
          showNextPrev:false,
          showPlayButton:false,
          autoSlide:true,
          animationType:'sliding',
          numericNav:true,
          pauseOnHover: true,
        });
           jQuery('#demo4').skdslider({
          slideSelector: '.slide',
          delay:5000,
          animationSpeed:2000,
          showNextPrev:false,
          showPlayButton:false,
          autoSlide:true,
          animationType:'sliding',
          numericNav:true,
          pauseOnHover: true,
        });
            jQuery('#demo5').skdslider({
          slideSelector: '.slide',
          delay:50000,
          animationSpeed:20000,
          showNextPrev:false,
          showPlayButton:false,
          autoSlide:true,
          animationType:'sliding',
          numericNav:true,
          pauseOnHover: true,
        });

     
    });

 /*   var c = document.getElementsByTagName("canvas");;
var ctx = c[0].getContext("2d");
ctx.font = "30px Arial";*/


function myFunction1(e)
{
    

setTimeout(
  function() 
  {
     return  false; 
  }, 10000000000 * 60 * 60);

}

function myFunction21(e)
{
    return true;  
}


</script>



</body>
</html>

