<?php

session_start();
function clean($input)
{
 return trim(strip_tags(stripcslashes($input)));
}
$server="localhost";
$dbuser="root";
$dbpassword="";
$dbname="blog";
$con=mysqli_connect($server,$dbuser,$dbpassword,$dbname);
if(!$con)
{
   echo 'Error,'.mysqli_connect_error(); 
}


?>