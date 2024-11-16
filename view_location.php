<?php
$latitude = $_GET['lat'] ?? '51.505';
$longitude = $_GET['lng'] ?? '-0.09';
$name = $_GET['name'] ?? 'Unknown Location';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2>Location: <?php echo htmlspecialchars($name); ?></h2>
    <div id="map" style="width: 100%; height: 500px;"></div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>])
    .addTo(map)
    .bindPopup('<b><?php echo htmlspecialchars($name); ?></b>')
    .openPopup();
</script>

</body>
</html>
