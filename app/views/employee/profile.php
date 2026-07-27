<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../config/database.php");

$db = new Database();
$conn = $db->connect();

$id = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container-fluid">

<div class="row">

<div class="col-md-8 mx-auto">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4>My Profile</h4>

</div>

<div class="card-body">

<?php
if(isset($_SESSION['success'])){
?>
<div class="alert alert-success">
<?= $_SESSION['success']; ?>
</div>
<?php
unset($_SESSION['success']);
}
?>

<form action="../../controllers/ProfileController.php" method="POST">

<input type="hidden" name="id" value="<?= $user['id']; ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label>Full Name</label>

<input
type="text"
name="fullname"
class="form-control"
value="<?= htmlspecialchars($user['fullname']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
class="form-control"
value="<?= htmlspecialchars($user['email']); ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Process</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($user['process_name']); ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Role</label>

<input
type="text"
class="form-control"
value="Employee"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<input
type="text"
class="form-control"
value="<?= ($user['status']==1)?'Active':'Inactive'; ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label>New Password</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Leave blank if no change">

</div>

</div>

<button
class="btn btn-primary"
name="update">

Update Profile

</button>

</form>

</div>

</div>

</div>

</div>

</div>

<?php include("../layouts/footer.php"); ?>