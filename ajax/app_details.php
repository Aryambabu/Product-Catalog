<?php
include '../config.php';
header('Content-Type: application/json; charset=utf-8');
$id = isset($_POST['id'])? (int)$_POST['id'] : 0;
$q = $conn->query("SELECT * FROM applications WHERE id={$id} LIMIT 1");
$app = $q->fetch_assoc();
if($app){
    echo json_encode($app);
} else { echo json_encode([]); }
?>