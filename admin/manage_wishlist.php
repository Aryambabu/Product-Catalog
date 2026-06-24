<?php
session_start();
include '../config.php'; // config FIRST – before HTML or output

// BLOCK ACCESS if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

/* ============================
   HANDLE ADD / EDIT (POST)
   ============================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? '';
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $user_id = $_SESSION['user_id'];

    if ($id) {
        // Update wishlist
        $conn->query("UPDATE wishlist SET title='$title', description='$description' WHERE id='$id'");
        $_SESSION['msg'] = "Wishlist updated successfully.";
    } else {
        // Add new wishlist
        $conn->query("INSERT INTO wishlist (user_id, title, description, created_at) 
                      VALUES ('$user_id', '$title', '$description', NOW())");
        $_SESSION['msg'] = "Wishlist added successfully.";
    }

    header("Location: manage_wishlist.php");
    exit();
}

/* ============================
   HANDLE DELETE
   ============================ */
if (isset($_GET['delete'])) {
    $del_id = $_GET['delete'];
    $conn->query("DELETE FROM wishlist WHERE id='$del_id'");
    $_SESSION['msg'] = "Wishlist deleted successfully.";

    header("Location: manage_wishlist.php");
    exit();
}

/* ============================
   FETCH TABLE DATA
   ============================ */
$sql = "SELECT w.*, u.username AS user_name 
        FROM wishlist w
        JOIN users u ON u.id = w.user_id
        ORDER BY w.created_at DESC";

$result = $conn->query($sql);

/* ============================
   FETCH EDIT DATA
   ============================ */
$edit_item = null;
if (isset($_GET['edit'])) {
    $edit_id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM wishlist WHERE id='$edit_id'");
    if ($res->num_rows > 0) {
        $edit_item = $res->fetch_assoc();
    }
}

// Include UI header AFTER all header redirects
include 'main.php';
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Manage Wishlist</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* body { background:#f5f6fa; }
    th { color:#000; font-weight:600; text-transform:uppercase; font-size:14px; }
    .page-header { background:#fff; padding:15px; border-radius:8px; box-shadow:0 0 8px rgba(0,0,0,0.07);  } */
</style>
</head>
<body>
<div class="container mt-5 pt-5" style="max-width:1200px; margin-left:auto; margin-right:450px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Wishlist</h3>
            
</div>
<div class="container mt-4">

    <!-- Header -->


    <!-- Flash Message -->
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success"><?= $_SESSION['msg']; ?></div>
        <?php unset($_SESSION['msg']); ?>
    <?php endif; ?>

    <!-- Add / Edit Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST">

                <input type="hidden" name="id" value="<?= $edit_item['id'] ?? '' ?>">

                <div class="mb-3">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" required
                           value="<?= $edit_item['title'] ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" required><?= $edit_item['description'] ?? '' ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <?= $edit_item ? 'Update Wishlist' : 'Add Wishlist' ?>
                </button>

                <?php if ($edit_item): ?>
                    <a href="manage_wishlist.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>

            </form>
        </div>
    </div>

    <!-- Wishlist Table -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Added On</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this wishlist item?')" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>

            <?php else: ?>
                <tr><td colspan="6" class="text-center text-muted">No wishlist items found.</td></tr>
            <?php endif; ?>
            </tbody>

        </table>
    </div>

</div>

 <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>

</body>
</html>
