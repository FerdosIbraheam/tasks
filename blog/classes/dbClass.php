<?php
class db{
var $server="localhost";
var $dbName="blogCRUID";
var $dbUser="root";
var $dbPassword = "";  

var $con;

function __construct()
{
   $this->con=mysqli_connect($this->server,$this->dbUser,$this->dbPassword,$this->dbName);
    if(!$this->con){
        die("Error Try Again,Error:".mysqli_connect_error());
    }
}

function doQuery($sql){
    return mysqli_query($this->con,$sql);
}

function __destruct()
{
    mysqli_close($this->con);
}


}





?>