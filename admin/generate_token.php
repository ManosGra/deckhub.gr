<?php
// Δημιουργία ενός τυχαίου και ασφαλούς token
$token = bin2hex(random_bytes(16));  // 32 χαρακτήρες (16 bytes)

// Αποθήκευση του token στην βάση δεδομένων ή σε ένα αρχείο
// Για απλότητα, το εκτυπώνουμε απλά
echo "Το URL για το Admin Panel είναι: ";
echo "http://deckhub.local/admin/?token=" . $token;