 <!-- <?php session_start(); include '../config.php'; if(!isset($_SESSION['user_id'])) header('Location: login.php'); $id = isset($_GET['id'])? (int)$_GET['id'] : 0; if(!$id) header('Location: manage_apps.php'); $res = $conn->query("SELECT * FROM applications WHERE id={$id}"); $app = $res->fetch_assoc(); if(isset($_POST['update'])){ $name = $conn->real_escape_string($_POST['name']); $category = $conn->real_escape_string($_POST['category']); $short = $conn->real_escape_string($_POST['short_description']); $long = $conn->real_escape_string($_POST['long_description']); $price = floatval($_POST['price']); $user_url = $conn->real_escape_string($_POST['user_app_url']); $admin_url = $conn->real_escape_string($_POST['admin_app_url']); $imgPath = $app['image']; $uploadDir = '../assets/uploads/'; if(isset($_FILES['image']) && $_FILES['image']['error']==0){ $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); $newName = uniqid('app_').'.'.$ext; if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$newName)){ if(!empty($imgPath) && file_exists('../'.$imgPath) && strpos($imgPath,'assets/uploads/')===0){ @unlink('../'.$imgPath); } $imgPath = 'assets/uploads/'.$newName; } } $sql = "UPDATE applications SET name='{$name}', category='{$category}', short_description='{$short}', long_description='{$long}', image='{$imgPath}', price={$price}, user_app_url='{$user_url}', admin_app_url='{$admin_url}' WHERE id={$id}"; if($conn->query($sql)){ header('Location: manage_apps.php'); exit; } else { $error = $conn->error; } } ?><!doctype html><html><head><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1'><title>Edit App</title><link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'><script src='https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js'></script><script>tinymce.init({selector:'textarea'});</script></head><body><div class='container mt-4'><h3>Edit Application</h3><?php if(!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?><form method='post' enctype='multipart/form-data'><div class='mb-3'><label>Name</label><input required name='name' class='form-control' value='<?=htmlspecialchars($app['name'])?>'></div><div class='mb-3'><label>Category</label><input required name='category' class='form-control' value='<?=htmlspecialchars($app['category'])?>'></div><div class='mb-3'><label>Short Description</label><input required name='short_description' class='form-control' value='<?=htmlspecialchars($app['short_description'])?>'></div><div class='mb-3'><label>Long Description</label><textarea name='long_description' class='form-control' rows='6'><?=htmlspecialchars($app['long_description'])?></textarea></div><div class='mb-3'><label>Price (INR)</label><input name='price' type='number' step='0.01' value='<?=$app['price']?>' class='form-control'></div><div class='mb-3'><label>User App URL</label><input name='user_app_url' value='<?=htmlspecialchars($app['user_app_url'])?>' class='form-control'></div><div class='mb-3'><label>Admin App URL</label><input name='admin_app_url' value='<?=htmlspecialchars($app['admin_app_url'])?>' class='form-control'></div><div class='mb-3'><label>Current Image</label><br><?php if(!empty($app['image'])): ?><img src="../<?=$app['image']?>" class='img-thumbnail mb-2' style='max-height:120px;' /><?php endif; ?><input type='file' name='image' class='form-control'></div><button class='btn btn-primary' name='update'>Update</button><a href='manage_apps.php' class='btn btn-secondary'>Back</a></form></div></body></html> --> 

<?php include 'main.php'; ?>

<?php
// session_start();
include '../config.php';
if(!isset($_SESSION['user_id'])) header('Location: login.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$id) header('Location: manage_apps.php');

$res = $conn->query("SELECT * FROM applications WHERE id={$id}");
$app = $res->fetch_assoc();

if(isset($_POST['update'])){
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $short = $conn->real_escape_string($_POST['short_description']);
    $long = $conn->real_escape_string($_POST['long_description']); //  bug2 edit long description 
    $price = floatval($_POST['price']);
    $user_url = $conn->real_escape_string($_POST['user_app_url']);
    $admin_url = $conn->real_escape_string($_POST['admin_app_url']);

    $imgPath = $app['image'];
    $uploadDir = '../assets/uploads/';

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newName = uniqid('app_').'.'.$ext;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$newName)){
            if(!empty($imgPath) && file_exists('../'.$imgPath) && strpos($imgPath,'assets/uploads/') === 0){
                @unlink('../'.$imgPath);
            }
            $imgPath = 'assets/uploads/'.$newName;
        }
    }

    $sql = "UPDATE applications 
            SET name='{$name}', category='{$category}', short_description='{$short}', long_description='{$long}', 
                image='{$imgPath}', price={$price}, user_app_url='{$user_url}', admin_app_url='{$admin_url}' 
            WHERE id={$id}";

    if($conn->query($sql)){
        header('Location: manage_apps.php');
        exit;
    } else {
        $error = $conn->error;
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Edit Application</title>

    <!-- Bootstrap & Summernote -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <style>
        .preview-content {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 6px;
            margin-top: 10px;
            background: #fff;
        }
    </style>
</head>

<body>
<div class="container mt-5 pt-5" style="max-width:1200px; margin-left:auto; margin-right:450px;">
     <div class='container mt-5 pt-5'>
    <h3>Edit Application</h3>
    <?php if(!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?>

    <form method='post' enctype='multipart/form-data'>
        <div class='mb-3'>
            <label>Name</label>
            <input required name='name' class='form-control' value='<?=htmlspecialchars($app['name'])?>'>
        </div>

        <div class='mb-3'>
    <label>Category</label>
    <div class="input-group">
        <select id="categorySelect" name="category" class="form-select" required>
            <option value="">Select Category</option>
            <?php
            // Fetch all categories from applications table
            $catRes = $conn->query("SELECT DISTINCT category FROM applications ORDER BY category ASC");
            $categories = [];
            while ($catRow = $catRes->fetch_assoc()) {
                $categories[] = $catRow['category'];
                $selected = ($catRow['category'] === $app['category']) ? 'selected' : '';
                echo "<option value='".htmlspecialchars($catRow['category'])."' $selected>".htmlspecialchars($catRow['category'])."</option>";
            }
            ?>
            <option value="__custom__" <?= !in_array($app['category'], $categories) ? 'selected' : '' ?>>+ Add Custom Category</option>
        </select>
        <input type="text" id="customCategory" name="custom_category" class="form-control" placeholder="Enter new category"
               style="display:<?= !in_array($app['category'], $categories) ? 'block' : 'none' ?>;"
               value="<?= !in_array($app['category'], $categories) ? htmlspecialchars($app['category']) : '' ?>">
    </div>
</div>

<script>
$(document).ready(function() {
    $('#categorySelect').change(function() {
        if ($(this).val() === '__custom__') {
            $('#customCategory').show().attr('required', true);
        } else {
            $('#customCategory').hide().attr('required', false);
        }
    });
});
</script>

        <div class='mb-3'>
            <label>Short Description</label>
            <input required name='short_description' class='form-control' value='<?=htmlspecialchars($app['short_description'])?>'>
        </div>

        <!-- Content with Paste HTML + Preview -->
        <div class="mb-3">
            <label class="form-label">Long Description</label>

            <div class="mb-2">
                <button type="button" class="btn btn-sm btn-info" onclick="pasteHTML()">📋 Paste HTML</button>
                <button type="button" class="btn btn-sm btn-success" onclick="togglePreview()">👁️ Preview</button>
            </div>
            
            <!-- bug2 edit long description -->
            <textarea id="content" name="long_description"><?=htmlspecialchars($app['long_description'])?></textarea>

            <div id="preview-area" class="preview-content" style="display:none;">
                <h5>Preview:</h5>
                <div id="preview-content"></div>
            </div>
        </div>

        <div class='mb-3'>
            <label>Price (INR)</label>
            <input name='price' type='number' step='0.01' value='<?=$app['price']?>' class='form-control'>
        </div>

        <div class='mb-3'>
            <label>User App URL</label>
            <input name='user_app_url' value='<?=htmlspecialchars($app['user_app_url'])?>' class='form-control'>
        </div>

        <div class='mb-3'>
            <label>Admin App URL</label>
            <input name='admin_app_url' value='<?=htmlspecialchars($app['admin_app_url'])?>' class='form-control'>
        </div>

        <div class='mb-3'>
            <label>Current Image</label><br>
            <?php if(!empty($app['image'])): ?>
                <img src="../<?=$app['image']?>" class='img-thumbnail mb-2' style='max-height:120px;' />
            <?php endif; ?>
            <input type='file' name='image' class='form-control'>
        </div>

        <button class='btn btn-primary' name='update'>Update</button>
        <a href='manage_apps.php' class='btn btn-secondary'>Back</a>
    </form>
</div>

<script>
$(document).ready(function(){
    // Initialize Summernote
    $('#content').summernote({
        height: 300,
        placeholder: 'Write or paste HTML content here...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview']]
        ]
    });

    // Paste HTML into the editor
    window.pasteHTML = function(){
        let htmlContent = prompt("Paste your HTML code here:");
        if(htmlContent){
            $('#content').summernote('pasteHTML', htmlContent);
        }
    }

    // Toggle preview
    window.togglePreview = function(){
        let previewArea = $('#preview-area');
        if(previewArea.is(':visible')){
            previewArea.hide();
        } else {
            let content = $('#content').summernote('code');
            $('#preview-content').html(content);
            previewArea.show();
        }
    }
});
</script>

<footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>


</body>
</html>
