<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container d-flex justify-content-center">
        <div class="admin-panel-text">
            <span class="admin-panel-title">Admin Panel</span>
        </div>
        <a class="navbar-brand logo" href="#">
            <img src="img/logocd.png" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php' || empty(basename($_SERVER['PHP_SELF']))) ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">DASHBOARD</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">CHAT</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="buildDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        BUILD &nbsp; <i class="fa-solid fa-bomb"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="buildDropdown">
                        <a class="dropdown-item" href="#">Build Email Newsletter</a>
                        <a class="dropdown-item" href="#">Placeholder Option 1</a>
                        <a class="dropdown-item" href="#">Placeholder Option 2</a>
                        <a class="dropdown-item" href="#">Placeholder Option 3</a>
                    </div>
                </li>
            </ul>
        </div>

        <div class="ml-auto">
        <div class="nav-item dropdown">
    <div class="profile-container">
        <img src="img/pfp.jpeg" class="profile-picture" alt="Profile Picture">
        <a class="nav-link dropdown-toggle dots" href="#" id="settingsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="settingsDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#editProfileModal">Edit Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
        </div>
    </div>
</div>

        </div>
    </div>
</nav>

