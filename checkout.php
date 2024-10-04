<?php ob_start(); 
session_start(); // Ξεκινάμε τη συνεδρία

// Έλεγχος αν ο χρήστης δεν είναι συνδεδεμένος
if (!isset($_SESSION['auth']) || empty($_SESSION['auth'])) {
    header("Location: login-register.php");
    exit(); // Σταματάμε την εκτέλεση του υπόλοιπου κώδικα
}
?>

<?php include 'functions/userfunctions.php'; ?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/navigation.php'; ?>
<?php include 'authenticate.php'; ?>

<section id="checkout">
    <div class="container-lg">
        <a href="cart.php" class="text-decoration-none btn btn-warning mb-5"><i
                class="fa fa-reply me-2"></i>Back</a>
        <form action="functions/placeorder.php" method="POST">
            <div class="row">
                <div class="col-md-7">
                    <h5 class="mb-3">Basic Details</h5>
                    <div class="card shadow-lg">
                        <div class="card-body primary">

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Ονομα</label>
                                    <input type="text" name="name" class="form-control form-control-lg border-primary"
                                        placeholder="Όνομα" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold ">Επώνυμο</label>
                                    <input type="text" name="lastname" class="form-control form-control-lg border-primary"
                                        placeholder="Επώνυμο" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold  mt-3">Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg border-primary"
                                        placeholder="example@email.com" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3 fw-bold">Διεύθυνση</label>
                                    <input type="text" name="address"
                                        class="form-control form-control-lg border-primary"
                                        placeholder="Διεύθυνση" required></input>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label mt-3 fw-bold">Τηλέφωνο</label>
                                    <input type="tel" name="phone" class="form-control form-control-lg border-primary"
                                        placeholder="Τηλέφωνο" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label mt-3 fw-bold">Ταχυδρομικός Κωδικός</label>
                                    <input type="text" name="pincode"
                                        class="form-control form-control-lg border-primary"
                                        placeholder="Ταχυδρομικός Κωδικός" required>
                                </div>

                                <div class="col-md-6">
                                    <input type="hidden" name="payment_mode" value="COD">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <h5 class="mb-3">Order Details</h5>
                    <table class="table table-bordered table-hover shadow">
                        <thead class="table-primary">
                            <tr class="text-center">
                                <th>Image</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $items = getCartItems();
                            $totalPrice = 0;
                            if (mysqli_num_rows($items) > 0) {
                                foreach ($items as $citem) {
                                    $totalPrice += $citem['selling_price'] * $citem['prod_qty']; ?>
                                    <tr class="product_data align-items-center">
                                        <td class="align-middle text-center">
                                            <img data-src="uploads/<?php echo $citem['item_image']; ?>" class="lazy" alt="Image" width="100px">
                                        </td>
                                        <td class="align-middle text-center"><?php echo $citem['name']; ?></td>
                                        <td class="align-middle text-center">x<?php echo $citem['prod_qty']; ?></td>
                                        <td class="align-middle text-center"><?php echo $citem['selling_price']; ?>€</td>
                                    </tr>
                                <?php }
                            } ?>


                        </tbody>
                    </table>
                    <hr>
                    <h5>Σύνολο : <span class="float-end fw-bold"><?php echo $totalPrice; ?>€</span></h5>

                    <div class="">

                        <button type="submit" name="placeOrderBtn" class="btn btn-primary w-100">Confirm and place order
                            | COD</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>