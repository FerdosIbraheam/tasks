
<!DOCTYPE html>
<html>

<head>
    <title>PDO - Read Records - PHP CRUD Tutorial</title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }

        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }
    </style>

</head>

<body>

    <!-- container -->
    <div class="container">


        <div class="page-header">
            <h1>Read blog </h1>
            <br>
        


        </div>

        <a href="create.php">+ Account</a>   ||    <a href="logout.php">LogOut</a>

        <table class='table table-hover table-responsive table-bordered'>
            <!-- creating our table heading -->
            <tr>
                <th>ID</th>
                <th>title</th>
                <th>content</th>
                <th>image</th>
                <th>action</th>
            </tr>

       <?php 

          require '../classes/blogClass.php';

            # Create oBJ .... 
            $blog = new blog; 
            $result = $blog->show();
          
           while($raw = mysqli_fetch_assoc($result)){


       ?>
            <tr>
                   <td><?php echo $raw['id'];?></td>
                   <td><?php echo $raw['title'];?></td>
                   <td><?php echo $raw['content'];?></td>
                   <td><img src="uploads/<?php echo $raw['image'];?>" legth="50px" width="30px"/></td>
        
                <td>
 
                <a href='delete.php?id=<?php echo $raw['id'];?>' class='btn btn-danger m-r-1em'>Delete</a>

        

                    <a href='update.php?id=<?php echo $raw['id'];?>' class='btn btn-primary m-r-1em'>update</a>
                </td>
            </tr>

       <?php } ?>
            <!-- end table -->
        </table>

    </div>
    <!-- end .container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- confirm delete record will be here -->

</body>

</html>