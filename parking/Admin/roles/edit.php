<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from usertype where ID = $id";
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
    $title = Clean($_POST['title']);

    # Error [] 
    $errors = [];

    # Validate title ....  
    if (!validate($title, 'required')) {
        $errors['Title'] = "Field Required";
    } elseif (!validate($title, 'min', 3)) {
        $errors['Title'] = "Field Length must be >= 3 chars";
    }

    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 
        $sql = "update  usertype  set Type = '$title' where ID = $id";
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
            Messages('Dashboard / Roles / Edit');
            ?>


        </ol>


        <form action="edit.php?id=<?php  echo $Raw['ID'];?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" value="<?php echo $Raw['Type'];?>" placeholder="Enter Title">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	