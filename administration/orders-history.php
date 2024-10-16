<?php
include 'includes/header.php';
include '../middleware/adminMiddleware.php';
?>

<?php 

// Έλεγχος αν η συνεδρία είναι ενεργή και ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['user_role'])) {
    // Αν δεν είναι συνδεδεμένος, ανακατεύθυνση στη σελίδα login
    header("Location: ../login.php");
    exit();
}

?>

<div class="container-lg">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h4 class="text-white">Orders</h4>
                        <a href="orders.php" class="btn btn-warning mb-0"><i class="fa fa-reply me-2"></i>Back</a>
                    </div>

                </div>
                <div class="card-body" id="">
                    <table class="table table-bordered table-striped text-center">
                        <thead>
                            <tr class="py-2">
                                <th class="py-2">ID</th>
                                <th class="py-2">User</th>
                                <th class="py-2">Tracking Number</th>
                                <th class="py-2">Price</th>
                                <th class="py-2">Date</th>
                                <th class="py-2">View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = getOrderHistory();

                            if (mysqli_num_rows($orders) > 0) {
                                foreach ($orders as $item) { ?>

                                    <tr class="align-middle">
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo $item['name']; ?></td>
                                        <td><?php echo $item['tracking_no']; ?></td>
                                        <td><?php echo $item['total_price']; ?></td>
                                        <td><?php echo $item['created_at']; ?></td>
                                        <td><a href="view-order.php?t=<?php echo $item['tracking_no']; ?>"
                                                class="btn btn-primary my-2">View Details</a></td>
                                    </tr>

                                <?php }
                            } else {
                                ?>

                                <tr>
                                    <td colspan="5">No orders yet</td>
                                </tr>


                            <?php }

                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>