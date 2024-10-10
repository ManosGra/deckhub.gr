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
<?php
$cartItems = getCartItems();

if (mysqli_num_rows($cartItems) == 0) {
    header('Location: index.php');
}
?>

<section id="checkout">
    <div class="container-lg">
        <a href="cart.php" class="text-decoration-none btn btn-warning mb-5"><i class="fa fa-reply me-2"></i>Back</a>
        <form action="functions/placeorder.php" method="POST">
            <div class="row">
                <div class="col-md-7">
                    <h5 class="mb-3">Basic Details</h5>
                    <div class="card shadow-lg">
                        <div class="card-body primary">

                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Ονομα</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control form-control-lg border-primary" placeholder="Όνομα"
                                        required>
                                    <small class="text-danger name"></small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold ">Επώνυμο</label>
                                    <input type="text" name="lastname" id="lastname"
                                        class="form-control form-control-lg border-primary" placeholder="Επώνυμο"
                                        required>
                                    <small class="text-danger lastname"></small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold  mt-3">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control form-control-lg border-primary"
                                        placeholder="example@email.com" required>
                                    <small class="text-danger email"></small>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3 fw-bold">Διεύθυνση</label>
                                    <input type="text" name="address" id="address"
                                        class="form-control form-control-lg border-primary" placeholder="Διεύθυνση"
                                        required></input>
                                    <small class="text-danger address"></small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label mt-3 fw-bold">Τηλέφωνο</label>
                                    <input type="tel" name="phone" id="phone"
                                        class="form-control form-control-lg border-primary" placeholder="Τηλέφωνο"
                                        required>
                                    <small class="text-danger phone"></small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label mt-3 fw-bold">Ταχυδρομικός Κωδικός</label>
                                    <input type="text" name="pincode" id="pincode"
                                        class="form-control form-control-lg border-primary"
                                        placeholder="Ταχυδρομικός Κωδικός" required>
                                    <small class="text-danger pincode"></small>
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
                                            <img data-src="uploads/<?php echo $citem['item_image']; ?>" class="lazy" alt="Image"
                                                width="100px">
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

                        <div id="paypal-button-container" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script
    src="https://www.paypal.com/sdk/js?client-id=AfKKVavIPXWqOTrE1le96PxC-lvpYIdWHZMfP9Vz8nZfHacg8uCboZteyXkrNMIZfwjfxKZpvGTDDVhD&currency=EUR"></script>

<script>

    paypal.Buttons({
        onClick() {
            var name = $('#name').val();
            var lastname = $('#lastname').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
            var pincode = $('#pincode').val();
            var address = $('#address').val();

            if (name.length == 0) {
                $('.name').text("*This field is required");
            } else {
                $('.name').text("");
            }
            if (lastname.length == 0) {
                $('.lastname').text("*This field is required");
            } else {
                $('.lastname').text("");
            }
            if (email.length == 0) {
                $('.email').text("*This field is required");
            } else {
                $('.email').text("");
            }
            if (phone.length == 0) {
                $('.phone').text("*This field is required");
            } else {
                $('.phone').text("");
            }
            if (pincode.length == 0) {
                $('.pincode').text("*This field is required");
            } else {
                $('.pincode').text("");
            }
            if (address.length == 0) {
                $('.address').text("*This field is required");
            } else {
                $('.address').text("");
            }

            if (name.length == 0 || lastname.length == 0 || email.length == 0 || phone.length == 0 || pincode.length == 0 || address.length == 0) {
                return false;
            }
        },
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $totalPrice; ?>' // Το ποσό πληρωμής
                    }
                }]
            });
        },
        onApprove: function (data, actions) {
            return actions.order.capture().then(function (orderData) {
                const transaction = orderData.purchase_units[0].payments.captures[0];

                var name = $('#name').val();
                var lastname = $('#lastname').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                var pincode = $('#pincode').val();
                var address = $('#address').val();

                var data = {
                    'name': name,
                    'lastname': lastname,
                    'email': email,
                    'phone': phone,
                    'pincode': pincode,
                    'address': address,
                    'payment_mode': "Paid by Paypal",
                    'payment_id': transaction.id,
                    'placeOrderBtn': true
                };

                $.ajax({
                    method: "POST",
                    url: "functions/placeorder.php",
                    data: data,
                    success: function (response) {
                        if (response == 201) {
                            window.location.href = 'my-account?source=orders';
                            alertify.success("Order Placed Successfully");
                        } else {
                            alertify.error('Failed to place order. Response: ' + response.message);
                        }
                    }
                });
            });
        }
    }).render('#paypal-button-container');
</script>