<?php
// Συμπερίληψη της σύνδεσης στη βάση δεδομένων
include('../config/db.php');

// Δημιουργία ενός μόνιμου και ασφαλούς token (μόνο μία φορά)
$token = bin2hex(random_bytes(16));  // Δημιουργία 32 χαρακτήρων (16 bytes)

// Δημιουργία πίνακα (αν δεν υπάρχει ήδη)
$query = "CREATE TABLE IF NOT EXISTS admin_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(64) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($query);

// Αποθήκευση του token στη βάση δεδομένων
$query = "INSERT INTO admin_tokens (token) VALUES ('$token')";
$conn->query($query);

// Εμφάνιση του token
echo "Το μόνιμο token για το Admin Panel είναι: http://deckhub.local/admin/?token=" . $token;
?>