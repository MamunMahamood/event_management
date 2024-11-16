<?php 

session_start();

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];


$errors = [];


if(empty($name)){
    $errors['name'] = "Name is required.";
}

if(empty($email)){
    $errors['email'] = "Email is required.";
}

if(empty($password)){
    $errors['password'] = "Password is required.";
}


if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('Location: register.php');
    exit();
}



$adminFile = 'admins.txt';
$admins = file($adminFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$newAdmin = $name . ':' . $hashedPassword .':'. $email. PHP_EOL;
file_put_contents($adminFile, $newAdmin, FILE_APPEND);

$success = "Admin Registration Successfull!";



if(!empty($success)){
    $_SESSION['success'] = $success;
    header('Location: login.php');
}


