<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';
require '../helpers/checkAdmin.php';

########################################################################################################
# Fetch Roles ..... 
$sql = "select * from usertype";
$roles_op = doQuery($sql);
########################################################################################################

$id = $_GET['id'];
# Fetch Raw Data .... 
$sql = "select * from user where ID = $id";
$op  = doQuery($sql);
$sql1 = "select * from userdetails where user_id = $id";
$opdetails  = doQuery($sql1);

if (mysqli_num_rows($op) == 0) {
    $message = ["Error" => 'Invalid Id'];
    $_SESSION['Message'] = $message;
    header("Location: ../index.php");
    exit;
} else {
    $Raw = mysqli_fetch_assoc($op);
    $RaW = mysqli_fetch_assoc($opdetails);
}
########################################################################################################






// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  
    # FETCH && CLEAN DATA .... 
    $name     = Clean($_POST['name']);
    $email    = Clean($_POST['email']);
    
    $phone    = Clean($_POST['phone']);
    $address    = Clean($_POST['address']);
    $licence_num    = Clean($_POST['licence_num']);
    $national_id    = Clean($_POST['national_id']);





    # Error [] 
    $errors = [];

   
    if (!validate($name, 'required')) {
        $errors['Name'] = "Field Required";
    } elseif (!validate($name, 'min', 3)) {
        $errors['Name'] = "Field Length must be >= 2 chars";
    }


   


    # Validate Email 
    if (!validate($email, 'required')) {
        $errors['Email'] = "Field Required";
    } elseif (!validate($email, 'email')) {
        $errors['Email'] = "Invalid Format";
    }
    if($status){
    $role_id  = Clean($_POST['role_id']);
    if (!validate($role_id, 'required')) {
        $errors['Role'] = "Field Required";
    } elseif (!validate($role_id, 'int')) {
        $errors['Role'] = "Invalid Id";
    }
    }

    # Validate phone 
    if (!validate($phone, 'required')) {
        $errors['phone'] = "Field Required";
    } elseif (!validate($phone, 'phone')) {
        $errors['phone'] = "InValid Format";
    }
    if (!validate($address, 'required')) {
        $errors['address'] = "Field Required";
    } elseif (!validate($address, 'min', 10)) {
        $errors['address'] = "Field Length must be >= 10 chars";







    }
    if (!validate($licence_num, 'required')) {
        $errors['licence'] = "Field Required";
    } elseif (!validate($licence_num, 'num')) {
        $errors['licence'] = "InValid Format";
    }
    if (!validate($national_id, 'required')) {
        $errors['national'] = "Field Required";
    } elseif (!validate($national_id, 'num')) {
        $errors['national'] = "InValid Format";
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

        if($status){
            
        # DB CODE ..... 
        $sql = "update  user   set name = '$name' , email = '$email' , phone = '$phone' , userType_id = $role_id , image = '$FinalName' where ID = $id";
        
        $op  = doQuery($sql);
        }
        else{
            $usern=2;
            $sql = "update  user   set name = '$name' , email = '$email' , phone = '$phone' , userType_id = $usern , image = '$FinalName' where ID = $id";
            $op  = doQuery($sql);
            
            $sql2 = "update  userdetails   set address = '$address' , licence_num = $licence_num , national_Id = $national_id , user_id = $id  where user_id = $id";
            $details_op=doQuery($sql2);
           
            if ($op&&$details_op) {
                $message = ["success" => "Raw Updated"];
               
                $_SESSION['Message'] = $message;
               
                header("Location: ../index.php");
    
                exit;

        }
      
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
}}
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
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" name="name"  value="<?php echo $Raw['name'];?>"  placeholder="Enter Name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">Email address</label>
                <input type="email" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="email"  value="<?php echo $Raw['email'];?>"  placeholder="Enter email">
            </div>




            <div class="form-group">
                <label for="exampleInputEmail">Phone</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="phone" value="<?php echo $Raw['phone'];?>" placeholder="Enter phone">
            </div>


          
<?php   
         if($status){?>
            <div class="form-group">
                <label for="exampleInputPassword">Role</label>

                <select class="form-control" name="role_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($roles_op)) {
                    ?>
                        <option value="<?php echo $raw['ID']; ?>"><?php echo $raw['Type']; ?></option>
                    <?php } ?>
                </select>
            </div>

<?php }else{ ?>
    <div class="form-group">

<label for="exampleInputEmail">address</label>
<input type="text" class="form-control" required id="exampleInputEmail1" value="<?php echo $RaW['address']; ?>" aria-describedby="emailHelp" name="address" placeholder="Enter phone">
 </div>

 <div class="form-group">

 <label for="exampleInputEmail">licence number</label>
 <input type="text" class="form-control" required id="exampleInputEmail1" value="<?php echo $RaW['licence_num']; ?>" aria-describedby="emailHelp" name="licence_num" placeholder="Enter phone">
 </div>

 <div class="form-group">

 <label for="exampleInputEmail">national_id</label>
 <input type="text" class="form-control" required id="exampleInputEmail1" value="<?php echo $RaW['national_Id']; ?> " aria-describedby="emailHelp" name="national_id" placeholder="Enter phone">
 </div>
<?php } ?>


            <div class="form-group">
                <label for="exampleInputName">Image</label>
                <input type="file" name="image">
            </div>
            
            <img src="./uploads/<?php echo $Raw['image']; ?>" alt="UserImage"  height="70px"  width="70px"> 
            <br>


            <button type="submit" class="btn btn-primary">Edit</button>
        </form>



    </div>
</main>

<?php

require '../layouts/footer.php';
?>


	