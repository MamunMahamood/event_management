<?php

session_start();
$email = $_POST['email'];
$password = $_POST['password'];



$adminFile = 'admins.txt';
$authenticated = false;

if (file_exists($adminFile)) {

    
    $admins = file($adminFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Loop through each line in the file
    foreach ($admins as $admin) {
        list($storedAdminName, $storedPassword, $storedEmail) = explode(':', $admin);

        // Check if the adminname matches and verify the password
        if (password_verify($password, $storedPassword) && $email == $storedEmail) {
            $authenticated = true;
            $_SESSION['name'] = $storedAdminName;
            break;
        }
    }

}


// // Redirect based on authentication result
if ($authenticated) {
    header('Location: dashboard.php');
    exit();
} else {
    echo "Invalid adminname or password. <a href='login.php'>Try again</a>";
}