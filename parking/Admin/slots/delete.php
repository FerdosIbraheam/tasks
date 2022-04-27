<?php 
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

# Fetch Id .... 
$id = $_GET['id']; 

# Validate Id .... 

if(!validate($id,'int')){
    $message = ["Error" => "Invalid Id"];
}else{

    $sql = "delete from slot where ID = $id"; 

    $op = doQuery($sql); 

    if($op){
        $message = ["Success" => "Raw Removed"];
    }else{
        $message = ["Error" => "Error Try Again"];
    }

}

# Set Session ... 
$_SESSION['Message'] = $message; 

header("Location: index.php"); 




?>