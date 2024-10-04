<div class="orders-table">
    <table style="width:100%" class="table-bordered text-center">
        <thead>
            <tr class="py-2">
                <th class="py-2">ID</th>
                <th class="py-2">Tracking Number</th>
                <th class="py-2">Price</th>
                <th class="py-2">Date</th>
                <th class="py-2">View</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $orders = getOrders();

            if (mysqli_num_rows($orders) > 0) {
                foreach ($orders as $item) { ?>

                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['tracking_no']; ?></td>
                        <td><?php echo $item['total_price']; ?></td>
                        <td><?php echo $item['created_at']; ?></td>
                        <td><a href="my-account.php?source=view-order&t=<?php echo $item['tracking_no']; ?>" class="btn btn-primary my-2">View Details</a></td>
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