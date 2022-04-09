<?php



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
  <label for="title">title:</label><br>
  <input type="text"  name="title" ><br>
  <label for="content">content:</label><br>
  <input type="text"  name="content" ><br><br>
  <label for="image">image:</label>
  <input type="file" name="image" ><br><br>
 
  <input type="submit" value="Submit">



</form> 

    

</body>
</html>
<?php

function clean($input)
 {
  return trim(strip_tags(stripcslashes($input)));
 }
// function readf()
// {
    
// }
// function deletef()
// {
//     $file=fopen('info.txt','r') or die('not found');
//     file_put_contents("info.txt","") or die("can not clear file");
//    unlink('info.txt');
//    fclose($file);

   
  
// }
function FReadWriteDelete($status)
{
  
      if($status=="read")
      {  
        $file=fopen('info.txt','r') or die('not found');
          while(!feof($file))
          {
              $line=fgets($file);
              echo $line."\n";
          }
        
      }
     else if($status=="Write")
      {
            
    $file=fopen('info.txt','a') or die('not found');
        fwrite($file,$title."\n");
        fwrite($file,$content."\n");
        fwrite($file,$_FILES['image']['name']."\n");
      }
      else if($status=="delete")
      {
        $file=fopen('info.txt','w') or die('not found');
       
           
          
            
     
        file_put_contents('info.txt',"");
   
      }
      else
      {
          echo"no action on file";
      }
      fclose($file);
}


if($_SERVER['REQUEST_METHOD']=='POST')
{
$title=clean($_POST['title']);
$content=clean($_POST['content']);


$errors=[];

if(empty($title))
{
    $errors['title']="required";
}
else{
    setcookie('title',$title,time()+60,'/');

   
}


if(empty($content))
{
    $errors['content']="required";
}
else if(strlen($content)<50)
{
    $errors['content']="content length  50 or more";
}
else{
    setcookie('content',$content,time()+60,'/');
    
}
if(!empty($_FILES['image']['name']))
{
    $name=$_FILES['image']['name'];
    $tempPath=$_FILES['image']['tmp_name'];
    $size=$_FILES['image']['size'];
    $type=$_FILES['image']['type'];


    $typeinfo=explode('/',$type);
    $extension=strtolower(end($typeinfo));
$allowesextinsion=['png','jpg','jpeg'];

    if(in_array($extension,$allowesextinsion))
    {
       $finalName=time().rand().'.'.$extension;
       $destPath='uploads'. $finalName;
       if(move_uploaded_file($tempPath,$destPath))
       {
           echo 'image uploaded<br>';
       }
       else{
         $errors['image']='try upload image again<br>';
       }
    }else
    {
        $errors['image']='invalid extinsion<br>';
    }
}
else{
     $errors['image']='image required<br>';
}

if(count($errors)!=0){
    foreach($errors as $key=>$value)
    {
      echo   $key. ' : ' .$value.'<br>';

    }
   }
   else
   {
     echo'valid';
     
    


    

   }

  

   FReadWriteDelete("delete");

      
  
   // readf();
  
 
}



?>