<?php
session_start();

$user_id = $_SESSION['user_id'] ?? 0;
include '../config.php';
header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(['status'=>'error','message'=>'Please login']);
    exit;
}

$user_id = $_SESSION['user_id'];
$app_id = (int)($_POST['app_id'] ?? 0);
$action = $_POST['action'] ?? '';

if($app_id <= 0){
    echo json_encode(['status'=>'error','message'=>'Invalid app id']);
    exit;
}

if($action === 'add'){
    $conn->query("INSERT IGNORE INTO popular(user_id, app_id) VALUES ($user_id, $app_id)");
    echo json_encode(['status'=>'success']);
} elseif($action === 'remove'){
    $conn->query("DELETE FROM popular WHERE user_id=$user_id AND app_id=$app_id");
    echo json_encode(['status'=>'success']);
} else {
    echo json_encode(['status'=>'error','message'=>'Invalid action']);
}
