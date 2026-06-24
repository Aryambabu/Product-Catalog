<?php 
// session_start();
// include 'config.php';

// Dummy user for testing
// if(!isset($_SESSION['user_id'])){
//     $_SESSION['user_id'] = 1;
// }
// $user_id = $_SESSION['user_id'];
// ?>
<!-- <!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> -->
  <!-- <title>Your Wishlist</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-primary fw-bold">My Wishlist</h3>
    <div>
      <a href="index.php" class="btn btn-outline-secondary btn-sm me-2">Back</a>
      <button id="addWishlistBtn" class="btn btn-info btn-sm">+ Add Wishlist</button>
    </div>
  </div> -->

  <!-- Wishlist List -->
  <!-- <div id="wishlistContainer" class="mt-3"></div>
</div> -->

<!-- Add Wishlist Modal -->
<!-- <div class="modal fade" id="wishlistModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Add Wishlist Item</h5>
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
          <button type="submit" class="btn btn-info">Save</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

<!-- Bootstrap JS first, then jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function(){ -->
  // Load wishlist
  // function loadWishlist(){
  //   $.post('ajax/fetch_wishlist.php', {}, function(data){
  //     $('#wishlistContainer').html(data);
  //   }).fail(function(xhr){
  //     $('#wishlistContainer').html('<div class="alert alert-danger">Error loading wishlist.</div>');
  //     console.error(xhr.responseText);
  //   });
  // }

  // loadWishlist();

  // Open Add Modal
  // $('#addWishlistBtn').on('click', function(){
  //   const modal = new bootstrap.Modal(document.getElementById('wishlistModal'));
  //   modal.show();
  // });

  // Submit wishlist form
//   $('#wishlistForm').on('submit', function(e){
//     e.preventDefault();
//     const title = $('#wishlistTitle').val();
//     const description = $('#wishlistDesc').val();

//     $.ajax({
//       url: 'ajax/wishlist_submit.php',
//       type: 'POST',
//       dataType: 'json',
//       data: { title, description },
//       success: function(resp){
//         if(resp.status === 'success'){
//           alert('Wishlist added successfully!');
//           $('#wishlistForm')[0].reset();
//           const modalEl = document.getElementById('wishlistModal');
//           const modalInstance = bootstrap.Modal.getInstance(modalEl);
//           modalInstance.hide();
//           loadWishlist();
//         } else {
//           alert(resp.message || 'Error adding wishlist');
//         }
//       },
//       error: function(xhr){
//         console.error(xhr.responseText);
//       }
//     });
//   });
// });
// </script>

// </body>
// </html>

