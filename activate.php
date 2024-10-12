<?php
session_start();
include '../config/db.php'; // Σύνδεση στη βάση δεδομένων

// Ελέγχουμε αν υπάρχει το token στην παραμέτρου του URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Προετοιμασία του SQL query για να ελέγξουμε αν το token υπάρχει στη βάση δεδομένων
    $stmt = $conn->prepare("SELECT user_id FROM user WHERE activation_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    // Αν το token βρέθηκε
    if ($stmt->num_rows > 0) {
        // Ενεργοποιούμε το λογαριασμό του χρήστη και διαγράφουμε το token
        $stmt = $conn->prepare("UPDATE user SET user_status = 1, activation_token = NULL WHERE activation_token = ?");
        $stmt->bind_param("s", $token);

        if ($stmt->execute()) {
            // Μήνυμα επιτυχίας
            $_SESSION['message'] = "Ο λογαριασμός σας έχει ενεργοποιηθεί με επιτυχία!";
            header('Location: ../login-register.php');
            exit();
        } else {
            // Μήνυμα σφάλματος κατά την ενημέρωση της βάσης δεδομένων
            $_SESSION['message'] = "Κάτι πήγε στραβά κατά την ενεργοποίηση του λογαριασμού.";
            header('Location: ../login-register.php');
            exit();
        }
    } else {
        // Αν το token δεν βρέθηκε
        $_SESSION['message'] = "Άκυρο token ενεργοποίησης.";
        header('Location: ../login-register.php');
        exit();
    }

    $stmt->close();
} else {
    // Αν δεν υπάρχει το token στο URL
    $_SESSION['message'] = "Δεν παρέχεται token ενεργοποίησης.";
    header('Location: ../login-register.php');
    exit();
}

$conn->close();
?>
