<?php
session_start();
include '../config/db.php'; // Σύνδεση στη βάση δεδομένων

if (isset($_POST['register_btn'])) {
    // Λήψη δεδομένων από τη φόρμα εγγραφής
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Προεπιλεγμένος ρόλος
    $default_role = '0';

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
            $stmt = $conn->prepare("INSERT INTO user (username, user_email, user_password, user_role) VALUES (?, ?, ?, ?)");
            $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Κρυπτογράφηση κωδικού
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $default_role);

            if ($stmt->execute()) {
                $_SESSION['message'] = "Επιτυχής εγγραφή!!!";
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

        // Έλεγχος αν το password είναι σωστό
        if (password_verify($password, $userdata['user_password'])) {
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