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

// Redirect if record not found
if (!$record) {
    header('Location: dashboard.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>

<body>
    <?php include('./layouts/navbar.php') ?>
    <div class="container">
        <div class="card mt-5 mb-5 bg-color">
            <div class="card-header">
                <h4 class="float-start">Edit Event</h4>
                <a class="float-end" style="text-decoration: none;" href="dashboard.php">Back to List</a>
            </div>
            <div class="card-body">
                <form action="update_event.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $record[0] ?>">
                    <div class="row">
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_name">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name" value="<?= $record[1] ?>" required>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_date">Event Date</label>
                            <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="<?= $record[2] ?>" required>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_location">Event Location</label>
                            <input type="text" class="form-control" id="event_location" name="event_location" value="<?= $record[3] ?>" required>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_image">Event Image</label>
                            <input type="file" class="form-control" id="event_image" name="event_image" accept="image/*">
                            <?php if (!empty($record[5])): ?>
                                <img src="uploads/<?= $record[5] ?>" alt="Event Image" class="img-thumbnail mt-2" width="150">
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_type">Event Type</label>
                            <select class="form-control" id="event_type" name="event_type">
                                <option value="Conference" <?= $record[5] === 'Conference' ? 'selected' : '' ?>>Conference</option>
                                <option value="Workshop" <?= $record[5] === 'Workshop' ? 'selected' : '' ?>>Workshop</option>
                                <option value="Seminar" <?= $record[5] === 'Seminar' ? 'selected' : '' ?>>Seminar</option>
                                <option value="Webinar" <?= $record[5] === 'Webinar' ? 'selected' : '' ?>>Webinar</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_capacity">Event Capacity</label>
                            <input type="number" class="form-control" id="event_capacity" name="event_capacity" value="<?= $record[4] ?>">
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_organizer">Event Organizer</label>
                            <input type="text" class="form-control" id="event_organizer" name="event_organizer" value="<?= $record[7] ?>">
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="registration_deadline">Registration Deadline</label>
                            <input type="date" class="form-control" id="registration_deadline" name="registration_deadline" value="<?= $record[8] ?>">
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label for="event_description">Event Description</label>
                            <textarea class="form-control" id="event_description" name="event_description" rows="4"><?= $record[9] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" id="latitude" name="latitude" class="form-control" value="<?= $record[10] ?>" readonly required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" id="longitude" name="longitude" class="form-control" value="<?= $record[11] ?>" readonly required>
                        </div>

                        <div id="map" style="width: 100%; height: 400px;" class="mb-3"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        const map = L.map('map').setView([<?= $record[10] ?>, <?= $record[11] ?>], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        let marker = L.marker([<?= $record[10] ?>, <?= $record[11] ?>]).addTo(map);

        map.on('click', function(e) {
            const { lat, lng } = e.latlng;
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
        });
    </script>
</body>

</html>
