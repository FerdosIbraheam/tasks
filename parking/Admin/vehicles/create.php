<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


########################################################################################################
# Fetch Roles ..... 

########################################################################################################


// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
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
   


    

 
    if (!validate($_FILES['image']['name'], 'required')) {
        $errors['Image'] = "Field Required";
    } elseif (!validate($_FILES, 'image')) {
        $errors['Image'] = "Invalid Format";
    }


    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {

        # DB CODE ..... 

        $typesInfo  =  explode('/', $_FILES['image']['type']);   // convert string to array ... 
        $extension  =  strtolower(end($typesInfo));      // get last element in array .... 

        # Create Final Name ... 
        $FinalName = uniqid() . '.' . $extension;

        $disPath = 'uploads/' . $FinalName;

        $temPath = $_FILES['image']['tmp_name'];

        if (move_uploaded_file($temPath, $disPath)) {

           
        

            $sql = "insert into vehicle (name,kind,number,user_id,image) values ('$name','$kind',$number,$user_id,'$FinalName')";
            $op  = doQuery($sql);
           
           
        
            

            if ($op) {
                $message = ["success" => "Raw Inserted"];
            } else {
                $message = ["Error" => "Try Again"];
            }
        }else{
            $message = ["Error" => "In Uploading try Again"];
        }}
       
        $_SESSION['Message'] = $message;
       
    
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
            Messages('Dashboard / vehicles / Create');
            ?>


        </ol>
       

        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Name</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">kind</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="kind" >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">number</label>
                <input type="text" class="form-control" required id="exampleInputPassword1" name="number" >
            </div>







            <div class="form-group">
                <label for="exampleInputName">Image</label>
                <input type="file" name="image">
            </div>



            <button type="submit" class="btn btn-primary">Submit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>