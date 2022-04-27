<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


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

        $sql = "insert into usertype (Type) values ('$title')";
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
            Messages('Dashboard / Roles / Create');
            ?>


        </ol>


        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Title</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="title" placeholder="Enter Title">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>