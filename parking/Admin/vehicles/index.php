<?php

########################################################################################################
require '../helpers/db.php';
require '../helpers/functions.php';

# Fetch Data 
$sql = "select vehicle.* , user.name as username from vehicle inner join user on vehicle.user_id = user.ID";
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
            Messages('Dashboard / Roles / Display');
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
                                <th>Name</th>
                                <th>kind</th>
                                <th>number</th>
                                <th>Image</th>
                                <th>added by</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>kind</th>
                                <th>number</th>
                                <th>Image</th>
                                <th>added by</th>
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
                                    <td><?php echo $raw['name']; ?></td>
                                    <td><?php echo $raw['kind']; ?></td>
                                    <td><?php echo $raw['number']; ?></td>
                                    <td> <img src="./uploads/<?php echo $raw['image']; ?>" alt="UserImage"  height="70px"  width="70px">  </td>
                                    <td><?php echo $raw['username']; ?></td>
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