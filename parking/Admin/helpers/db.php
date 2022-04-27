<?php 
   session_start();

# Create DB CONNECTION ...... 

$server = "localhost";    // 127.0.0.1 
$dbName = "parking_system"; 
$dbUser = "root"; 
$dbPassword = "";

 $con =   mysqli_connect($server,$dbUser,$dbPassword,$dbName);

   if(!$con){
       die('Error , '.mysqli_connect_error());
   }




   // sql function ..... 
function doQuery($sql){
    
   return  mysqli_query($GLOBALS['con'],$sql);

}





?>


