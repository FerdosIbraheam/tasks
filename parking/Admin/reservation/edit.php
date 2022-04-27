<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

########################################################################################################
# Fetch Roles ..... 

########################################################################################################

$id = $_GET['id'];
$user_id    = $_SESSION['loginuser']['ID'];
# Fetch Raw Data .... 
$sql = "select * from user_slot_reservation where ID = $id";
$op  = doQuery($sql);
$sql = "select * from slot where status=0";
$slot_op = doQuery($sql);

$sql = "select * from vehicle where user_id=$user_id";
$vehicle_op = doQuery($sql);

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

  

    $date     = Clean($_POST['date']);
    $fromOclock    = Clean($_POST['fromOclock']);
    $toOclock   = Clean($_POST['toOclock']);
    $payment_amount=Clean($_POST['payment_amount']);
    $slot_id   = Clean($_POST['slot_id']);
    $vehicle_id   = Clean($_POST['vehicle_id']);





  
    $errors = [];

 
    if (!validate( $date, 'required')) {
        $errors['date'] = "Field Required";
    } elseif (!validate($date, 'date')) {
        $errors['date'] = "Field Length must be >= 2 chars";
    }elseif (!validate($date, 'DateNext')) {
        $errors['date'] = "date should be larger than now";
    }

    # Validate Password 
    if (!validate($fromOclock, 'required')) {
        $errors['start_hour'] = "Field Required";
    } elseif (!validate($fromOclock,'time')) {
        $errors['start_hour'] = "invalid time";
    }


    if (!validate($toOclock, 'required')) {
        $errors['end_hour'] = "Field Required";
    } elseif (!validate($toOclock,'time')) {
        $errors['end_hour'] = "invalid time";
    }
    if(!isgreater($toOclock,$fromOclock))
    {
        $errors['time'] = "end time should be greater than end time";
    }
   
    $slot_id  = Clean($_POST['slot_id']);
    if (!validate($slot_id, 'required')) {
        $errors['slot_id'] = "Field Required";
    } elseif (!validate($slot_id, 'int')) {
        $errors['slot_id'] = "Invalid Id";
    }
    $vehicle_id  = Clean($_POST['vehicle_id']);
    if (!validate($vehicle_id, 'required')) {
        $errors['vehicle_id'] = "Field Required";
    } elseif (!validate($vehicle_id, 'int')) {
        $errors['vehicle_id'] = "Invalid Id";
    }
    $payment_amount  = Clean($_POST['payment_amount']);
    if (!validate($payment_amount, 'payment_amount')) {
        $errors['payment_amount'] = "Field Required";
    } elseif (!validate($payment_amount, 'number')) {
        $errors['payment_amount'] = "Invalid ";
    }
   


   




    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
    } else {


        $sql = "update  user_slot_reservation   set date = '$date' , fromOclock = '$fromOclock' , toOclock = '$toOclock' , payment_amount = $payment_amount , slot_id = $slot_id ,vehicle_id=$vehicle_id where ID = $id";

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
            Messages('Dashboard / reservation / Edit');
            ?>


        </ol>


        <form action="edit.php?id=<?php  echo $Raw['ID'];?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
                <label for="exampleInputName">date</label>
                <input type="text" class="form-control" required id="exampleInputName" aria-describedby="" value="<?php echo $Raw['date'];?>" name="date" placeholder="Enter Name">
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">start time</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $Raw['fromOclock'];?>" name="fromOclock" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">end time</label>
                <input type="text" class="form-control" required id="exampleInputPassword1"value="<?php echo $Raw['toOclock'];?>" name="toOclock" >
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">payment</label>
                <input type="text" class="form-control" required id="exampleInputPassword1"value="<?php echo $Raw['payment_amount'];?>" name="payment_amount" >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">slot</label>
                <select class="form-control" name="slot_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($slot_op)) {
                    ?>
                        <option value="<?php echo $raw['ID']; ?>"   <?php if($Raw['slot_id'] == $raw['ID']) { echo 'selected';  }?>     ><?php echo $raw['number']; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="exampleInputPassword">vehicle</label>
                <select class="form-control" name="vehicle_id">
                    <?php
                    while ($rraw = mysqli_fetch_assoc($vehicle_op)) {
                    ?>
                        <option value="<?php echo $rraw['ID']; ?>"   <?php if($Raw['vehicle_id'] == $rraw['ID']) { echo 'selected';  }?>     ><?php echo $rraw['kind']; ?></option>
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


	