
<?php
/*function db_connect(){
 /*$server = "p3nlmysql31plsk.secureserver.net";
$user = "realstate";
$pass = "mQ!8sj87";
$database= "realstate";*/

/*$servername = "p3nlmysql31plsk.secureserver.net";
$username = "grandthum";*/
/*$password = "~x3xKp84";*/
/*$dbname = "bhutani_grandthum";*/

/*$servername="127.0.0.1";
$username="newrealstate_LeadManagementUser";
$password="eNUt@F$Yo0KY";
$dbname = "newrealstate_LeadManagementDB";*/

//ajay
// $servername="localhost";
// $username="newleaduser";
// $password="tQc#gXaD6F&y";
// $dbname = "oasisproperty_LeadManagementDB";

$servername="localhost";
$username="root";
$password="";
$dbname = "oasisproperty_LeadManagementDB";

      // Create connection
  /*  $conn= mysqli_connect($server,$user,$pass,$database);
    
    return $conn;
    if(!$conn){
       die("Connection failed: " . mysqli_connect_error());
    }
*/

/* $server = "p3nlmysql31plsk.secureserver.net";
$user = "lead_management_user";
$pass = "Bugu67%7";
$database= "lead_management_db";*/

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);


// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}








?>
