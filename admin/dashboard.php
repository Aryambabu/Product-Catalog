<?php
session_start();
include '../config.php';

// Redirect to login if user not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
?>
<?php include 'main.php'; ?>
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<style>
    body {
        background-color: #f8f9fa;
    }

   

 /* Main Content */
.content {
    margin-right: 200px;
    margin-left: 0px; /* space for sidebar */
    margin-top: 80px;
    padding: 20px;
    max-width: calc(100% - 250px); /* constrain content inside container */
}

/* Cards */
.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    padding: 30px 20px;
    transition: transform 0.3s, box-shadow 0.3s;
    color: #fff; /* text color */
    position: relative;
}

/* Different background colors for each card (you can adjust) */
.card:nth-child(1) { background-color: #4e73df; } /* Total Apps */
.card:nth-child(2) { background-color: #1cc88a; } /* Total Users */
.card:nth-child(3) { background-color: #ebad05ff; color: #000; } /* Total Roles, dark text for contrast */

/* Hover effect */
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

/* Card heading */
.card h6 {
    font-weight: 500;
    font-size: 1.5rem;
    margin-bottom: 10px;
    text-transform: uppercase;
}

/* Card number */
.card h3 {
    font-size: 2rem;
    font-weight: bold;
    margin: 0;
}

/* Optional: add icons on top-right corner of card */
.card .icon {
    position: absolute;
    top: 15px;
    right: 15px;
    font-size: 2rem;
    opacity: 0.2;
}

/* Footer */
footer {
    margin-top: 40px;
    text-align: center;
    color: #6c757d;
}

/* Make columns responsive */
@media (max-width: 1200px) {
    .col-md-4 {
        flex: 0 0 48%;  /* two cards per row */
        max-width: 48%;
    }
}

@media (max-width: 768px) {
    .content {
        margin-right: 0;  /* remove sidebar space */
        max-width: 100%;
    }
    .col-md-4 {
        flex: 0 0 100%;  /* one card per row */
        max-width: 100%;
    }
}

.card h5 {
    font-weight: 900;
    font-size: 1.5rem;
    text-transform: uppercase;
    color: #080808ff;
}

.card h3 {
    font-size: 1.5rem;
    margin: 0;
}

@media (max-width: 991px) {
  .content {
    margin-right: 0;
    padding: 15px;
  }
}



</style>


</head>

<body>


<!-- Main Content -->
<div class="container-fluid content" style="margin-top:150px !important;">
    <h4 class="mb-4">Dashboard Overview</h4>
    <div class="row g-4">
        <!-- Total Apps -->
        <div class="col-sm-6 col-md-4">
            <div class="card p-4 text-center">
                <h6>Total Applications</h6>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS c FROM applications");
                $apps = $result->fetch_assoc();
                ?>
                <h3><?= $apps['c'] ?></h3>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h6>Total Users</h6>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS c FROM users");
                $users = $result->fetch_assoc();
                ?>
                <h3><?= $users['c'] ?></h3>
            </div>
        </div>

        <!-- Total Roles -->
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h6>Total Roles</h6>
                <?php
                $result = $conn->query("SELECT COUNT(*) AS c FROM roles");
                $roles = $result->fetch_assoc();
                ?>
                <h3><?= $roles['c'] ?></h3>
            </div>
        </div>
    </div>

    

    <!-- Category-wise Counts -->
<div class="mt-5">
    <h5 class="mb-3" style="font-size:30px">Applications by Category</h5>
    <div class="row g-3">
        <?php
        // Query to get count per category
        $catResult = $conn->query("
            SELECT category, COUNT(*) AS count 
            FROM applications 
            GROUP BY category
            ORDER BY count DESC
        ");

        if ($catResult->num_rows > 0) {
            while ($cat = $catResult->fetch_assoc()) {
                ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card p-3 text-center" style="background-color:#ebad05ff; color: #000000;">
                        <h6 class="text-uppercase text-muted mb-2"><?= htmlspecialchars($cat['category']) ?></h6>
                        <h3 class="fw-bold"><?= $cat['count'] ?></h3>
                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="col-12"><div class="alert alert-info">No categories found.</div></div>';
        }
        ?>
    </div>
</div>



    <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
