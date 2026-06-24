<?php
session_start();
include '../config.php';

// Top 10 categories
$sql = "SELECT category, COUNT(*) as cnt FROM applications GROUP BY category ORDER BY cnt DESC LIMIT 10";
$res = $conn->query($sql);

$html = '';
$html .= "<button class='btn btn-primary me-1 mb-1 category-btn' data-category='all'>All</button>";

while($r = $res->fetch_assoc()){
    $cat = htmlspecialchars($r['category']);
    $html .= "<button class='btn btn-outline-primary me-1 mb-1 category-btn' data-category='".strtolower($cat)."'>$cat</button>";
}

// Always add popular button
$html .= "<button class='btn btn-outline-warning me-1 mb-1 category-btn' data-category='popular'>Popular</button>";

$html .= "<button class='btn btn-outline-info me-1 mb-1 category-btn' data-category='wishlist'>Wishlist</button>";

echo $html;
