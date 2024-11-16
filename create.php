<?php

session_start();

if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <?php include('./layouts/navbar.php') ?>
    <div class="container">
        <div class="card mt-5 mb-5 bg-color">
            <div class="card-header">
                <h4 class="float-start">Add Event</h4>
                <a class="float-end" style="text-decoration: none;" href="dashboard.php">Back to List</a>
            </div>
            <div class="card-body">
                <form action="save_event.php" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_name">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name" placeholder="Enter event name" required>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_date">Event Date</label>
                            <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_location">Event Location</label>
                            <input type="text" class="form-control" id="event_location" name="event_location" placeholder="Enter event location" required>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_image">Event Image</label>
                            <input type="file" class="form-control" id="event_image" name="event_image" accept="image/*">
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_type">Event Type</label>
                            <select class="form-control" id="event_type" name="event_type">
                                <option value="Conference">Conference</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Webinar">Webinar</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_capacity">Event Capacity</label>
                            <input type="number" class="form-control" id="event_capacity" name="event_capacity" placeholder="Enter maximum number of attendees">
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="event_organizer">Event Organizer</label>
                            <input type="text" class="form-control" id="event_organizer" name="event_organizer" placeholder="Organizer name">
                        </div>
                        <div class="form-group col-sm-6 mb-3">
                            <label for="registration_deadline">Registration Deadline</label>
                            <input type="date" class="form-control" id="registration_deadline" name="registration_deadline">
                        </div>
                        <div class="form-group col-12 mb-3">
                            <label for="event_description">Event Description</label>
                            <textarea class="form-control" id="event_description" name="event_description" rows="4" placeholder="Describe the event"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" id="latitude" name="latitude" class="form-control" readonly required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" id="longitude" name="longitude" class="form-control" readonly required>
                        </div>

                        <div id="map" style="width: 100%; height: 400px;" class="mb-3"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Initialize the map
        const map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        let marker;
        map.on('click', function(e) {
            const {
                lat,
                lng
            } = e.latlng;
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