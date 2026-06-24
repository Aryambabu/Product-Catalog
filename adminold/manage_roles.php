<?php session_start(); include '../config.php'; if(!isset($_SESSION['user_id'])) header('Location: login.php'); if(isset($_GET['del'])){ $id = (int)$_GET['del']; $conn->query("DELETE FROM roles WHERE id={$id}"); } $res = $conn->query('SELECT * FROM roles');


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
    <title>Roles</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>

<body> 
    <class='bg-light'>
    <div class='bg-light'>
  <div class="container mt-5 pt-5" style="max-width:1200px; margin-left:auto; margin-right:450px; margin-top:150px !important;" >
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Roles</h3><a href='add_role.php' class='btn btn-success'>Add Role</a>
        </div>
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($r=$res->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?=$r['id']?>
                    </td>
                    <td>
                        <?=htmlspecialchars($r['name'])?>
                    </td>
                    <td><a href='edit_role.php?id=<?=$r['id']?>' class='btn btn-sm btn-warning'>Edit</a>
 <a href='manage_roles.php?del=<?=$r['id']?>' class='btn btn-sm btn-danger' onclick="return confirm("Delete role?")">Delete</a>
                            
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