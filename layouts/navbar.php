<nav class="navbar navbar-dark bg-dark navbar-expand-sm navbar-expand-lg">
    <!-- Navbar content -->
    <div class="container">
        <a class="navbar-brand" href="index.php">EVENT</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            
                <li class="nav-item">
                    <a class="nav-link <?= ($_SERVER['PHP_SELF'] == '/event_management/index.php' ? 'active' : '') ?>" href="/event_management/index.php">Event List</a>
                </li>
                <?php if (!isset($_SESSION['name'])): ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($_SERVER['PHP_SELF'] == '/event_management/register.php' ? 'active' : '') ?>" href="register.php"> Admin Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($_SERVER['PHP_SELF'] == '/event_management/login.php' ? 'active' : '') ?>" href="login.php">Admin Login</a>
                </li>
                <?php else: ?>
                    <li class="nav-item">
                    <a class="nav-link <?= ($_SERVER['PHP_SELF'] == '/event_management/dashboard.php' ? 'active' : '') ?>" href="dashboard.php">Admin Dashboard</a>
                </li>

                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['name'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>