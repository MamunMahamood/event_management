<?php

session_start();

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$filename = 'events.txt';

$on = $_GET['on'] ?? null;
$off = $_GET['off'] ?? null;
$id = $_GET['id'] ?? null;
$publish = $on ? $on : $off;

if (!$id || ($publish === null)) {
    // If ID or publish status is not provided, redirect back
    header('Location: dashboard.php?error=missing_params');
    exit;
}

$updatedContent = '';
$file = fopen($filename, 'r');

// Read the file line by line
while (($line = fgets($file)) !== false) {
    $data = explode('|', trim($line));

    // Check if the current line matches the ID
    if (isset($data[0]) && $data[0] === $id) {
        // Debug: Display the current record before updating
        error_log("Updating ID: $id, Current Publish: " . end($data) . ", New Publish: $publish");

        // Update only the publish status (assuming it's the last field)
        $data[count($data) - 1] = $publish;

        // Rebuild the line with the updated publish status
        $updatedContent .= implode('|', $data) . "\n";
    } else {
        // Keep the line unchanged
        $updatedContent .= $line;
    }
}

fclose($file);

// Save the updated content back to the file
file_put_contents($filename, $updatedContent);

// Redirect back to the dashboard after updating
header('Location: dashboard.php');
exit;
