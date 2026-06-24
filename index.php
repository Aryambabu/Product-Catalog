<?php 
session_start();
// For testing, set a dummy user_id if not logged in
if(!isset($_SESSION['user_id'])){
    $_SESSION['user_id'] = 1; // Replace with real login system
}
?>
<?php 
include 'config.php'; 
?>

<link rel="stylesheet" href="../assets/css/style.css">

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Application Catalog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 
  <link href="assets/css/styles.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

 
</head>
<body class="bg-light">

<div class="container py-4">
  <!-- Header -->
   <!-- mobile -->
<div class="bg-white p-3 rounded shadow-sm app-header header">
  <div class="row align-items-center">
    <!-- Logo -->
    <div class="col-12 col-md-3 text-center text-md-start mb-3 mb-md-0">
      <img src="assets/uploads/logo.png" alt="Logo" class="img-fluid" style="max-height:100px;">
    </div>

    <!-- Title -->
    <div class="col-12 col-md-6 text-center mb-3 mb-md-0">
      <h2 class="text-primary fw-bold mb-0" 
          style="font-size:2rem; font-family:'Libre Franklin', sans-serif;">
        App Catalog
      </h2>
    </div>

    <!-- Buttons -->
    <div class="col-12 col-md-3 text-center text-md-end">
      <div class="d-flex justify-content-center justify-content-md-end gap-2 flex-wrap">
        <button id="toggleView" class="btn btn-info btn-sm">Grid View</button>
        <a href="admin/login.php" class="btn btn-secondary btn-sm">Admin</a>
      </div>
    </div>
  </div>
</div>


  <!-- Search -->
  <div class="row mb-3">
    <div class="col-12 mb-2">
      <input type="text" id="searchBox" class="form-control" placeholder="Search applications...">
    </div>

    <!-- Categories -->
    <div class="col-12">
     <div id="categoryButtons" class="d-flex flex-wrap">
    <button class='btn btn-outline-primary btn-sm me-2 mb-2 category-btn active' data-category='all'>All</button>
    <button class='btn btn-outline-warning btn-sm me-2 mb-2 category-btn' data-category='popular'>Popular</button>
    <button class='btn btn-outline-info btn-sm me-2 mb-2 category-btn' data-category='wishlist'>Wishlist</button>
    <?php
    $catQuery = $conn->query("SELECT DISTINCT category FROM applications ORDER BY category ASC");
    while ($cat = $catQuery->fetch_assoc()) {
        echo "<button class='btn btn-outline-primary btn-sm me-2 mb-2 category-btn' data-category='" . htmlspecialchars($cat['category']) . "'>" . htmlspecialchars($cat['category']) . "</button>";
    }
    ?>
</div>
          
    
    </div>
  </div>

  <!-- Applications -->
  <div id="appContainer" class="mb-3"></div>

  <!-- Pagination -->
  <nav>
    <ul id="pagination" class="pagination justify-content-center"></ul>
  </nav>
</div>

<!-- Modal -->
<div class="modal fade" id="appModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="appTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="appImage" src="" class="img-fluid mb-3 rounded">
        <div id="appLongDesc"><?= $app['long_description'] ?></div>
        <p class="mt-3"><strong>Price:</strong> ₹<span id="appPrice"></span></p>
        <div class="mt-3">
          <a id="userAppLink" target="_blank" class="btn btn-success me-2">Launch App</a>
          <a id="adminAppLink" target="_blank" class="btn btn-danger" style="display:none;">Launch Admin App</a>
          <a id="whatsappBtn" target="_blank" class="btn btn-success"><i class="bi bi-whatsapp"></i> WhatsApp</a>
          
        </div>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
#searchBox { margin-bottom: 18px; }
#categoryButtons { gap: 10px; }



/* Style the popular category button */
button.btn.category-btn[data-category="popular"] {
    background-color: #f09012ff !important;   /* Pink background */
    color: #fafafafa !important;                  /* White text */
    font-weight: bold !important;            /* Bold font */
    font-size: 1rem !important;              /* Font size */
    border-radius: 0.5rem !important;        /* Rounded corners */
    border: 2px solid #f39913ff !important;    /* Optional border */
    padding: 0.4rem 0.8rem !important;       /* Padding */
    transition: transform 0.2s ease;
}

button.category-btn[data-category="popular"]:hover {
    background-color: #f0a10eff !important;    
    transform: scale(1.05);
    color:  #fff8f8f8 !important;                  /* White text */
;
    border: 2px solid #eba50eff !important;
}

button.category-btn[data-category="wishlist"] {
    background-color: #10bad4ff !important; /* Bootstrap info color */
    color: #fff !important;
    font-weight: bold;
}
button.category-btn[data-category="wishlist"]:hover {
    background-color: #10bad4ff !important;
}

#appImage {
    border: 3px solid #0d6efd;   /* Blue border */
    border-radius: 10px;         /* Smooth corners */
    padding: 4px;                /* Optional inner spacing */
    background-color: #fff;      /* White background for contrast */
}
footer {
    margin-top: 40px;
    text-align: center;
    color: #6c757d;
}

@media (max-width: 768px) {
  h2.text-primary {
    font-size: 1.5rem !important;
  }

  #categoryButtons {
    justify-content: center;
  }

  #searchBox {
    font-size: 0.9rem;
  }

  .app-header {
    text-align: center;
  }

  img[alt="Logo"] {
    max-height: 80px !important;
  }
}



.header {
  background-color: #003366 !important;
}

</style>
<!-- wishlist form -->

<!-- Wishlist Modal -->
<!-- <div class="modal fade" id="wishlistModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Submit Your Wishlist</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="wishlistForm">
          <div class="mb-3">
            <label for="wishlistTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="wishlistTitle" name="title" required>
          </div>
          <div class="mb-3">
            <label for="wishlistDesc" class="form-label">Description</label>
            <textarea class="form-control" id="wishlistDesc" name="description" rows="4" required></textarea>
          </div>
          <button type="submit" class="btn btn-info">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

 <footer class="mt-5 text-center text-muted small">
  <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
  <p>Powered by <span style="color:orange;">Aspire Software Solutions</span></p>
</footer>
</body>
</html>
