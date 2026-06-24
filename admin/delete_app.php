<?php
 session_start(); 
include '../config.php'; 
if(!isset($_SESSION['user_id'])) header('Location: login.php'); 
$id = isset($_GET['id'])? (int)$_GET['id'] : 0; 
if($id){ $r = $conn->query("SELECT image FROM applications WHERE id={$id}"); 
if($r->num_rows){ $row = $r->fetch_assoc(); if(!empty($row['image']) && file_exists('../'.$row['image'])) @unlink('../'.$row['image']);
 } 
 $conn->query("DELETE FROM applications WHERE id={$id}"); } header('Location: manage_apps.php'); exit; ?>