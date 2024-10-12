<?php include "config/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<?php
if (isset($_POST['recover-submit'])) {
    $email = $_POST['email'];

    // Βήμα 1: Επαλήθευση του email στην βάση δεδομένων
    $query = "SELECT * FROM user WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Βήμα 2: Δημιουργία token για την επαναφορά
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(50));  // Δημιουργία μοναδικού token

        // Αποθήκευση του token στη βάση δεδομένων
        $query = "UPDATE user SET reset_token = ? WHERE user_email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $token, $email);
        $stmt->execute();

        // Βήμα 3: Αποστολή email με το link επαναφοράς
        $resetLink = "http://yourdomain.com/reset-password.php?token=" . $token;
        $subject = "Password Reset Request";
        $message = "Hello, \n\nTo reset your password, click the following link: \n$resetLink\n\nIf you did not request this change, please ignore this email.";
        $headers = "From: no-reply@yourdomain.com";

        ?>

        <!-- Page Content -->
        <section id="forgot">
            <div class="container-lg">
                <div class="form-gap"></div>
                <div class="card d-block w-50 mx-auto shadow-lg">
                    <div class="card-body">
                        <div class="text-center">
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="card-body">
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                                    <div class="form-group">
                                        <div class="input-group mx-auto rounded" style="max-width:300px;">
                                            <i class="bi bi-envelope font-size-25 px-2 border"></i>
                                            <input id="email" name="email" placeholder="email address" class="form-control ps-2"
                                                type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary mt-3 "
                                            style="min-width:300px;" value="Reset Password" type="submit">
                                    </div>
                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                                <?php


                                if (mail($email, $subject, $message, $headers)) {
                                    echo "<h2 class='mt-3 px-5'>Please check your email to reset your password!</h2>";
                                } else {
                                    echo "<h2 class='mt-3 px-5'>There was an error sending the email. Please try again later.</h2>";
                                }
                                    } else {
                                        echo "<h2 class='mt-3 px-5'>No user found with that email address.</h2>";
                                    }
                                }
                                ?>
                    </div><!-- Body-->
                </div>
            </div>
        </div>
    </div> <!-- /.container -->
</section>

<?php include "includes/footer.php"; ?>