
<?php
require 'DBConnection.php';

$id=$_GET['id'] ;
$sql="select * from blogmodule where id=$id";
$op=mysqli_query($con,$sql);
$data=mysqli_fetch_assoc($op);


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
   <h1> update blog</h1>

    <form action= "<?php echo htmlspecialchars($_SERVER['PHP_SELF']).'?id='.$data['id']; ?>" method='POST' enctype="multipart/form-data">
  <label for="title">title:</label><br>
  <input type="text"  name="title" value="<?php echo $data['title']?>"><br>
  <label for="content">content:</label><br>
  <input type="text"  name="content" value="<?php echo $data['content']?>" ><br><br>
  <label for="image">image:</label>
  <input type="file" name="image" value="<?php echo $data['image']?>"><br><br>
  <label for="date">date:</label>
  <input type="text" name="date" value="<?php echo $data['date']?>" ><br><br>
  <input type="submit" value="Submit">



</form> 

    

</body>
</html>
<?php



if($_SERVER['REQUEST_METHOD']=='POST')
{
$title=clean($_POST['title']);
$content=clean($_POST['content']);
$date=clean($_POST['date']);
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
   }else
   {
       $sql="update blogmodule set title='$title' , content='$content',image='$destPath',date='$date' where id=$id";
       $op=mysqli_query($con,$sql);
       if($op)
       {
           $message='row updated';
           $_SESSION['message']=$message;
           header("location: index.php");
       }else{
           echo 'try aagain'.msqli_error($con);
       }
   
   mysqli_close($con);
    }
}
?>