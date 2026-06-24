<?php session_start(); include '../config.php'; 
if(!isset($_SESSION['user_id'])) header('Location: login.php'); 
$res = $conn->query("SELECT u.id,u.username,u.created_at,r.name as role_name FROM users u LEFT JOIN roles r ON u.role_id=r.id ORDER BY u.id DESC");


if($_SESSION['role'] !== 'Admin') {
    header('Location: dashboard.php');  // or redirect to catalog
    exit;
}


?>

<?php include 'main.php'; ?>

<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Manage Users</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>

</head>

<body> 
    
<div class='bg-light'>
  <div class="container mt-5 pt-5" style="max-width:1200px; margin-left:auto; margin-right:450px; margin-top:150px !important; ">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>Users</h3>
      <a href='add_user.php' class='btn btn-success btn-sm'>Add User</a>
    </div>

    <div style="max-height:500px; overflow-y:auto;">
      <table class='table table-bordered'>
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Created</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row=$res->fetch_assoc()): ?>
          <tr>
            <td><?=$row['id']?></td>
            <td><?=htmlspecialchars($row['username'])?></td>
            <td><?=htmlspecialchars($row['role_name'])?></td>
            <td><?=$row['created_at']?></td>
            <td>
              <a href='edit_user.php?id=<?=$row['id']?>' class='btn btn-sm btn-warning'>Edit</a>
              <a href='delete_user.php?id=<?=$row['id']?>' class='btn btn-sm btn-danger' onclick="return confirm('Delete user?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
        </table><a href='dashboard.php' class='btn btn-secondary'>Back</a>
    </div>
    
     <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>
</body>

</html>