<?php
include "config/db.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Βήμα 1: Επαλήθευση του token
    $query = "SELECT * FROM users WHERE reset_token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if (isset($_POST['new-password'])) {
            $newPassword = $_POST['new-password'];
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);  // Κρυπτογράφηση του νέου κωδικού

            // Βήμα 2: Ενημέρωση του κωδικού στη βάση δεδομένων
            $query = "UPDATE user SET password = ?, reset_token = NULL WHERE reset_token = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss', $hashedPassword, $token);
            $stmt->execute();

            echo "<h1 class='mt-3 px-5'>Your password has been successfully reset.</h1>";
        }
    } else {
        echo "<h1 class='mt-3 px-5'>Invalid or expired token.</h1>";
    }
} else {
    echo "<h1 class='mt-3 px-5'>No token provided.</h1>";
}
?>

<!-- HTML Form for Resetting Password -->
<form action="reset-password?token=<?php echo $_GET['token']; ?>" method="post">
    <div class="form-group">
        <input type="password" name="new-password" placeholder="Enter your new password" class="form-control" required>
    </div>
    <div class="form-group">
        <input type="submit" name="new-password-submit" value="Reset Password" class="btn btn-primary">
    </div>
</form>
