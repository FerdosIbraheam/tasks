<?php 

 if(!isset($_SESSION['loginuser'])){
      
     header("Location: ".url('/login.php')); 
     exit();
 }


?>