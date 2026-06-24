<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Get current page for active menu highlighting
$currentPage = basename($_SERVER['PHP_SELF']); 

// Get user role from session, avoid undefined variable
$role = $_SESSION['role'] ?? '';
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
       
        
        /* Navbar */
.navbar {
    background-color: #031d74ff; 
}

.navbar-brand {
    font-weight: bold;   /* make it bold */
    color: #fff !important; /* ensure text is white */
    font-size: 2rem !important; 
}

.navbar-brand,
.navbar-nav .nav-link,
.navbar-text {
    color: #fff !important; /* all text white */
    
    
}

/* Only active link gets golden color */
.navbar-nav .nav-link.active {
    color: #fafafaff !important; /* golden text */
    background-color: #df9c0dff; /* golden background */
}

/* Hover stays normal */
.navbar-nav .nav-link:hover {
    color: #fff !important; /* white text on hover */
    background-color: transparent; /* no background change */
}

/* Sidebar */
.sidebar {
    position: fixed;
    top: 56px;
    right: 0;
    width: 230px;
    height: calc(100vh - 56px);
    background-color: #031d74ff;
    color: #fff;
    padding-top: 20px;
    overflow-y: auto;
}

.sidebar a {
    color: #fff;
    text-decoration: none;
    display: block;
    padding: 12px 20px;
    transition: 0.3s;
}

.sidebar a:hover{
    color: #fff !important; /* white text on hover */
    background-color: transparent; /* no background change */

}
.sidebar a.active {
    color: #fafafaff !important; /* golden text */
    background-color: #df9c0dff;
}
       

      

        footer {
            text-align: center;
            padding: 10px 0;
            background: #f8f9fa;
            margin-top: 20px;
        }

.navbar-brand img {
    height: 80px;       /* maximum height */
    max-height: 90px;   /* ensures it won't exceed this */
    width: auto;        /* maintain aspect ratio */
}

.sidebar {
    position: fixed;
    top: 80px; /* instead of 56px */
    right: 0;
    width: 230px;
    height: calc(100vh - 80px);
    ...
}

@media (max-width: 991px) {
  .sidebar {
    display: none;
  }
}

/* Fix toggler icon visibility on dark navbar */
.navbar-toggler {
  border-color: rgba(255, 255, 255, 0.5);
}

/* .navbar-toggler-icon {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30'
  xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255,255,255,1%29'
  stroke-width='2' stroke-linecap='round' stroke-miterlimit='10'
  d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
} */

.navbar-toggler-icon {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba(0,0,0,1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}



    </style>
</head>

<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color:#031d74ff;">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../assets/uploads/logo.png" alt="Logo" class="me-2" style="height:60px;">
    </a>

<!-- Navbar toggler -->
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>


     <!-- Collapsible content   -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= $currentPage == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $currentPage == 'manage_apps.php' ? 'active' : '' ?>" href="manage_apps.php">Manage Apps</a>
        </li>
        <?php if ($role === 'Admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $currentPage == 'manage_users.php' ? 'active' : '' ?>" href="manage_users.php">Manage Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $currentPage == 'manage_roles.php' ? 'active' : '' ?>" href="manage_roles.php">Manage Roles</a>
                        </li>
                    <?php endif; ?>
         <li class="nav-item">
          <a class="nav-link <?= $currentPage == 'manage_wishlist.php' ? 'active' : '' ?>" href="manage_wishlist.php">Manage Wishlist</a>
        </li>
      </ul>

     
      <div class="d-flex align-items-center gap-4">
       
        <!-- <a href="../index.php" class="btn btn-warning btn-sm">Go to Catalog</a> -->
        <a href="../index.php" target="_blank" rel="noopener noreferrer" class="btn btn-warning btn-sm">Go to Catalog</a>

        <span class="text-white me-3">Hello, <?= htmlspecialchars($_SESSION['username']) ?></span>
        <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
      </div>
    </div>
  </div>
</nav>


    <!-- Right Sidebar -->
   <!-- <div class="sidebar d-none d-lg-block">
  <a href="dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
  <a href="manage_apps.php" class="<?= $currentPage == 'manage_apps.php' ? 'active' : '' ?>">Manage Apps</a> -->
  <?php 
  //  if ($role === 'Admin'): 
  ?>
            <!-- <a href="manage_users.php" class="<?= $currentPage == 'manage_users.php' ? 'active' : '' ?>">Manage Users</a>
            <a href="manage_roles.php" class="<?= $currentPage == 'manage_roles.php' ? 'active' : '' ?>">Manage Roles</a> -->
        <?php
          // endif; 
        ?>






  
</div> 


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const navbarNav = document.querySelector("#navbarNav");
  const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

  navLinks.forEach(link => {
    link.addEventListener("click", () => {
      const bsCollapse = bootstrap.Collapse.getInstance(navbarNav);
      if (bsCollapse && window.innerWidth < 992) {
        bsCollapse.hide();
      }
    });
  });
});
</script>



