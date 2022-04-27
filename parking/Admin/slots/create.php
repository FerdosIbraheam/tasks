<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

$sql = "select * from floor";
$floor_op = doQuery($sql);
// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
    $floor_id = Clean($_POST['floor_id']);
    $number = Clean($_POST['number']);
  
    
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
$status=0;
        $sql = "insert into slot (number,status,floor_id) values ('$number',$status,'$floor_id')";
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
            Messages('Dashboard / slot / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">number</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="number" placeholder="Enter Title">
            </div>
     
            
            <div class="form-group">
                <label for="exampleInputPassword">floor</label>
                <select class="form-control" name="floor_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($floor_op)) {
                    ?>
                        <option value="<?php echo $raw['ID']; ?>"><?php echo $raw['number']; ?></option>
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