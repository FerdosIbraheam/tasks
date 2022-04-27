<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from garage where ID = $id";

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

    # FETCH && CLEAN DATA .... 
    $name = Clean($_POST['name']);
    $address = Clean($_POST['address']);
    $numberOfFloors =(int) Clean($_POST['numberOfFloors']);

    # Error [] 
    $errors = [];

    # Validate title ....  
    if (!validate($name, 'required')) {
        $errors['name'] = "Field Required";
    } elseif (!validate($name, 'min', 3)) {
        $errors['name'] = "Field Length must be >= 3 chars";
    }
    if (!validate($address, 'required')) {
        $errors['address'] = "Field Required";
    } elseif (!validate($address, 'min', 10)) {
        $errors['address'] = "Field Length must be >= 10 chars";
    }
    if (!validate($numberOfFloors, 'required')) {
        $errors['numberOfFloors'] = "Field Required";
    } elseif (!validate($numberOfFloors, 'number')) {
        $errors['numberOfFloors'] = "Invalid ";
    }

    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 
        $sql = "update  garage  set name = '$name' , address = '$address', numberOfFloors = '$numberOfFloors'where ID = $id";
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
            Messages('Dashboard / garage / Edit');
            ?>


        </ol>


        <form action="edit.php?id=<?php  echo $Raw['ID'];?>" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="exampleInputName">name</label>
    <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name" value="<?php echo $Raw['name']?>" placeholder="Enter Title">
</div>
<div class="form-group">
    <label for="exampleInputName">address</label>
    <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="address" value="<?php echo $Raw['address']?>" placeholder="Enter Title">
</div>
<div class="form-group">
    <label for="exampleInputName">number of floors</label>
    <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="numberOfFloors" value="<?php echo $Raw['numberOfFloors']?>" placeholder="Enter Title">
</div>

<button type="submit" class="btn btn-primary">Submit</button>
</form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	