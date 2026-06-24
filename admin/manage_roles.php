<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// -------------------------
// Handle Delete
// -------------------------
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $conn->query("DELETE FROM roles WHERE id=$id");
    header("Location: manage_roles.php");
    exit;
}

// -------------------------
// Handle Add Role
// -------------------------
if (isset($_POST['add_role'])) {
    $name = $conn->real_escape_string(trim($_POST['name']));
    if (!empty($name)) {
        $conn->query("INSERT INTO roles (name) VALUES ('$name')");
        header("Location: manage_roles.php");
        exit;
    } else {
        $error = "Role name cannot be empty.";
    }
}

// -------------------------
// Handle Edit Role
// -------------------------
if (isset($_POST['edit_role'])) {
    $id = (int)$_POST['edit_role_id'];
    $name = $conn->real_escape_string(trim($_POST['edit_role_name']));
    if (!empty($name)) {
        $conn->query("UPDATE roles SET name='$name' WHERE id=$id");
        header("Location: manage_roles.php");
        exit;
    } else {
        $error = "Role name cannot be empty.";
    }
}

// -------------------------
// Fetch all roles
// -------------------------
$res = $conn->query("SELECT * FROM roles");

// Include header/navbar/sidebar
include 'main.php';
?>

<div class="container mt-5 pt-5" style="max-width:1200px;">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Roles</h3>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">Add Role</button>
    </div>

    <!-- Error message -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <div style="max-height:500px; overflow-y:auto;">
        <table class='table table-bordered'>
            <thead>
                <tr>
                    <th style="width:80px;">ID</th>
                    <th>Name</th>
                    <th style="width:300px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($r = $res->fetch_assoc()): ?>
                <tr>
                    <td><?= $r['id'] ?></td>
                    <td><?= htmlspecialchars($r['name']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning editRoleBtn" 
                                data-id="<?= $r['id'] ?>" 
                                data-name="<?= htmlspecialchars($r['name'], ENT_QUOTES) ?>" 
                                data-bs-toggle="modal" 
                                data-bs-target="#editRoleModal">
                            Edit
                        </button>
                        <a href="manage_roles.php?del=<?= $r['id'] ?>" 
                           class="btn btn-sm btn-danger" 
                           onclick="return confirm('Delete this role?');">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="mb-3">
              <label>Role Name</label>
              <input type="text" name="name" class="form-control" required>
          </div>
      </div>
      <div class="modal-footer">
          <button type="submit" name="add_role" class="btn btn-success">Add Role</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Role Modal (reusable) -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <input type="hidden" name="edit_role_id" id="edit_role_id">
          <div class="mb-3">
              <label>Role Name</label>
              <input type="text" name="edit_role_name" id="edit_role_name" class="form-control" required>
          </div>
      </div>
      <div class="modal-footer">
          <button type="submit" name="edit_role" class="btn btn-primary">Update Role</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const editButtons = document.querySelectorAll(".editRoleBtn");
    const editRoleId = document.getElementById("edit_role_id");
    const editRoleName = document.getElementById("edit_role_name");

    editButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            editRoleId.value = this.dataset.id;
            editRoleName.value = this.dataset.name;
        });
    });
});
</script>

 <footer class="mt-5">
        <p>© <?= date("Y") ?> Aspire Software Solutions. All rights reserved.</p>
        <p >Powered by <span style="color:orange" >Aspire Software Solutions</span></P>
    </footer>
</body>
</html>