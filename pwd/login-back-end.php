<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Simulate user data for the example (replace with your DB check)
    $users = [
        ['email' => 'test@example.com', 'password' => 'password123']
    ];

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Dummy authentication (replace with real authentication logic)
    $authenticated = false;
    foreach ($users as $user) {
        if ($user['email'] == $email && $user['password'] == $password) {
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        echo "Login successful!";
        // Redirect to a secure page or set session variables here
    } else {
        echo "Invalid email or password.";
    }
}

