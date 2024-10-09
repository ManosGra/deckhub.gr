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
                                    <input type="text" name="name" class="form-control form-control-lg border-primary"
                                        placeholder="Όνομα" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold ">Επώνυμο</label>
                                    <input type="text" name="lastname"
                                        class="form-control form-control-lg border-primary" placeholder="Επώνυμο"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold  mt-3">Email</label>
                                    <input type="email" name="email" class="form-control form-control-lg border-primary"
                                        placeholder="example@email.com" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label mt-3 fw-bold">Διεύθυνση</label>
                                    <input type="text" name="address"
                                        class="form-control form-control-lg border-primary" placeholder="Διεύθυνση"
                                        required></input>
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
                            <div id="paypal-button-container"></div>
                            <p id="result-message"></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<script
    src="https://www.paypal.com/sdk/js?client-id=AfKKVavIPXWqOTrE1le96PxC-lvpYIdWHZMfP9Vz8nZfHacg8uCboZteyXkrNMIZfwjfxKZpvGTDDVhD&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo"
    data-sdk-integration-source="developer-studio"></script>

<script>
    window.paypal
        .Buttons({
            style: {
                shape: "rect",
                layout: "vertical",
                color: "gold",
                label: "paypal",
            },
            message: {
                amount: <?php echo $totalPrice; ?>,
            },

            async createOrder() {
                try {
                    const response = await fetch("/api/orders", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        // use the "body" param to optionally pass additional order information
                        // like product ids and quantities
                        body: JSON.stringify({
                            cart: [
                                {
                                    id: "YOUR_PRODUCT_ID",
                                    quantity: "YOUR_PRODUCT_QUANTITY",
                                },
                            ],
                        }),
                    });

                    const orderData = await response.json();

                    if (orderData.id) {
                        return orderData.id;
                    }
                    const errorDetail = orderData?.details?.[0];
                    const errorMessage = errorDetail
                        ? `${errorDetail.issue} ${errorDetail.description} (${orderData.debug_id})`
                        : JSON.stringify(orderData);

                    throw new Error(errorMessage);
                } catch (error) {
                    console.error(error);
                    // resultMessage(`Could not initiate PayPal Checkout...<br><br>${error}`);
                }
            },

            async onApprove(data, actions) {
                try {
                    const response = await fetch(
                        `/api/orders/${data.orderID}/capture`,
                        {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                        }
                    );

                    const orderData = await response.json();
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you message

                    const errorDetail = orderData?.details?.[0];

                    if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                        // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                        // recoverable state, per
                        // https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/
                        return actions.restart();
                    } else if (errorDetail) {
                        // (2) Other non-recoverable errors -> Show a failure message
                        throw new Error(
                            `${errorDetail.description} (${orderData.debug_id})`
                        );
                    } else if (!orderData.purchase_units) {
                        throw new Error(JSON.stringify(orderData));
                    } else {
                        // (3) Successful transaction -> Show confirmation or thank you message
                        // Or go to another URL:  actions.redirect('thank_you.html');
                        const transaction =
                            orderData?.purchase_units?.[0]?.payments
                                ?.captures?.[0] ||
                            orderData?.purchase_units?.[0]?.payments
                                ?.authorizations?.[0];
                        resultMessage(
                            `Transaction ${transaction.status}: ${transaction.id}<br>
          <br>See console for all available details`
                        );
                        console.log(
                            "Capture result",
                            orderData,
                            JSON.stringify(orderData, null, 2)
                        );
                    }
                } catch (error) {
                    console.error(error);
                    resultMessage(
                        `Sorry, your transaction could not be processed...<br><br>${error}`
                    );
                }
            },
        })
        .render("#paypal-button-container"); 
</script>