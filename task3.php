  
 <?php

function clean($input)
 {
  return trim(strip_tags(stripcslashes($input)));
 }
function upload()
{

 if(isset($_FILES['cv']))
{
    $name=$_FILES['cv']['name'];
    $tempPath=$_FILES['cv']['tmp_name'];
    $size=$_FILES['cv']['size'];
    $type=$_FILES['cv']['type'];


    $typeinfo=explode('/',$type);
    $extension=strtolower(end($typeinfo));
$allowesextinsion=['pdf'];

    if(in_array($extension,$allowesextinsion))
    {
       $finalName=time().rand().'.'.$extension;
       $destPath='uploads'. $finalName;
       if(move_uploaded_file($tempPath,$destPath))
       {
           echo'cv uploaded<br>';
       }
       else{
           echo 'try upload cv again<br>';
       }
    }else
    {
        echo 'invalid extinsion<br>';
    }
}
else{
    echo 'cv required<br>';
}
}

 function checkemail($email)
{
    $status=true;
    if(empty($email)  )
    {
     echo"required";
    }
   elseif( !filter_var($email,FILTER_VALIDATE_EMAIL))
    {
        $email=filter_var($email,FILTER_SANITIZE_EMAIL);
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
         $status=false;
        }

 
    }
    return  $status;
}


if($_SERVER['REQUEST_METHOD']=='POST')
{
$name=clean($_POST["name"]);
$email=clean($_POST["email"]);
$password=clean($_POST["password"]);
$address=clean($_POST["address"]);
$gender=(bool)$_POST['gender'];//Warning: Undefined array key "gender" in C:\marian\htdocs\m1\task3.php on line 71
$url=clean($_POST["url"]);



$errors=[];


if(empty($name))
{
    $errors['name']="required";
}
if(empty($email)  )
{
    $errors['email']="required";
}
elseif(!checkemail($email))
{
    $errors['email']="invalid format";

}


if(empty($password) )
{
    $errors['password']="required ";
}
elseif(strlen($password)<6)
{
    $errors['password']="password must equal 6 charcters ";  
}
if(empty($address))
{
    $errors['address']="required ";
}
else if(strlen($address)<10)
{
    $errors['address']="address must equal 10 characters";
}
if(empty($gender))
{
    $errors['gender']="required ";
}
else if(!filter_var($gender,FILTER_VALIDATE_BOOL))
{
    $errors['gender']="gender must be female or male";
}
if(empty($url))
{
    $errors['url']="required";
}
else if(!filter_var($url,FILTER_VALIDATE_URL))
{
    $errors['url']="Invalid format";
}
upload();

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


    <form action= "<?php echo $_SERVER['PHP_SELF']; ?>" method='POST' enctype="multipart/form-data">
  <label for="name">name:</label><br>
  <input type="text"  name="name" ><br>
  <label for="email">email:</label><br>
  <input type="text"  name="email" ><br><br>
  <label for="password">password:</label><br>
  <input type="password"  name="password" ><br><br>
  <label for="address">address:</label><br>
  <input type="text"  name="address" ><br><br>
  <label for="gender">gender:</label><br>
  <input type="radio"  name="gender" value="male">
  <label for="male">male</label><br>
  <input type="radio"  name="gender" value="female">
  <label for="female">female</label><br><br>
  <label for="url">linkedInUrl:</label><br>
  <input type="text" name="url" ><br><br>
  <label for="cv">cv:</label><br>
  <input type="file" name="cv" ><br><br>
  <input type="submit" value="Submit">
</form> 









</body>
</html>
