<?php

session_start();
$filename = 'events.txt';
$id = $_GET['id'] ?? null;
$record = null;



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


if (!$record) {
    header('Location: dashboard.php');
    exit;
}

$latitude = $record[10];
$longitude = $record[11];
$name = $record[1];




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>
    <?php include('./layouts/navbar.php') ?>
    <div class="container">


        <div class="card mt-5 mb-5">
            <div class="card-header">
                <h4 class="float-start">Event Detail</h4>
                <a class="float-end" href="dashboard.php">Back to List</a>
            </div>
            <div class="card-body">
                <div class="card">
                    <img src="<?php echo 'uploads/' . htmlspecialchars($record[5]); ?>" alt="Image" style="width: 100%; height: 200px; object-fit: cover;">
                </div>
                <div class="row m-0 mt-3">
                    <div class="card col-5 p-3">
                        <h6><strong>Event Name:</strong> <?= $record[1] ?></h6>
                        <h6><strong>Event ID:</strong> <?= $record[0] ?></h6>
                        <h6><strong>Event Date:</strong> <?= $record[2] ?></h6>
                        <h6><strong>Event Location:</strong> <?= $record[3] ?></h6>
                        <h6><strong>Event Type:</strong> <?= $record[6] ?></h6>
                        <h6><strong>Event Organizer:</strong> <?= $record[7] ?></h6>
                    </div>

                    <div class="card col-7 p-3">
                        <h6><strong>Event Description:</strong><br><br> <?= $record[9] ?></h6>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">Map Location</div>
                    <div class="card-body">
                        <?php include('./layouts/view_location.php') ?>
                    </div>
                </div>
                <div class="float-end mt-3">
                    <div>
                        <?php if (isset($_SESSION['name'])): ?>
                            <a class="btn btn-primary" href="edit.php?id=<?= $record[0] ?>">Edit</a>
                            <a class="btn btn-danger" href="delete.php?id=<?= $record[0] ?>">Delete</a>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>



    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>