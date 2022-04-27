<?php

########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

# Fetch Data 
$sql = "select slot.* , floor.number as floorNumber from slot inner join floor on slot.floor_id = floor.ID";
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
            Messages('Dashboard / slot / Display');
            ?>

        </ol>



        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table mr-1"></i>
                Category Data
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>slot number</th>
                                <th>status</th>
                                <th>floor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>slot number</th>
                                <th>status</th>
                                <th>floor</th>
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
                                    <td><?php echo $raw['number']; ?></td>
                                    <td><?php echo $raw['status']; ?></td>
                                    <td><?php echo $raw['floorNumber']; ?></td>
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