<?php include 'includes/header.php' ?>
<?php include 'includes/navigation.php' ?>

<section id="contact" class="mt-4">
    <div class="container-lg">

        <h1 class="mb-4 fw-bold text-center">Φόρμα Επικοινωνίας</h1>

        <?php
        if (isset($_POST['submit'])) {
            $to = "manosgrammos9@gmail.com";
            $subject = $_POST['subject'];
            $body = $_POST['body'];
            $header ="From: " .$_POST['email'];

            // Χρήση wordwrap αν οι γραμμές είναι πιο μακρές από 70 χαρακτήρες
            $body = wordwrap($body, 70);

            // Αποστολή email
            if (mail($to, $subject, $body)) {
                echo "<p class='text-center bg-success bg-gradient rounded-2 text-white p-1'>Email sent successfully!</p>";
            } else {
                echo "<p>Failed to send email.</p>";
            }
        }
        ?>
        <div class="row mt-5">
            <div class="col-md-6">
                <p class="mb-4"><strong>Τηλέφωνο:</strong> 2100000000</p>
                <p class="mb-1"><strong>Viber:</strong> 0000000000 (Μόνο γραπτά μηνύματα)</p>
                <p class="mb-3"><strong>Messenger:</strong> <em>facebook.com/Someone (Μόνο γραπτά μηνύματα)</em></p>
                <p class="mb-4"><strong>Email:</strong> test@gmail.com</p>
                <p class="mb-3"><strong>Διεύθυνση:</strong><br> XXXX<br> XXX</p>
                <p class="mb-0"><strong>Ωράριο Λειτουργίας:</strong><br class="mb-3"><p class="mt-3">Δευτέρα – Παρασκευή 15:30 – 17:30</p></p>
            </div>

            <div class="col-md-6">
                <form action="" method="post"> <!-- Αλλαγή της action σε "" για την τρέχουσα σελίδα -->
                    <div class="mb-3">
                        <label for="email" class="form-label d-none">Email address</label>
                        <input type="email" name="email" class="form-control border border-black" id="email"
                            placeholder="Email" required>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label d-none">Subject</label>
                        <input type="text" name="subject" class="form-control border border-black" id="subject"
                            placeholder="Tίτλος" required>
                    </div>

                    <div class="mb-3 w-100">
                        <textarea class="w-100 form-control border border-black" name="body" id="body" cols="50"
                            rows="10" style="height:170px;" placeholder="Μήνυμα" required></textarea>
                    </div>

                    <input type="submit" name="submit" class="btn btn-primary w-100 fw-bold" value="ΑΠΟΣΤΟΛΗ">
                </form>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php' ?>