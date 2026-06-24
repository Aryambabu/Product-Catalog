<?php
include 'config.php';

// Get the app ID from AJAX request
$id = (int)$_POST['id'];

// Fetch the app details
$q = $conn->query("SELECT * FROM applications WHERE id=$id");

// Return app as JSON
$app = $q->fetch_assoc();
echo json_encode($app);
?>
