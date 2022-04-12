<?php
require'DBConnection.php';
$id=$_GET['id'];
if(filter_var($id,FILTER_VALIDATE_INT))
{
    $sql="delete from blogmodule where id=$id";
    $op=mysqli_query($con,$sql);
    if($op)
    {
        $message='raw removed';

    }
    else{
        $message='try again'
    }
  else
  {
      $message='invalid id';
  }  
}
$_SESSION['message']=$message;
header("location: index.php");

?>