<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    // Dummy response (replace with actual password recovery logic)
    echo "A recovery link has been sent to " . htmlspecialchars($email);
}

