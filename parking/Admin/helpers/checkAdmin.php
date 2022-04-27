<?php 
$status=false;

     if(isset($_SESSION['loginuser']) && $_SESSION['loginuser']['userType_id'] == 1){

        //header("location: ".url('')); 
        $status=true;
     }


?>