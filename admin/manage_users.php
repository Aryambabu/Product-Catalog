<?php
session_start();
include '../config.php';

// Only Admin can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin'){
    header('Location: dashboard.php');
    exit;
}

// ---------- Handle Delete ----------
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM users WHERE id={$id}");
    $_SESSION['success'] = "User deleted successfully.";
    header('Location: manage_users.php');
    exit;
}

// ---------- Handle Add ----------
if(isset($_POST['add'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role_id = (int)$_POST['role_id'];

    if($password !== $confirm_password){
        $error = "Passwords do not match.";
    } else {
        $password_hashed = md5($password);
        $conn->query("INSERT INTO users (username,password,role_id) VALUES ('{$username}','{$password_hashed}',{$role_id})");
        $_SESSION['success'] = "User added successfully.";
        header('Location: manage_users.php');
        exit;
    }
}

// ---------- Handle Edit ----------
if(isset($_POST['edit'])){
    $id = (int)$_POST['id'];
    $username = $conn->real_escape_string($_POST['username']);
    $role_id = (int)$_POST['role_id'];

    $sql = "UPDATE users SET username='{$username}', role_id={$role_id}";
    if(!empty($_POST['password'])){
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if($password !== $confirm_password){
            $error = "Passwords do not match.";
        } else {
            $sql .= ", password='".md5($password)."'";
        }
    }
    $sql .= " WHERE id={$id}";

    if(!isset($error)){
        $conn->query($sql);
        $_SESSION['success'] = "User updated successfully.";
        header('Location: manage_users.php');
        exit;
    }
}

// Fetch all users


$users = $conn->query("SELECT u.id,u.username,u.created_at,u.role_id,r.name as role_name 
                       FROM users u LEFT JOIN roles r ON u.role_id=r.id 
                       ORDER BY u.id DESC");

// Fetch roles
$roles = $conn->query("SELECT * FROM roles");
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
<body class='bg-light'>

<div class="container mt-5 pt-5" style="max-width:1200px;">
    <h3>Manage Users</h3>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <!-- Add User Form -->
    <div class="card mb-4">
        <div class="card-header">Add User</div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="id">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role_id" class="form-control">
                        <?php
                        $roles->data_seek(0); // Reset pointer
                        while($r = $roles->fetch_assoc()): ?>
                            <option value="<?=$r['id']?>"><?=htmlspecialchars($r['name'])?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button class="btn btn-success" name="add">Add User</button>
            </form>
        </div>
    </div>

    <!-- Users Table -->
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
                <?php while($row=$users->fetch_assoc()): ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=htmlspecialchars($row['username'])?></td>
                    <td><?=htmlspecialchars($row['role_name'])?></td>
                    <td><?=$row['created_at']?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="editUser(<?=$row['id']?>,'<?=htmlspecialchars($row['username'],ENT_QUOTES)?>',<?=$row['role_id'] ?? 0?>)">Edit</button>
                        <a href="?delete=<?=$row['id']?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete user?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
        <form method="post">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" id="edit_username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>New Password (leave blank to keep)</label>
                    <input type="password" name="password" id="edit_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" id="edit_confirm_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Role</label>
                    <select name="role_id" id="edit_role_id" class="form-control">
                        <?php
                        $roles->data_seek(0); // Reset pointer
                        while($r = $roles->fetch_assoc()): ?>
                            <option value="<?=$r['id']?>"><?=htmlspecialchars($r['name'])?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" name="edit">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function editUser(id, username, role_id){
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_username').value = username;
    document.getElementById('edit_role_id').value = role_id;
    document.getElementById('edit_password').value = '';
    document.getElementById('edit_confirm_password').value = '';
    var modal = new bootstrap.Modal(document.getElementById('editUserModal'));
    modal.show();
}
</script>


 <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>







</body>
</html>
