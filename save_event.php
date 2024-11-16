<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}


$filename = 'events.txt';
$id = uniqid();
$event_name = $_POST['event_name'];
$event_date = $_POST['event_date'];
$event_location = $_POST['event_location'];
$event_image = '';
$event_type = $_POST['event_type'];
$event_capacity = $_POST['event_capacity'];
$event_organizer = $_POST['event_organizer'];
$registration_deadline = $_POST['registration_deadline'];
$event_description = $_POST['event_description'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
// $email = $_POST['email'];
// $latitude = $_POST['latitude'];
// $longitude = $_POST['longitude'];



// Handle image upload
try {
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === 0) {
        $event_image = $id . '_' . basename($_FILES['event_image']['name']);
        $targetPath = 'uploads/' . $event_image;
        move_uploaded_file($_FILES['event_image']['tmp_name'], $targetPath);
    }


    $record = "$id|$event_name|$event_date|$event_location|$event_capacity|$event_image|$event_type|$event_organizer|$registration_deadline|$event_description|$latitude|$longitude|0\n";
    file_put_contents($filename, $record, FILE_APPEND);

    header('Location: dashboard.php');
    exit;
} catch (Exception $e) {

    echo "error" . $e;
}
