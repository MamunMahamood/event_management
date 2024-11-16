<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}


$filename = 'events.txt';
$id = $_GET['id'];

$lines = file($filename);
$newData = '';

foreach ($lines as $line) {
    $data = explode('|', trim($line));
    if ($data[0] !== $id) {
        $newData .= $line;
    }
}

file_put_contents($filename, $newData);
header('Location: dashboard.php');
exit;
?>
