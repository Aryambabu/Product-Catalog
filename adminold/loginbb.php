<?php
// session_start();
// include '../config.php';
// if(isset($_POST['login'])){
//     $username = $conn->real_escape_string($_POST['username']);
//     $password = md5($_POST['password']);
//     $q = $conn->query("SELECT u.*, r.name as role_name FROM users u LEFT JOIN roles r ON u.role_id=r.id WHERE u.username='{$username}' AND u.password='{$password}' LIMIT 1");
//     if($q && $q->num_rows){
//         $user = $q->fetch_assoc();
//         $_SESSION['user_id'] = $user['id'];
//         $_SESSION['username'] = $user['username'];
//         $_SESSION['role'] = $user['role_name'];
//         header('Location: dashboard.php'); exit;
//     } else { $error = 'Invalid credentials'; }
// }
?>
<!-- <!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 shadow">
                    <h4 class="mb-3">Admin Login</h4>
                    <?php 

                    // if(!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; 
                    ?>
                    <form method="post"><input name="username" class="form-control mb-2" placeholder="Username"
                            required><input name="password" type="password" class="form-control mb-3"
                            placeholder="Password" required><button class="btn btn-primary w-100"
                            name="login">Login</button></form>
                </div>
            </div>
        </div>
    </div>
</body>

</html> -->



<?php
session_start();
include '../config.php';

$redirect = $_GET['redirect'] ?? '';

if(isset($_POST['login'])){
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']);

    // Preserve redirect after form submit
    $redirect = $_POST['redirect'] ?? '';

    $q = $conn->query("SELECT u.*, r.name as role_name FROM users u 
                       LEFT JOIN roles r ON u.role_id=r.id 
                       WHERE u.username='{$username}' AND u.password='{$password}' 
                       LIMIT 1");

    if($q && $q->num_rows){
        $user = $q->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role_name'];

        // If login requested for wishlist
        if ($redirect === 'wishlist') {
            header("Location: ../wishlist_view.php");
            exit();
        }

        // Default = go to admin dashboard
        header('Location: dashboard.php');
        exit();

    } else {
        $error = 'Invalid credentials';
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card p-4 shadow">
                    <h4 class="mb-3">Admin Login</h4>

                    <?php if(!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?>

                    <form method="post">
                        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect'] ?? ''); ?>">

                        <input name="username" class="form-control mb-2" placeholder="Username" required>
                        <input name="password" type="password" class="form-control mb-3" placeholder="Password" required>

                        <button class="btn btn-primary w-100" name="login">Login</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>

