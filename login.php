<?php
session_start();

// Retrieve success message from session if available
$success = $_SESSION['success'] ?? '';

// Ensure to unset the session variable after retrieving the message to avoid showing it on subsequent page loads
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <?php include('./layouts/navbar.php') ?>
    <div class="container">
        <div class="row justify-content-center">
            <?php if (!empty($success)): ?>
                <span class="alert alert-success"><?= htmlspecialchars($success) ?></span>
            <?php endif; ?>

            <div class="card mt-5 col-sm-6 col-md-6 bg-color">
                <div class="card-header">
                    <h4>Admin Login</h4>
                </div>
                <div class="card-body">
                    <form action="authenticate.php" method="POST">
                        <div class="mb-2">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" autocomplete="off" required>
                            <?php if (isset($errors['email'])): ?>
                                <p style="color: red;"><?= $errors['email'] ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" autocomplete="off" required>
                            <?php if (isset($errors['password'])): ?>
                                <p style="color: red;"><?= $errors['password'] ?></p>
                            <?php endif; ?>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>