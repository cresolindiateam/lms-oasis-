<?php

// session_start();



require 'vendor/autoload.php'; // Include Composer autoload file

use PhpOffice\PhpSpreadsheet\Reader\Xlsx; 

function importExcelData($file,$conn)
{

    $mimes = ['text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if (in_array($file["type"], $mimes)) {

        $uploadFilePath = 'uploadExcel/'.basename($file['name']);



        if (move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
       

            $reader = new Xlsx(); 


             $spreadsheet = $reader->load($uploadFilePath); 
           

            $worksheet = $spreadsheet->getActiveSheet();  
            $worksheet_arr = $worksheet->toArray(); 


 
            // Remove header row 
            unset($worksheet_arr[0]); 


              foreach($worksheet_arr as $row)
              { 
           



                $name = $row[0]; 
                $email = $row[1]; 
                 $phone_number = $row[2]; 
                $leadsource = $row[3]; 
                $status = $row[4]; 
                $budget = $row[5];
                $interestedfor = $row[6]; 
 
                // Check whether member already exists in the database with the same email 
                


// echo "SELECT id FROM leads WHERE email = '".$email."'";
                $prevQuery = "SELECT id FROM leads WHERE email = '".$email."' and lead_hidden_status=0"; 
                $prevResult = $conn->query($prevQuery); 




                if($prevResult->num_rows > 0){




                    // Update member data in the database 
                    $conn->query("UPDATE leads SET name = '".$name."', email = '".$email."', lead_source = '".$leadsource."', lead_status = '".$status."', budget = '".$budget."', interested_for = '".$budget."',client_id = '".$_SESSION['proj_info_id']."'   WHERE email = '".$email."'"); 
                }else{ 



                    // Insert member data in the database 
                    $conn->query("INSERT INTO leads (name,email,lead_source,lead_status,budget,interested_for,client_id) VALUES ('".$name."', '".$email."', '".$leadsource."', '".$status."', '".$budget."', '".$interested_for."', '".$_SESSION['proj_info_id']."')"); 
                } 
             
            } 

header('Location: leads_list.php');

return "success";


        } else {
            return "Error uploading the file.";
        }

      
    } else {
        return "Sorry, File type is not allowed. Only Excel file.";
    }
}
?>






