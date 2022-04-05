  
 <?php
if($_SERVER['REQUEST_METHOD']=='POST')
{
$name=$_POST["name"];
$email=$_POST["email"];
$password=$_POST["password"];
$address=$_POST["address"];
$url=$_POST["url"];

$errors=[];


if(empty($name))
{
    $errors['name']="required";
}
if(empty($email)  )
{
    $errors['email']="required";
}
elseif( !str_contains($email,".")&& !str_contains($email,"@")&& strrpos($email,".")>strpos($email,"@"))
{
    $errors['email']="invalid format";

}


if(empty($password) )
{
    $errors['password']="required ";
}
elseif(strlen($password)!=6)
{
    $errors['password']="password must equal 6 charcters ";  
}
if(empty($address))
{
    $errors['address']="required ";
}
elseif(strlen($address)!=10)
{
    $errors['address']="address must equal 10 characters";
}
if(empty($url))
{
    $errors['url']="required";
}
elseif(!str_contains($url,"/"))
{
    $errors['url']="Invalid format";
}
if(count($errors)!=0){
    foreach($errors as $key=>$value)
    {
        echo $key. ' : ' .$value.'<br>';

    }
   }
   else
   {
     echo'valid';
   }
}
else
echo 'submit data';

?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


    <form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method='POST'>
  <label for="name">name:</label><br>
  <input type="text"  name="name" ><br>
  <label for="email">email:</label><br>
  <input type="text"  name="email" ><br><br>
  <label for="password">password:</label><br>
  <input type="password"  name="password" ><br><br>
  <label for="address">address:</label><br>
  <input type="text"  name="address" ><br><br>
  <label for="url">linkedInUrl:</label><br>
  <input type="text"  name="url" ><br><br>
  <input type="submit" value="Submit">
</form> 









</body>
</html>
