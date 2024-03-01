<?php
function imageResize($imageResourceId,$width,$height) {
    $targetWidth =1520;
    $targetHeight =795;
    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);
    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);
    return $targetLayer;
}

require 'dbconfig.php';
$name=$_REQUEST["name"];
$project_desc=$_REQUEST["project_desc"];
$client_id=$_REQUEST["client_name"];

session_start();


$team_id=$_SESSION["proj_team_id"];

$type_of_mediadoc='';
$type_of_mediaimg='';
$type_of_mediafloor='';
$type_of_mediamap='';
$type_of_mediasite='';
$type_of_mediapayment='';


foreach($_REQUEST["type_of_media"] as $media)
{
    if($media=='document')
    {
        $type_of_mediadoc=$media;
    }
    elseif($media=='image')
    {
        $type_of_mediaimg=$media;
    }
    
     else if($media=='image_floor')
    {
        $type_of_mediafloor = $media;
    }
    elseif($media=='image_map')
    {
        $type_of_mediamap = $media;
    }
    
      elseif($media=='image_siteplan')
    {
        $type_of_mediasite = $media;
    }
    
      elseif($media=='image_paymentplan')
    {
        $type_of_mediapayment = $media;
    }
    
    
}


/*
$sqlUniqueEmail="SELECT project_name FROM project_information WHERE project_name = '$name' and client_id ='$client_id'  and team_member_id = '$team_id'";
*/
$sqlUniqueEmail="SELECT project_name FROM project_information WHERE project_name = '$name'";

$exeEmail = $conn->query($sqlUniqueEmail);

/*$status='';
$message='';*/
if($exeEmail->num_rows>0)
{
	$status=2;
	$message="Project already used";
}
else
{
  $sqlInsert = "INSERT INTO project_information(project_name,project_desc,project_url,project_image_url,client_id,team_member_id)"." VALUES('$name','$project_desc','','','$client_id','$team_id')";

  
	  $exeInsert = mysqli_query($conn,$sqlInsert);
	$last_id = $conn->insert_id;

if($last_id!='')
{
        if(isset($_POST['project_image_url']) && $_POST['project_image_url']!="")
      {
         
          $hostName = $_SERVER['HTTP_HOST']; 
          $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
          $project_image_url=$_POST['project_image_url'];
           $sqlInsert13 = "update project_information set project_image_url ='".$project_image_url."' where id=".$last_id;
          
          $exeInsert = mysqli_query($conn,$sqlInsert13);
      }

       /* if(isset($_FILES['project_image_url']) && $_FILES['project_image_url']!="")
        {
          $tmpFilePath1 = $_FILES['project_im
          age_url']['tmp_name'];
          if($tmpFilePath1 != "")
           {
              $name=$_FILES['project_image_url']['name'];
              $hostName = $_SERVER['HTTP_HOST']; 
              $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
              $newFilePath1 = "./projectimg/".$name;
                if(move_uploaded_file($tmpFilePath1, $newFilePath1))
                 {
                    $hostName = $_SERVER['HTTP_HOST']; 
                    $namepath=$_FILES['project_image_url']['name'];
                    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
                    $project_image_url=$protocol.'://'.$hostName."/projectimg/".$namepath;
                    $sqlInsert13 = "update project_information set project_image_url ='".$project_image_url."' where id=".$last_id;
                     $exeInsert12 = mysqli_query($conn,$sqlInsert13);
          					if($exeInsert12)
          					{
          						$status=1;
          					  $message="Project image inserted.";
          					}
          					else
          					{
          							$status=2;
          						  $message="project image not inseted";
          					}
                 }
           }

        }*/
       if(isset($_POST['project_url']) && $_POST['project_url']=="")
      {
          $hostName = $_SERVER['HTTP_HOST']; 
          $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
          
          $project_url=$protocol.'://'.$hostName."/projectmedia/project_media.php?id=".$last_id;
         
         
           $sqlInsert13 = "update project_information set project_url ='".$project_url."' where id=".$last_id;
          $exeInsert = mysqli_query($conn,$sqlInsert13);
      }
      
        else {
           
          $hostName = $_SERVER['HTTP_HOST']; 
          $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
          
          $project_url=$_POST['project_url'];
         
         
           $sqlInsert13 = "update project_information set project_url ='".$project_url."' where id=".$last_id;
         
          $exeInsert = mysqli_query($conn,$sqlInsert13);
      }


        $total = count($_FILES['upload']['name']);
        for( $i=0 ; $i < $total ; $i++ ) 
        {
         $tmpFilePath = $_FILES['upload']['tmp_name'][$i];
          if ($tmpFilePath != "")
          {
            $name='new'.$_FILES['upload']['name'][$i];
            $sourceProperties = getimagesize($tmpFilePath);
            $fileNewName = $_FILES['upload']['name'][$i];


            $folderPath = "uploadFiles/";
            $ext = pathinfo($_FILES['upload']['name'][$i], PATHINFO_EXTENSION);
            
          $newFilePath = $folderPath.'new'.$fileNewName;
            $newFilePath1 = $folderPath.$fileNewName;
            $imageType = $sourceProperties[2];
             switch ($imageType) 
             {
                    case IMAGETYPE_PNG:
                        $imageResourceId = imagecreatefrompng($tmpFilePath); 
                        $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                        imagepng($targetLayer,$folderPath.'new'.$fileNewName);
                        break;

                    case IMAGETYPE_GIF:
                        $imageResourceId = imagecreatefromgif($tmpFilePath); 
                        $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                        imagegif($targetLayer,$folderPath.'new'.$fileNewName);
                        break;

                    case IMAGETYPE_JPEG:
                        $imageResourceId = imagecreatefromjpeg($tmpFilePath); 
                        $targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
                        imagejpeg($targetLayer,$folderPath.'new'.$fileNewName);
                        break;


                    default:
                        $status=2;
              $message="project image not valid";
                        exit;
                        break;
                }
            if(move_uploaded_file($tmpFilePath, $newFilePath1)) 
            {
              
               $sqlInsert12 = "INSERT INTO project_media(type_of_media,url,name,project_id)"." VALUES('$type_of_mediaimg','$newFilePath','$name',$last_id)";
                 $exeInsert12 = mysqli_query($conn,$sqlInsert12);
                                  if($exeInsert12)
                                  {
                                    $status=1;
                                  $message="Project media inserted.";
                                  }
                                  else
                                  {
                                      $status=2;
                                    $message="project media not inseted";
                                  }


            }
          }
        }

// map images


     $totalmap = count($_FILES['uploadmap']['name']);
        for( $i=0 ; $i < $totalmap ; $i++ ) 
        {
         $tmpFilePathmap = $_FILES['uploadmap']['tmp_name'][$i];
          if ($tmpFilePathmap != "")
          {
            $namemap='new'.$_FILES['uploadmap']['name'][$i];
            $sourcePropertiesmap = getimagesize($tmpFilePathmap);
            $fileNewNamemap = $_FILES['uploadmap']['name'][$i];


            $folderPathmap = "uploadFiles/";
            $ext = pathinfo($_FILES['uploadmap']['name'][$i], PATHINFO_EXTENSION);
            
          $newFilePath = $folderPathmap.'new'.$fileNewNamemap;
            $newFilePath1 = $folderPathmap.$fileNewNamemap;
            $imageType = $sourcePropertiesmap[2];
             switch ($imageType) 
             {
                    case IMAGETYPE_PNG:
                        $imageResourceId = imagecreatefrompng($tmpFilePathmap); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiesmap[0],$sourcePropertiesmap[1]);
                        imagepng($targetLayer,$folderPathmap.'new'.$fileNewNamemap);
                        break;

                    case IMAGETYPE_GIF:
                        $imageResourceId = imagecreatefromgif($tmpFilePathmap); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiesmap[0],$sourcePropertiesmap[1]);
                        imagegif($targetLayer,$folderPathmap.'new'.$fileNewNamemap);
                        break;

                    case IMAGETYPE_JPEG:
                        $imageResourceId = imagecreatefromjpeg($tmpFilePathmap); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiesfloor[0],$sourcePropertiesfloor[1]);
                        imagejpeg($targetLayer,$folderPathmap.'new'.$fileNewNamefloor);
                        break;


                    default:
                        $status=2;
              $message="project image not valid";
                        exit;
                        break;
                }
            if(move_uploaded_file($tmpFilePathmap, $newFilePath1)) 
            {

              
               $sqlInsert12 = "INSERT INTO project_media(type_of_media,url,name,project_id)"." VALUES('$type_of_mediamap','$newFilePath','$namemap',$last_id)";
                 $exeInsert12 = mysqli_query($conn,$sqlInsert12);
                                  if($exeInsert12)
                                  {
                                    $status=1;
                                  $message="Project media inserted.";
                                  }
                                  else
                                  {
                                      $status=2;
                                    $message="project media not inseted";
                                  }


            }
          }
        }

//payment image

 $totalpayment = count($_FILES['uploadpayment']['name']);
        for( $i=0 ; $i < $totalpayment ; $i++ ) 
        {
         $tmpFilePathpayment = $_FILES['uploadpayment']['tmp_name'][$i];
          if ($tmpFilePathpayment != "")
          {
            $namepayment='new'.$_FILES['uploadpayment']['name'][$i];
            $sourcePropertiespayment = getimagesize($tmpFilePathpayment);
            $fileNewNamepayment = $_FILES['uploadpayment']['name'][$i];


            $folderPathpayment = "uploadFiles/";
            $ext = pathinfo($_FILES['uploadpayment']['name'][$i], PATHINFO_EXTENSION);
            
          $newFilePath = $folderPathpayment.'new'.$fileNewNamepayment;
            $newFilePath1 = $folderPathpayment.$fileNewNamepayment;
            $imageType = $sourcePropertiespayment[2];
             switch ($imageType) 
             {
                    case IMAGETYPE_PNG:
                        $imageResourceId = imagecreatefrompng($tmpFilePathpayment); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiespayment[0],$sourcePropertiespayment[1]);
                        imagepng($targetLayer,$folderPathpayment.'new'.$fileNewNamepayment);
                        break;

                    case IMAGETYPE_GIF:
                        $imageResourceId = imagecreatefromgif($tmpFilePathpayment); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiespayment[0],$sourcePropertiespayment[1]);
                        imagegif($targetLayer,$folderPathpayment.'new'.$fileNewNamepayment);
                        break;

                    case IMAGETYPE_JPEG:
                        $imageResourceId = imagecreatefromjpeg($tmpFilePathpayment); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiesfloor[0],$sourcePropertiesfloor[1]);
                        imagejpeg($targetLayer,$folderPathpayment.'new'.$fileNewNamepayment);
                        break;


                    default:
                        $status=2;
              $message="project payment plan image not valid";
                        exit;
                        break;
                }
            if(move_uploaded_file($tmpFilePathpayment, $newFilePath1)) 
            {
              
               $sqlInsert12 = "INSERT INTO project_media(type_of_media,url,name,project_id)"." VALUES('$type_of_mediapayment','$newFilePath','$namepayment',$last_id)";
                 $exeInsert12 = mysqli_query($conn,$sqlInsert12);
                                  if($exeInsert12)
                                  {
                                    $status=1;
                                  $message="Project media inserted.";
                                  }
                                  else
                                  {
                                      $status=2;
                                    $message="project media not inseted";
                                  }


            }
          }
        }



//site image

 $totalsite = count($_FILES['uploadsite']['name']);
        for( $i=0 ; $i < $totalsite ; $i++ ) 
        {
         $tmpFilePathsite = $_FILES['uploadsite']['tmp_name'][$i];
          if ($tmpFilePathsite != "")
          {
            $namesite='new'.$_FILES['uploadsite']['name'][$i];
            $sourcePropertiessite = getimagesize($tmpFilePathsite);
            $fileNewNamesite = $_FILES['uploadsite']['name'][$i];


            $folderPathsite = "uploadFiles/";
            $ext = pathinfo($_FILES['uploadsite']['name'][$i], PATHINFO_EXTENSION);
            
          $newFilePath = $folderPathsite.'new'.$fileNewNamesite;
            $newFilePath1 = $folderPathsite.$fileNewNamesite;
            $imageType = $sourcePropertiessite[2];
             switch ($imageType) 
             {
                    case IMAGETYPE_PNG:
                        $imageResourceId = imagecreatefrompng($tmpFilePathsite); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiessite[0],$sourcePropertiessite[1]);
                        imagepng($targetLayer,$folderPathsite.'new'.$fileNewNamesite);
                        break;

                    case IMAGETYPE_GIF:
                        $imageResourceId = imagecreatefromgif($tmpFilePathsite); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiessite[0],$sourcePropertiessite[1]);
                        imagegif($targetLayer,$folderPathsite.'new'.$fileNewNamesite);
                        break;

                    case IMAGETYPE_JPEG:
                        $imageResourceId = imagecreatefromjpeg($tmpFilePathsite); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiesfloor[0],$sourcePropertiesfloor[1]);
                        imagejpeg($targetLayer,$folderPathsite.'new'.$fileNewNamesite);
                        break;


                    default:
                        $status=2;
              $message="project image not valid";
                        exit;
                        break;
                }
            if(move_uploaded_file($tmpFilePathsite, $newFilePath1)) 
            {
              

               $sqlInsert12 = "INSERT INTO project_media(type_of_media,url,name,project_id)"." VALUES('$type_of_mediasite','$newFilePath','$namesite',$last_id)";
                 $exeInsert12 = mysqli_query($conn,$sqlInsert12);
                                  if($exeInsert12)
                                  {
                                    $status=1;
                                  $message="Project media inserted.";
                                  }
                                  else
                                  {
                                      $status=2;
                                    $message="project media not inseted";
                                  }


            }
          }
        }


// floor image

     $totalfloor = count($_FILES['uploadfloor']['name']);
        for( $i=0 ; $i < $totalfloor ; $i++ ) 
        {
         $tmpFilePathfloor = $_FILES['uploadfloor']['tmp_name'][$i];
          if ($tmpFilePathfloor != "")
          {



            $namefloor = 'new'.$_FILES['uploadfloor']['name'][$i];
            $sourcePropertiesfloor = getimagesize($tmpFilePathfloor);
            $fileNewNamefloor = $_FILES['uploadfloor']['name'][$i];


            $folderPathfloor = "uploadFiles/";
            $ext = pathinfo($_FILES['uploadfloor']['name'][$i], PATHINFO_EXTENSION);
            
            $newFilePath = $folderPathfloor.'new'.$fileNewNamefloor;
            $newFilePath1 = $folderPathfloor.$fileNewNamefloor;
            $imageType = $sourcePropertiesfloor[2];
             switch ($imageType) 
             {
                    case IMAGETYPE_PNG:
                        $imageResourceId = imagecreatefrompng($tmpFilePathfloor); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiesfloor[0],$sourcePropertiesfloor[1]);
                        imagepng($targetLayer,$folderPathfloor.'new'.$fileNewNamefloor);
                        break;

                    case IMAGETYPE_GIF:
                        $imageResourceId = imagecreatefromgif($tmpFilePathfloor); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiesfloor[0],$sourcePropertiesfloor[1]);
                        imagegif($targetLayer,$folderPathfloor.'new'.$fileNewNamefloor);
                        break;

                    case IMAGETYPE_JPEG:
                        $imageResourceId = imagecreatefromjpeg($tmpFilePathfloor); 
                        $targetLayer = imageResize($imageResourceId,$sourcePropertiesfloor[0],$sourcePropertiesfloor[1]);
                        imagejpeg($targetLayer,$folderPathfloor.'new'.$fileNewNamefloor);
                        break;


                    default:
                        $status=2;
              $message="project floor image not valid";
                        exit;
                        break;
                }
            if(move_uploaded_file($tmpFilePathfloor, $newFilePath1)) 
            {
              
            $type_of_mediafloor=$_REQUEST["type_of_media"][2];



               $sqlInsert12 = "INSERT INTO project_media(type_of_media,url,name,project_id)"." VALUES('$type_of_mediafloor','$newFilePath','$namefloor',$last_id)";
                 $exeInsert12 = mysqli_query($conn,$sqlInsert12);
                                  if($exeInsert12)
                                  {
                                    $status=1;
                                  $message="Project media inserted.";
                                  }
                                  else
                                  {
                                      $status=2;
                                    $message="project media not inseted";
                                  }


            }
          }
        }


            $totaldoc = count($_FILES['uploaddoc']['name']);
          /*  echo "hello1";die;*/
        for( $i=0 ; $i < $totaldoc ; $i++ ) 
        {
         $tmpFilePathdoc = $_FILES['uploaddoc']['tmp_name'][$i];
          if ($tmpFilePathdoc != "")
         
         {
           $extdoc='';
            $namedoc=$_FILES['uploaddoc']['name'][$i];
            $sourcePropertiesdoc = getimagesize($tmpFilePathdoc);
            $fileNewNamedoc = $_FILES['uploaddoc']['name'][$i];


            $folderPathdoc = "uploadFiles/";
            $extdoc = pathinfo($_FILES['uploaddoc']['name'][$i], PATHINFO_EXTENSION);
            $newFilePathdoc = $folderPathdoc.$fileNewNamedoc;
            $newFilePath1doc = $folderPathdoc.$fileNewNamedoc;
            $imageType = $sourcePropertiesdoc[2];
           
          /* echo $extdoc;*/
             if($extdoc=='pdf' || $extdoc=='txt')
             {
              
             }
             else
             {
                 $status=2;
              $message="project document not valid";
             return false;
             }
        /* die;*/
            if(move_uploaded_file($tmpFilePathdoc, $newFilePath1doc)) 
            {
            
             
               $sqlInsert12 = "INSERT INTO project_media(type_of_media,url,name,project_id)"." VALUES('$type_of_mediadoc','$newFilePathdoc','$namedoc',$last_id)";
               /*  echo $sqlInsert12;die;*/
                 
                 $exeInsert12 = mysqli_query($conn,$sqlInsert12);
                                  if($exeInsert12)
                                  {
                                    $status=1;
                                  $message="Project media inserted.";
                                  }
                                  else
                                  {
                                      $status=2;
                                    $message="project media not inseted";
                                  }
            }
          }
        }

  }



/*echo $message;
die;*/
/*die;*/


	if(!empty($last_id)){
		$status=1;
		$message="New Project Created.";
	}else{
		$status=2;
		$message="Project  did not Created.";
	}
}
$data1= array("Status"=>$status,"Message"=>$message);
echo json_encode($data1);
?>