<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

$sql = "select * from floor";
$floor_op = doQuery($sql);

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from slot where ID = $id";



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
    $floor_id = (int)Clean($_POST['floor_id']);
    $number = (int)Clean($_POST['number']);
    $status =(binary) Clean($_POST['status']);
    
    # Error [] 
    $errors = [];

    if (!validate($floor_id, 'required')) {
        $errors['floor'] = "Field Required";
    } elseif (!validate($floor_id, 'int')) {
        $errors['floor'] = "Invalid Id";
    }
   
   
    if (!validate($number, 'required')) {
        $errors['number'] = "Field Required";
    } elseif (!validate($number, 'number')) {
        $errors['number'] = "Invalid ";
    }

    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 
        $sql = "update  slot  set number = '$number' , status = '$status' , floor_id='$floor_id' where ID = $id";
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
            Messages('Dashboard / slot / Edit');
            ?>


        </ol>


        <form action="edit.php?id=<?php  echo $Raw['ID'];?>" method="post" enctype="multipart/form-data">

<div class="form-group">
    <label for="exampleInputName">floor order</label>
    <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="number" value="<?php echo $Raw['number']?>" placeholder="Enter Title">
</div>
<div class="form-group">
    <label for="exampleInputName">number of slots</label>
    <input type="checkbox" class="form-control" required id="exampleInputName" aria-describedby="" name="status" value="<?php echo $Raw['status']?>" placeholder="Enter Title">
</div>
<div class="form-group">
                <label for="exampleInputPassword">garage</label>
                <select class="form-control" name="floor_id">
                    <?php
                    while ($data = mysqli_fetch_assoc($floor_op)) {
                    ?>
                        <option value="<?php echo $data['ID']; ?>"   <?php if($Raw['floor_id'] == $data['ID']) { echo 'selected';  }?>     ><?php echo $data['number']; ?></option>
                    <?php } ?>
                </select>
            </div>

<button type="submit" class="btn btn-primary">Submit</button>
</form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	