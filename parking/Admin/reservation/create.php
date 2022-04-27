<?php
########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';


########################################################################################################
# Fetch Roles ..... 

########################################################################################################
$user_id    = $_SESSION['loginuser']['ID'];


$sql = "select * from slot where status=0";
$slot_op = doQuery($sql);

$sql = "select * from vehicle where user_id=$user_id";
$vehicle_op = doQuery($sql);
// LOGIC .... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    # FETCH && CLEAN DATA .... 
    $date     = Clean($_POST['date']);
    $fromOclock    = Clean($_POST['fromOclock']);
    $toOclock   = Clean($_POST['toOclock']);
    $payment_amount=Clean($_POST['payment_amount']);
    $slot_id   = Clean($_POST['slot_id']);
    $vehicle_id   = Clean($_POST['vehicle_id']);
    



    # Error [] 
    $errors = [];
   
    # Validate name ....  
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
        $errors['payment_amount'] = "Invalid Id";
    }

    

 
   


    # Check Errors .... 
    if (count($errors) > 0) {
        $_SESSION['Message'] = $errors;
        
    } else {

     

   

        

            $sql = "insert into user_slot_reservation (date,fromOclock,toOclock,payment_amount,slot_id,vehicle_id) values ('$date','$fromOclock','$toOclock','$payment_amount',$slot_id,$vehicle_id)";
           
            $op  = doQuery($sql);
            $last_id = mysqli_insert_id($con);
            $sql = "select slot.*  from slot inner join user_slot_reservation on user_slot_reservation.slot_id = slot.ID
                    where user_slot_reservation.ID=$last_id";
            $slotagain_op = doQuery($sql);


            
            
           
           
        
            

            if ($slotagain_op) {
                $data=mysqli_fetch_assoc($slotagain_op);
                $statuss=1;

                $sql="update `slot` set status='$statuss' where ID=".$data['ID'];
                $status_op = doQuery($sql);
                if($status_op )
                {
                    $message = ["success" => "status updated"]; 
                }
            }
                
            } if($op){
                $message = ["success" => "Raw Inserted"];
            } else {
                $message = ["Error" => "Try Again"];
                
            }
        
       
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
            if(!$slot_op)
            {
               
                Messages('no slot for reserving');
            }else{
            Messages('Dashboard / vehicles / Create');
            }
            ?>


        </ol>
       

        <form action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="exampleInputName">Date</label>
                <input type="date" class="form-control" required id="exampleInputName" aria-describedby="" name="date" >
            </div>


            <div class="form-group">
                <label for="exampleInputEmail">from hour</label>
                <input type="text" class="form-control" required id="exampleInputEmail1" aria-describedby="emailHelp" name="fromOclock" >
            </div>

            <div class="form-group">
                <label for="exampleInputPassword">to hour</label>
                <input type="text" class="form-control" required id="exampleInputPassword1" name="toOclock" >
            </div>


            <div class="form-group">
                <label for="exampleInputPassword">payment</label>
                <input type="text" class="form-control" required id="exampleInputPassword1" name="payment_amount" placeholder="Password">
            </div>



            <div class="form-group">
                <label for="exampleInputPassword">slot</label>
                <select class="form-control" name="slot_id">
                    <?php
                    while ($raw = mysqli_fetch_assoc($slot_op)) {
                    ?>
                        <option value="<?php echo $raw['ID']; ?>"><?php echo $raw['number']; ?></option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="exampleInputPassword">vehicle</label>
                <select class="form-control" name="vehicle_id">
                    <?php
                    while ($Raw = mysqli_fetch_assoc($vehicle_op)) {
                    ?>
                        <option value="<?php echo $Raw['ID']; ?>"><?php echo $Raw['name']; ?></option>
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