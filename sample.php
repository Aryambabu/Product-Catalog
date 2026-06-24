<?php include 'config.php'; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Application Catalog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/styles.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="fw-bold text-primary">Web App Catalog</h2>
    <div>
      <button id="toggleView" class="btn btn-outline-secondary btn-sm">Grid View</button>
      <a href="admin/login.php" class="btn btn-outline-dark btn-sm ms-2">Admin</a>
    </div>
  </div>
  <div class="row mb-3">
    <div class="col-md-8"><input type="text" id="searchBox" class="form-control" placeholder="Search applications..."></div>
    <div class="col-md-4 text-end"><div id="categoryButtons" class="d-inline-block"></div></div>
  </div>
  <div id="appContainer" class="mb-3"></div>
  <nav><ul id="pagination" class="pagination justify-content-center"></ul></nav>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="appModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="appTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="appImage" src="" class="img-fluid mb-3 rounded">
        <div id="appLongDesc"></div>
        <p class="mt-3"><strong>Price:</strong> ₹<span id="appPrice"></span></p>
        <div class="mt-3">
          <a id="userAppLink" target="_blank" class="btn btn-success me-2">Launch User App</a>
          <a id="adminAppLink" target="_blank" class="btn btn-danger">Launch Admin App</a>
        </div>
      </div>
    </div>
  </div>
</div> -->

<script src="assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
