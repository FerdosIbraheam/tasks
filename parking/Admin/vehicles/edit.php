<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

########################################################################################################
# Fetch Roles ..... 

########################################################################################################

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from vehicle where ID = $id";
$op  = doQuery($sql);

if (mysqli_num_rows($op) == 0) {
    $message = ["Error" => 'Invalid Id'];
    $_SESSION['Message'] = $message;
    header("Location: index.php");
    exit;
} else {
    $Raw = mysqli_fetch_assoc($op);
}
########################################################################################################






// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  
    $name     = Clean($_POST['name']);
    $kind    = Clean($_POST['kind']);
    $number    = Clean($_POST['number']);
    $user_id    = $_SESSION['loginuser']['ID'];





    # Error [] 
    $errors = [];

    
    # Validate name ....  
    if (!validate($name, 'required')) {
        $errors['Name'] = "Field Required";
    } elseif (!validate($name, 'min', 3)) {
        $errors['Name'] = "Field Length must be >= 2 chars";
    }

    # Validate Password 
    if (!validate($kind, 'required')) {
        $errors['kind'] = "Field Required";
    } elseif (!validate($kind, 'min',3)) {
        $errors['kind'] = "Field Length must be >= 2chars";
    }


    # Validate Email 
    if (!validate($number, 'required')) {
        $errors['number'] = "Field Required";
    } elseif (!validate($number, 'carnumber')) {
        $errors['number'] = "Invalid Format";
    }
   


   




    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {



        if (validate($_FILES['image']['name'], 'required')) {

            $typesInfo  =  explode('/', $_FILES['image']['type']);   // convert string to array ... 
            $extension  =  strtolower(end($typesInfo));      // get last element in array .... 
    
            # Create Final Name ... 
            $FinalName = uniqid() . '.' . $extension;
    
            $disPath = 'uploads/' . $FinalName;
    
            $temPath = $_FILES['image']['tmp_name'];
    
            if (move_uploaded_file($temPath, $disPath)) {
                unlink('uploads/'.$Raw['image']);
            }
        }else{
            $FinalName = $Raw['image'];
        }


        # DB CODE ..... 
        $sql = "update  vehicle   set name = '$name' , kind = '$kind' , number = $number , user_id = $user_id , image = '$FinalName' where ID = $id";

        $op  = doQuery($sql);

        if ($op) {
            $message = ["success" => "Raw Updated"];
           
            $_SESSION['Message'] = $message;
           
            header("Location: index.php");

            exit;

        } else {
            $message = ["Error" => "Try Again"];
        }

        $_SESSION['Message'] = $message;
    }
}
########################################################################################################



require '../layouts/header.php';
require '../layouts/nav.php';
require '../layouts/sidNav.php';

?>

<main>
    <div class="container-fluid">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">


            <?php
            # Print Messages .... 
            Messages('Dashboard / Users / Edit');
            ?>


        </ol>


        <form action="edit.php?id=<?php  echo $Raw['ID'];?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" value="<?php echo $Raw['name'];?>" name="name" >
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">kind</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $Raw['kind'];?>" name="kind" >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">number</label>
                <input type="text" class="form-control" required id="exampleInputPassword1"value="<?php echo $Raw['number'];?>" name="number" >
            </div>







            <div class="form-group">
                <label for="exampleInputName">Image</label>
                <input type="file" name="image">
            </div>
            
            <img src="./uploads/<?php echo $Raw['image']; ?>" alt="UserImage"  height="70px"  width="70px"> 
            <br>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	