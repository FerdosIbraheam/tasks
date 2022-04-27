<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

$sql = "select * from garage";
$garage_op = doQuery($sql);
// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
    $garage_id = (int)Clean($_POST['garage_id']);
    $number = (int)Clean($_POST['number']);
    $numberOfslots =(int) Clean($_POST['numberOfslots']);
    
    # Error [] 
    $errors = [];

    if (!validate($garage_id, 'required')) {
        $errors['garage'] = "Field Required";
    } elseif (!validate($garage_id, 'int')) {
        $errors['garage'] = "Invalid Id";
    }

    if (!validate($numberOfslots, 'required')) {
        $errors['numberOfslots'] = "Field Required";
    } elseif (!validate($numberOfslots, 'number')) {
        $errors['numberOfslots'] = "Invalid ";
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

        $sql = "insert into floor (number,numberOfslots,garage_id) values ('$number','$numberOfslots','$garage_id')";
        $op  = doQuery($sql);

        if ($op) {
            $message = ["success" => "Raw Inserted"];
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
            Messages('Dashboard / garage / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">floor order</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="number" placeholder="Enter Title">
            </div>
     
            <div class="form-group">
                <label for="exampleInputName">number of slots</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="numberOfslots" placeholder="Enter Title">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">garage</label>
                <select class="form-control" name="garage_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($garage_op)) {
                    ?>
                        <option value="<?php echo $raw['ID']; ?>"><?php echo $raw['name']; ?></option>
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