<?php

########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';
$user_ID    = $_SESSION['loginuser']['ID'];
# Fetch Data 
$sql = "select user_slot_reservation.* , vehicle.name as vehiclename,slot.number  from user_slot_reservation inner join vehicle on vehicle.user_id = $user_ID and user_slot_reservation.vehicle_id=vehicle.ID  inner join slot on user_slot_reservation.slot_id=slot.ID " ;
$op  = doQuery($sql);
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
            Messages('Dashboard / reservation / Display');
            ?>

        </ol>









        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Roles Data
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>date</th>
                                <th>start time</th>
                                <th>end time</th>
                                <th>vehicle</th>
                                <th>slot number</th>
                                <th>payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                            <th>ID</th>
                                <th>date</th>
                                <th>start time</th>
                                <th>end time</th>
                                <th>vehicle</th>
                                <th>slot number</th>
                                <th>payment</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>


                            <?php
                            # LOOP .... 
                            $i = 0;
                            while ($raw = mysqli_fetch_assoc($op)) {
                            ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td><?php echo $raw['date']; ?></td>
                                    <td><?php echo $raw['fromOclock']; ?></td>
                                    <td><?php echo $raw['toOclock']; ?></td>
                                    <td><?php echo $raw['vehiclename']; ?></td>
                                    <td><?php echo $raw['number']; ?></td>
                                    <td><?php echo $raw['payment_amount']; ?></td>
                                    <td>

                                        <a href='delete.php?id=<?php echo $raw['ID']; ?>' class='btn btn-danger m-r-1em'>Delete</a>

                                        <a href='edit.php?id=<?php echo $raw['ID']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
                                    </td>

                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php

require '../layouts/footer.php';
?>