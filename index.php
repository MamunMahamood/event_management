<?php
session_start();
$filename = 'events.txt';

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
    <div class="card mt-5">
            <div class="card-header">
                <h4 class="float-start">Event List</h4>

                <!-- <a class="float-end" style="text-decoration: none;" href="create.php"><strong>+</strong> Add New Event</a> -->

            </div>
            <div class="card-body">
                <?php include('./layouts/published_event_list.php') ?>
            </div>
        </div>
        

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>