<?php
session_start();
include '../config/db.php'; // Σύνδεση στη βάση δεδομένων
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php'; 
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if (isset($_POST['register_btn'])) {
    // Λήψη δεδομένων από τη φόρμα εγγραφής
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Προεπιλεγμένος ρόλος
    $default_role = '0';

    // Δημιουργία του token για ενεργοποίηση
    $activation_token = md5(rand());

    // Έλεγχος αν το email υπάρχει ήδη στη βάση δεδομένων
    $stmt = $conn->prepare("SELECT user_email FROM user WHERE user_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = "Αυτό το email χρησιμοποιείται ήδη.";
        header('Location: ../login-register.php');
        exit();
    } else {
        // Έλεγχος αν οι κωδικοί ταιριάζουν
        if ($password === $cpassword) {
            // Χρήση προετοιμασμένων εντολών για την εισαγωγή χρήστη
            $stmt = $conn->prepare("INSERT INTO user (username, user_email, user_password, user_role, activation_token) VALUES (?, ?, ?, ?, ?)");
            $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Κρυπτογράφηση κωδικού
            $stmt->bind_param("sssss", $name, $email, $hashed_password, $default_role, $activation_token);

            if ($stmt->execute()) {
                // Αποστολή email ενεργοποίησης
                $activation_link = "http://localhost/yourwebsite/activate.php?token=$activation_token";

                $mail = new PHPMailer(true);
                try {
                    // Ρυθμίσεις του SMTP
                    $mail->isSMTP();
                    $mail->Host = 'localhost';  // Ρυθμίστε τον διακομιστή SMTP του PaperCut
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your-email@example.com'; // Ο χρήστης SMTP
                    $mail->Password = 'your-smtp-password'; // Ο κωδικός SMTP
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 25;  // Θύρα του PaperCut (ή 587 για TLS)

                    // Ρυθμίσεις του email
                    $mail->setFrom('your-email@example.com', 'Your Name');
                    $mail->addAddress($email, $name);
                    $mail->isHTML(true);
                    $mail->Subject = 'Ενεργοποίηση Λογαριασμού';
                    $mail->Body    = "<p>Παρακαλώ κάντε κλικ στο παρακάτω σύνδεσμο για να ενεργοποιήσετε το λογαριασμό σας:</p><p><a href='$activation_link'>$activation_link</a></p>";

                    // Στέλνουμε το email
                    $mail->send();
                    $_SESSION['message'] = "Επιτυχής εγγραφή! Ένα email ενεργοποίησης στάλθηκε.";
                } catch (Exception $e) {
                    $_SESSION['message'] = "Το email ενεργοποίησης δεν μπόρεσε να αποσταλεί. Σφάλμα: {$mail->ErrorInfo}";
                }

                header('Location: ../login-register.php');
                exit();
            } else {
                $_SESSION['message'] = "Κάτι πήγε στραβά: " . $stmt->error;
                header('Location: ../login-register.php');
                exit();
            }
        } else {
            $_SESSION['message'] = "Οι κωδικοί δεν ταιριάζουν.";
            header('Location: ../login-register.php');
            exit();
        }
    }

    $stmt->close();
}

if (isset($_POST['login_btn'])) {
    // Λήψη δεδομένων από τη φόρμα σύνδεσης
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Προετοιμασία του SQL query
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Έλεγχος αν βρέθηκε ο χρήστης
    if ($result->num_rows > 0) {
        $userdata = $result->fetch_assoc();

        // Έλεγχος αν το password είναι σωστό και ο λογαριασμός είναι ενεργοποιημένος
        if (password_verify($password, $userdata['user_password'])) {
            // Έλεγχος αν ο λογαριασμός είναι ενεργοποιημένος
            if ($userdata['user_status'] == 0) {
                $_SESSION['message'] = "Ο λογαριασμός σας δεν έχει ενεργοποιηθεί ακόμα. Παρακαλώ ελέγξτε το email σας για τον σύνδεσμο ενεργοποίησης.";
                header('Location: ../my-account');
                exit();
            }

            $_SESSION['auth'] = true;

            // Αποθήκευση δεδομένων του χρήστη στο session
            $_SESSION['auth_user'] = [
                'user_id' => $userdata['user_id'],  // Χρήση του user_id από τη βάση
                'username' => $userdata['username'],
                'email' => $userdata['user_email']
            ];

            $_SESSION['user_role'] = $userdata['user_role'];

            // Έλεγχος ρόλου χρήστη
            if ($userdata['user_role'] == '1') {
                $_SESSION['message'] = "Καλώς ήρθατε στον Πίνακα Ελέγχου";
                header('Location: ../administration/index.php');
                exit();
            } else {
                $_SESSION['message'] = "Σύνδεση με επιτυχία";
                header('Location: ../my-account');
                exit();
            }
        } else {
            // Μη έγκυρος κωδικός πρόσβασης
            $_SESSION['message'] = "Μη έγκυρες διαπιστεύσεις";
            header('Location: ../my-account');
            exit();
        }
    } else {
        // Μη έγκυρο όνομα χρήστη
        $_SESSION['message'] = "Μη έγκυρο όνομα χρήστη";
        header('Location: ../my-account');
        exit();
    }

    // Κλείσιμο του statement
    $stmt->close();
}


$conn->close();
