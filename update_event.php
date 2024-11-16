<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}
$filename = 'events.txt';
$id = $_GET['id'] ?? null;
$record = null;

// Fetch the existing record based on ID
if ($id && file_exists($filename)) {
    $file = fopen($filename, 'r');
    while (($line = fgets($file)) !== false) {
        $data = explode('|', trim($line));
        if ($data[0] === $id) {
            $record = $data;
            break;
        }
    }
    fclose($file);
}

// If the record is not found, redirect back to the dashboard
if (!$record) {
    header('Location: dashboard.php');
    exit;
}

// Update the record if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    $event_location = $_POST['event_location'];
    $event_type = $_POST['event_type'];
    $event_capacity = $_POST['event_capacity'];
    $event_organizer = $_POST['event_organizer'];
    $registration_deadline = $_POST['registration_deadline'];
    $event_description = $_POST['event_description'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $publish = $_POST['publish'];
    $event_image = $record[5]; // Default to existing image

    // Handle image upload
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === 0) {
        $newImageName = $id . '_' . basename($_FILES['event_image']['name']);
        $targetPath = 'uploads/' . $newImageName;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['event_image']['tmp_name'], $targetPath)) {
            // Delete the old image file if a new image is uploaded
            if (!empty($event_image) && file_exists('uploads/' . $event_image)) {
                unlink('uploads/' . $event_image);
            }
            $event_image = $newImageName;
        }
    }

    // Read all data and update the specific record
    $updatedContent = '';
    $file = fopen($filename, 'r');
    while (($line = fgets($file)) !== false) {
        $data = explode('|', trim($line));
        if ($data[0] === $id) {
            // Update the record with new values
            $updatedContent .= "$id|$event_name|$event_date|$event_location|$event_image|$event_type|$event_capacity|$event_organizer|$registration_deadline|$event_description|$latitude|$longitude|$publish\n";
        } else {
            $updatedContent .= $line;
        }
    }
    fclose($file);

    // Save the updated content back to the file
    file_put_contents($filename, $updatedContent);

    // Redirect back to the dashboard after updating
    header('Location: dashboard.php?update=success');
    exit;
}
?>
