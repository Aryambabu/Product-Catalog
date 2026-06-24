<?php session_start(); include '../config.php'; if(!isset($_SESSION['user_id'])) header('Location: login.php'); $roles = $conn->query('SELECT * FROM roles'); if(isset($_POST['create'])){ $username = $conn->real_escape_string($_POST['username']); $password = md5($_POST['password']); $role_id = (int)$_POST['role_id']; $conn->query("INSERT INTO users (username,password,role_id) VALUES ('{$username}','{$password}',{$role_id})"); header('Location: manage_users.php'); exit; } ?>
<?php include 'main.php'; ?>
<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Add User</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>


</head>

<body>


<class='bg-light'>
     <div class="container mt-5 pt-5" style="max-width:1200px; margin-left:auto; margin-right:450px;">
     <div class='container mt-5 pt-5'>
        <h3>Add User</h3>
        <form method='post'>
            <div class='mb-3'><label>Username</label><input name='username' class='form-control' required></div>
            <div class='mb-3'><label>Password</label><input type='password' name='password' class='form-control'
                    required></div>
            <div class='mb-3'><label>Role</label><select name='role_id' class='form-control'>
                    <?php while($r=$roles->fetch_assoc()): ?>
                    <option value='<?=$r['id']?>'>
                        <?=htmlspecialchars($r['name'])?>
                    </option>
                    <?php endwhile; ?>
                </select></div><button class='btn btn-success' name='create'>Create</button> <a href='manage_users.php'
                class='btn btn-secondary'>Cancel</a>
        </form>
    </div>
    
    <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>
</body>

</html>