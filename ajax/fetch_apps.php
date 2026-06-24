<?php
session_start();
include '../config.php';
header('Content-Type: application/json; charset=utf-8');

$user_id = $_SESSION['user_id'] ?? 0;

// Pagination & filters
$page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
$per_page = isset($_POST['per_page']) ? (int)$_POST['per_page'] : 6;
$view = $_POST['view'] ?? 'grid';
$category = strtolower($_POST['category'] ?? 'all');
$search = $conn->real_escape_string($_POST['search'] ?? '');

// Build WHERE clause
$where = ' WHERE 1 ';
if($category === 'popular' && $user_id > 0){
    $where = " WHERE id IN (SELECT app_id FROM popular WHERE user_id=$user_id)";
} elseif($category !== 'all') {
    $where .= " AND category='{$conn->real_escape_string($category)}' ";
}

if(!empty($search)){
    $where .= " AND (name LIKE '%{$search}%' OR short_description LIKE '%{$search}%') ";
}

// Total count for pagination
$total_q = "SELECT COUNT(*) as cnt FROM applications $where";
$total_r = $conn->query($total_q);
$total = (int)$total_r->fetch_assoc()['cnt'];
$total_pages = max(1, ceil($total / $per_page));

// Fetch applications
$offset = ($page - 1) * $per_page;
$q = "SELECT * FROM applications $where ORDER BY created_at DESC LIMIT $offset, $per_page";
$res = $conn->query($q);

// Store all rows in an array to use in both views
$apps = [];
while($r = $res->fetch_assoc()){
    $apps[] = $r;
}

// Get popular apps for this user
$popular_apps = [];
if($user_id){
    $w_res = $conn->query("SELECT app_id FROM popular WHERE user_id=$user_id");
    while($w = $w_res->fetch_assoc()){
        $popular_apps[] = $w['app_id'];
    }
}



// Generate HTML
$html = '';

if($view === 'list'){
    $html .= "<table class='table table-striped'><thead><tr><th>Title</th><th>Description</th><th>Action</th></tr></thead><tbody>";
    foreach($apps as $r){
        $id = $r['id'];
        $name = htmlspecialchars($r['name']);
        $short = htmlspecialchars($r['short_description']);
        $heart_class = in_array($id, $popular_apps) ? 'btn-danger' : 'btn-outline-danger';

        $html .= "<tr>
            <td>{$name}</td>
            <td>{$short}</td>
            <td>
                <button class='btn btn-sm btn-primary read-more' data-id='{$id}'>Read More</button>
                <button class='btn btn-sm {$heart_class} popular-btn' data-appid='{$id}'>⭐</button>
            </td>
        </tr>";
    }
    $html .= "</tbody></table>";
} else { // Grid view
    $html .= "<div class='row'>";
    foreach($apps as $r){
        $id = $r['id'];
        $name = htmlspecialchars($r['name']);
        $short = htmlspecialchars($r['short_description']);
        $img = !empty($r['image']) ? $r['image'] : 'assets/uploads/sample1.jpg';
        $heart_class = in_array($id, $popular_apps) ? 'btn-danger' : 'btn-outline-danger';

        $html .= "<div class='col-md-4 mb-3'>
            <div class='card shadow-sm h-100 border border-primary'>
                <img src='{$img}' class='card-img-top' alt='{$name}' style='width:100%; border-bottom:1px solid #dee2e6;'>
                <div class='card-body d-flex flex-column'>
                    <div class='d-flex justify-content-between align-items-start mb-2'>
                        <h5 class='card-title mb-0'>{$name}</h5>
                        <button class='btn btn-sm {$heart_class} popular-btn' data-appid='{$id}'>⭐</button>
                    </div>
                    <p class='card-text'>{$short}</p>
                    <button class='btn btn-sm btn-primary mt-auto read-more' data-id='{$id}'>Read More</button>
                </div>
            </div>
        </div>";
    }
    $html .= "</div>";
}

echo json_encode(['html'=>$html, 'total_pages'=>$total_pages]);

