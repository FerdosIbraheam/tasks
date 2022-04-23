<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    require '../classes/blogClass.php';

    # Create OBJ .... 
    $blog = new blog; 

    $result = $blog->create($_POST);


    foreach ($result as $key => $value) {
        # code...
        echo '* '.$key.' : '.$value.'<br>';
    }

}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Register</h2>

        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter title">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">content</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="content" placeholder="Enter content">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">image</label>
                <input type="file" class="form-control" required id="exampleInputPassword1" name="image" placeholder="image">
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


</body>

</html>