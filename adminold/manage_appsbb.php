<?php 
session_start(); 

// bug number 00001
if(isset($_SESSION['success'])){
    echo "<div class='alert alert-success text-center'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}

include '../config.php'; if(!isset($_SESSION['user_id'])) header('Location: login.php'); ?>
<link rel="stylesheet" href="../css/manage_apps.css">

<?php include 'main.php'; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport' content='width=device-width, initial-scale=1'><title>Manage Apps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js"></script>
    <script>tinymce.init({ selector: 'textarea' });</script>
    <style>
    
    
    .table th {
    background: #764ba2 !important;
    color: #fff;
    text-transform: uppercase;
    font-weight: 600;
    padding: 15px;
    font-size: 0.95rem;
}
    
    
    
    </style>
</head>

<body>
    fxhf
    <div class='bg-light'>
  <div class="container mt-5 pt-5" style="max-width:1200px; margin-left:auto; margin-right:450px; margin-top:150px">
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Applications</h3><a href="add_app.php" class="btn btn-success">Add Application</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (₹)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $res = $conn->query("SELECT * FROM applications ORDER BY created_at DESC"); while($row = $res->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?=$row['id']?>
                    </td>
                    <td>
                        <?=htmlspecialchars($row['name'])?>
                    </td>
                    <td>
                        <?=htmlspecialchars($row['category'])?>
                    </td>
                    <td>
                        <?=number_format($row['price'],2)?>
                    </td>
                    <td><a href="edit_app.php?id=<?=$row['id']?>" class="btn btn-sm btn-warning">Edit</a> <a
                            href="delete_app.php?id=<?=$row['id']?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete app?')">Delete</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table><a href="dashboard.php" class="btn btn-secondary">Back</a>
    </div>
    

     <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>
</body>

</html>
