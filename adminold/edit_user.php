<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../config.php';

if(!isset($_SESSION['user_id'])) header('Location: login.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id) header('Location: manage_users.php');

$res = $conn->query("SELECT * FROM users WHERE id={$id}");
if(!$res || $res->num_rows === 0){
    die("<div class='alert alert-danger'>User not found.</div>");
}
$user = $res->fetch_assoc();

if(isset($_POST['update'])){
    $username = $conn->real_escape_string($_POST['username']);
    $role_id = isset($_POST['role_id']) ? (int)$_POST['role_id'] : 0;

    if($role_id <= 0){
        die("<div class='alert alert-danger'>Invalid role selected.</div>");
    }

    $sql = "UPDATE users SET username='{$username}', role_id={$role_id}";
    if(!empty($_POST['password'])){
        $password = md5($_POST['password']);
        $sql .= ", password='{$password}'";
    }
    $sql .= " WHERE id={$id}";

    if(!$conn->query($sql)){
        die("<div class='alert alert-danger'>Update failed: ".$conn->error."</div>");
    }

    // ✅ Redirect before any HTML output or include
    header('Location: manage_users.php?success=1');
    exit;
}

// Fetch roles AFTER update logic (safe)
$roles = $conn->query("SELECT * FROM roles");
?>
<?php include 'main.php'; ?>
<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Edit User</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
</head>
<body class='bg-light'>
    <div class="container mt-5 pt-5" style="max-width:600px; margin-top:150px !important;">
        <h3>Edit User</h3>
        <form method='post'>
            <div class='mb-3'>
                <label>Username</label>
                <input name='username' value='<?=htmlspecialchars($user['username'])?>' class='form-control' required>
            </div>

            <div class='mb-3'>
                <label>New Password (leave blank to keep)</label>
                <input type='password' name='password' class='form-control'>
            </div>

            <div class='mb-3'>
                <label>Role</label>
                <select name='role_id' class='form-control' required>
                    <?php while($r = $roles->fetch_assoc()): ?>
                        <option value='<?=$r['id']?>' <?=($r['id']==$user['role_id'])?'selected':''?>>
                            <?=htmlspecialchars($r['name'])?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button class='btn btn-primary' name='update'>Update</button>
            <a href='manage_users.php' class='btn btn-secondary'>Cancel</a>
        </form>
    </div>

    <footer class="mt-5 text-center">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p>Powered by <span style="color:orange;">Aspire Software Solutions</span></p>
    </footer>
</body>
</html>

