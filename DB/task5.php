<?php

require('DBConnection.php');

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
  <label for="date">date:</label>
  <input type="text" name="date" placeholder="dd/mm/yyyy" ><br><br>
  <input type="submit" value="Submit">



</form> 

    

</body>
</html>
<?php




function is_date_valid($date, $format = 'd/m/y'){
       $dt= strtotime($date);
       $newformat=date('d/m/y',$dt);

  
   
       $dateArr=explode('/',$newformat);
       
       if(checkdate($dateArr[0],$dateArr[1],$dateArr[2]))
       {
           return true;
       }
       else
       {
           return false;
       }

   

   
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
$title=clean($_POST['title']);
$content=clean($_POST['content']);
$date=clean($_POST['date']);


$errors=[];

if(empty($title))
{
    $errors['title']="required";
}



if(empty($content))
{
    $errors['content']="required";
}
else if(strlen($content)<50)
{
    $errors['content']="content length  50 or more";
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
       $destPath='../uploads'. $finalName;
       $GLOBALS['destpath']=$destPath;
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
if(empty($date))
{
    $errors['date']="required";
}
else if(!is_date_valid($date))
{
    $errors['date']="enter date in correct format";
}

if(count($errors)!=0){
    foreach($errors as $key=>$value)
    {
      echo   $key. ' : ' .$value.'<br>';

    }
   }
   else
   {
     
     $sql="insert into blogmodule (title,content,image,date) values (`$title`,`$content`,`$destPath`,`$date`)";
    
      $op=mysqli_query($con,$sql);
      if($op)
      {
          echo 'data inserted';
          
      }
      else
      {
          echo "try again".mysqli_error($con);
      }

    mysqli_close($con);

   }
  
 
}



?> 