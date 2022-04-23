
       <?php 

require '../classes/blogClass.php';

  # Create oBJ .... 
  $blog = new blog; 
  $result = $blog->delete();

  if($result){
      echo"deleted";
  }




?>