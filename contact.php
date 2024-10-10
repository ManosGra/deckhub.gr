<?php include 'includes/header.php' ?>
<?php //include 'includes/navigation.php' ?>

<?php 
if(isset($_POST['submit'])){
    $to = "manosgrammos9@gmail.com";
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    
    // Χρήση wordwrap αν οι γραμμές είναι πιο μακρές από 70 χαρακτήρες
    $body = wordwrap($body, 70);

    // Αποστολή email
    if(mail($to, $subject, $body)){
        echo "<p>Email sent successfully!</p>";
    } else {
        echo "<p>Failed to send email.</p>";
    }
}
?>

<section id="contact" class="w-50 d-block mx-auto">
    <div class="container-lg">
        <h1 class="my-4 text-center fw-bold">Φόρμα Επικοινωνίας</h1>
        <form action="" method="post"> <!-- Αλλαγή της action σε "" για την τρέχουσα σελίδα -->

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" class="form-control border border-black" id="email" placeholder="somebody@example.com" required>
            </div>

            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" name="subject" class="form-control border border-black" id="subject" placeholder="Enter your Subject" required>
            </div>

            <div class="mb-3 w-100">
                <textarea class="w-100 form-control border border-black" name="body" id="body" cols="50" rows="10" style="height:170px;" required></textarea>
            </div>

            <input type="submit" name="submit" class="btn btn-primary w-100" value="Submit">
        </form>
    </div>
</section>

<?php include 'includes/footer.php' ?>
