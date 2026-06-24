<?php session_start(); include '../config.php'; if(!isset($_SESSION['user_id'])) header('Location: login.php'); $id = (int)($_GET['id'] ?? 0); if(!$id) header('Location: manage_roles.php'); $res = $conn->query("SELECT * FROM roles WHERE id=$id"); $role = $res->fetch_assoc(); if(isset($_POST['update'])){ $name = $conn->real_escape_string($_POST['name']); $conn->query("UPDATE roles SET name='{$name}' WHERE id={$id}"); header('Location: manage_roles.php'); exit; } ?>

<?php include 'main.php'; ?>

<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Edit Role</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>

<body class='bg-light'>
    <div class="container mt-5 pt-5" style="max-width:1200px; margin-left:auto; margin-right:450px;">
     <div class='container mt-5 pt-5'>
        <h3>Edit Role</h3>
        <form method='post'>
            <div class='mb-3'><label>Role Name</label><input name='name' class='form-control'
                    value='<?=htmlspecialchars($role['name'])?>'></div><button class='btn btn-primary'
                name='update'>Update</button> <a href='manage_roles.php' class='btn btn-secondary'>Cancel</a>
        </form>
    </div>
     <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>
</body>

</html>