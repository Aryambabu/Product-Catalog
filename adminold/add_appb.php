

<?php
session_start();

include '../config.php';

// bug number 00001
// Redirect if not logged in
if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
   
if(!isset($_SESSION['user_id'])) header('Location: login.php');

if(isset($_POST['save'])){
  $name = $conn->real_escape_string($_POST['name']);

  // 👇 Updated category logic (handles dropdown + custom input)
  $category = ($_POST['category'] === '__custom__')
    ? $conn->real_escape_string($_POST['custom_category'])
    : $conn->real_escape_string($_POST['category']);

  $short = $conn->real_escape_string($_POST['short_description']);
  $long = $conn->real_escape_string($_POST['content']); // from Summernote
    $price      = floatval($_POST['price']);
    $user_url   = $conn->real_escape_string($_POST['user_app_url']);
    $admin_url  = $conn->real_escape_string($_POST['admin_app_url']);

    $uploadDir = '../assets/uploads/';
    if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    $imgPath = 'assets/uploads/sample1.jpg';

    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $newName = uniqid('app_').'.'.$ext;
        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir.$newName)){
            $imgPath = 'assets/uploads/'.$newName;
        }
    }

    $sql = "INSERT INTO applications 
            (name, category, short_description, long_description, image, price, user_app_url, admin_app_url) 
            VALUES ('$name','$category','$short','$long','$imgPath',$price,'$user_url','$admin_url')";

// bug number 00001
 if($conn->query($sql)){
    $_SESSION['success'] = "✅ Application added successfully!";
    header('Location: manage_apps.php');
    exit;
} else {
    $error = $conn->error;
}



}
?>

<?php include 'main.php'; ?>
<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Add Application</title>

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
        #imagePreview {
            display: none;
            margin-top: 10px;
            max-height: 120px;
        }
    </style>
</head>

<body>
<div class="container mt-4">
  <h3 class="text-center mb-4" style="margin-top:150px !important; margin-top:150px !important;" >Add Application</h3>
  <?php if(!empty($error)) echo "<div class='alert alert-danger'>{$error}</div>"; ?>

  <!-- ✅ Centered and reduced width form -->
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-10"> 
      <form method="post" enctype="multipart/form-data">

        <div class='mb-3'>
            <label>Name</label>
            <input required name='name' class='form-control'>
        </div>

        <div class='mb-3'>
  <label>Category</label>
  <div class="input-group">
    <select id="categorySelect" name="category" class="form-select" required>
      <option value="">Select Category</option>
      <?php
      // Fetch categories dynamically from database
      $catRes = $conn->query("SELECT DISTINCT category FROM applications ORDER BY category ASC");
      if ($catRes->num_rows > 0) {
        while ($catRow = $catRes->fetch_assoc()) {
          echo "<option value='{$catRow['category']}'>{$catRow['category']}</option>";
        }
      }
      ?>
      <option value="__custom__">+ Add Custom Category</option>
    </select>
    <input type="text" id="customCategory" name="custom_category" class="form-control" placeholder="Enter new category" style="display:none;">
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
            <input required name='short_description' class='form-control'>
        </div>

        <!-- Long Description with Paste + Preview -->
        <div class="mb-3">
            <label class="form-label">Long Description</label>
            <div class="mb-2">
                <button type="button" class="btn btn-sm btn-info" onclick="pasteHTML()">📋 Paste HTML</button>
                <button type="button" class="btn btn-sm btn-success" onclick="togglePreview()">👁️ Preview</button>
            </div>
            <textarea id="content" name="content"></textarea>
            <div id="preview-area" class="preview-content" style="display:none;">
                <h5>Preview:</h5>
                <div id="preview-content"></div>
            </div>
        </div>

        <div class='mb-3'>
            <label>Price (INR)</label>
            <input name='price' type='number' step='0.01' class='form-control'>
        </div>

        <div class='mb-3'>
            <label>User App URL</label>
            <input name='user_app_url' class='form-control'>
        </div>

        <div class='mb-3'>
            <label>Admin App URL</label>
            <input name='admin_app_url' class='form-control'>
        </div>

        <div class='mb-3'>
            <label>Grid Image</label>
            <input type='file' name='image' id='imageFile' class='form-control'>
            <img id="imagePreview" class="img-thumbnail">
        </div>

        <button class='btn btn-success' name='save'>Save Application</button>
        <a href='manage_apps.php' class='btn btn-secondary'>Cancel</a>
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

    // Paste HTML button
    window.pasteHTML = function(){
        let htmlContent = prompt("Paste your HTML code here:");
        if(htmlContent){
            $('#content').summernote('pasteHTML', htmlContent);
        }
    }

    // Preview button
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

    // Image preview
    $('#imageFile').change(function(){
        if(this.files && this.files[0]){
            let reader = new FileReader();
            reader.onload = e => $('#imagePreview').attr('src', e.target.result).show();
            reader.readAsDataURL(this.files[0]);
        }
    });
});




</script>
 <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>
</body>
</html>
