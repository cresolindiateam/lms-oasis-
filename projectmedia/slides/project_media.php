<?php 
session_start();
if(!isset($_SESSION['proj_team_id']))
{
  header("location: index.php");
}



?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Lead Mangement Project test demo</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.css">
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link href='http://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="http://code.jquery.com/jquery.js"></script>
<script src="src/skdslider.min.js"></script>
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
          animationSpeed: 1000,
          showNextPrev:true,
          showPlayButton:false,
          autoSlide:true,
          animationType:'sliding'
        });
    });
</script>


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
</style>
<?php 
include('../header2.php');?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
 <div  style="height:auto;min-height:0px;"> 
    <section class="content">
     <div class="container" style="margin-bottom:10px;">
       <div class="row">
       <div class="col-md-12" style="margin-bottom:10px;">
   <h4 class="text-center"><strong>Gallery</strong></h4>
 </div> 
  </div> 

<div style="max-width:800px; margin:0 auto;">
    <div id="demo2">
      <div class="slide">
          <img src="slides/1.jpg" />
          <!--Slider Description example-->
           <div class="slide-desc">
              <h2>Slider Title 1</h2>
              <p>Demo description here. Demo description here. Demo description here. Demo description here. Demo description here. <a class="more" href="#">more</a></p>
            </div>
      </div>
      <div class="slide"><img src="slides/2.jpg" />
         <div class="slide-desc">
          <h2>Slider Title 2</h2>
          <p>Demo description here. Demo description here. Demo description here. Demo description here. Demo description here. <a class="more" href="#">more</a></p>
        </div>
      </div>
      <div class="slide"><img src="slides/3.jpeg" />
        <!--NO Description Here-->
      </div>
      <div class="slide"><img src="slides/4.jpg" />
        <div class="slide-desc">
          <h2>Slider Title 4</h2>
          <p>Demo description here. Demo description here. Demo description here. Demo description here. Demo description here. <a class="more" href="#">more</a></p>
        </div>
      </div>
      <div class="slide"><img src="slides/5.jpg" /></div>
      <div class="slide"><img src="slides/6.jpg" />
        <div class="slide-desc">
          <h2>Slider Title 6</h2>
          <p>Demo description here. Demo description here. Demo description here. Demo description here. Demo description here. <a class="more" href="#">more</a></p>
        </div>
      </div>
    </div>
</div>


        <div class="row" >
         <div id="myCarousel" class="carousel slide" data-ride="carousel">
           <div class="carousel-inner" style="background: #1f9ef4;">
        <?php          
            $result2='';
            $k=1;
            $data='';
            if(isset($_GET['id']) && $_GET['id']!="")
            {
               $sql = "SELECT project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";
               $result2 = mysqli_query($conn,$sql);

                while($row2 = mysqli_fetch_assoc($result2))
                {  
                  if($row2["type_of_media"]=='image')
                  {
                    if($k==1)
                      {
                        $data= 'class="item active"';

                      }
                      else
                       {
                         $data= 'class="item"';
                       } 
                 ?>
      <div   <?php echo $data;?>>
        <img width="100%" src="<?php echo '../'.$row2["media_url"];?>" alt="<?php echo $row2["name"];?>">
        <div class="carousel-caption  d-md-block" >
       <p style="margin-top:2px;margin-bottom: 2px"><?php echo $row2["media_name"];?></p>
        <p style="margin-top:2px;margin-bottom: 2px"><?php echo $row2["type_of_media"];?></p>
       </div>
     </div>

     <?php  $k++;}}}?>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>
</div>
</div>




<div class="container" style="margin-bottom:10px;">
 <div class="row">
  <div class="col-md-12" style="margin-top:10px;margin-bottom:10px;">
   <h4 class="text-center"><strong>Document</strong></h4>
 
  </div>
  </div>  
   

        <?php    
        function str_replace_first($search, $replace, $subject)
{
    $search = '/'.preg_quote($search, '/').'/';
    return preg_replace($search, $replace, $subject, 1);
}


   if(isset($_GET['id']) && $_GET['id']!="")
            {
               $sql = "SELECT project_information.project_url as project_share_url,project_information.project_image_url,project_information.id, project_information.project_name,project_media.type_of_media,project_media.url as media_url,project_media.name as media_name from project_information left join project_media on project_media.project_id=project_information.id where 1 and project_information.project_hidden_status=0 and project_information.id=".$_GET['id']." order by id desc";
               $result3 = mysqli_query($conn,$sql);

               $s=1;
               while($row3 = mysqli_fetch_assoc($result3))
               {
                 if($row3["type_of_media"]=='document')
                 {

                  $name=$row3['media_url'];
                  $hostName = $_SERVER['HTTP_HOST']; 
                  $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
                  $newFilePath1 = str_replace_first(".", "", $name);
                  $url='`'.$protocol."://".$hostName.$newFilePath1.'`';
                  $url1=$protocol."://".$hostName.$newFilePath1;
                   ?>
     <div class="row" style="margin-top:10px;margin-bottom:10px;display: flex;align-items: center;">
      <div class="document_data">
        <div class="document_data_url" style="font-size: 20px;">
       <a href="<?php echo $url; ?>"><?php echo $row3['media_name'];?></a>
        
        </div> 
        <div class="document_data_download">
      <a href="<?php echo $url1; ?>" download = "file">
       <button class="btn btn-primary" >Download File</button>
      </a>

     <!--   <a href="<?php //echo $url; ?>" >
       <button class="btn btn-primary" download="file">Preview File</button>
      </a>
   -->

<?php 

echo   "<input class='btn btn-primary demo' type='button' id='btnPreview' value='Preview PDF Document' 
                 onclick='LoadPdfFromUrl(".$url.",".$s.")' />";
                 

                 echo   "<input class='btn btn-primary demo' type='button' id='btnPreview' value='remove Preview PDF Document' 
                 onclick='removepreview(".$s.")' />";
                 ?>

    </div>
    </div>
 </div>


 <div class="row">
    <div id="pdf_container<?php echo $s;?>">
    </div>
  </div>

     <?php $s++; }} }?>

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
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
    <script src="../dist/js/demo.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.6.347/pdf_viewer.min.css"
        rel="stylesheet" type="text/css" />
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
</body>
</html>

