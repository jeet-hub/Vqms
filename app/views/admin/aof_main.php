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

$process = $_SESSION['user']['process_name'];

/* Total Employees */
$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM users
WHERE role_id=3
AND process_name=?
");
$stmt->execute([$process]);
$totalEmployees = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

/* Active Employees */
$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM users
WHERE role_id=3
AND process_name=?
AND status=1
");
$stmt->execute([$process]);
$activeEmployees = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

/* Total Team Leaders */
$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM users
WHERE role_id=2
");
$stmt->execute();
$totalTL = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>

<div class="container-fluid">

<div class="row mb-4">

<div class="col-md-12">

<h2 class="fw-bold">
<i class="bi bi-speedometer2"></i>
Team Leader Dashboard
</h2>

<p class="text-muted">
Welcome,
<b><?= htmlspecialchars($_SESSION['user']['fullname']); ?></b>
</p>

</div>

</div>

<!-- Dashboard Cards -->

<!-- <div class="row">

<div class="col-md-4 mb-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-muted">
Total Employees
</h6>

<h2 class="text-primary">
<?= $totalEmployees ?>
</h2>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-muted">
Active Employees
</h6>

<h2 class="text-success">
<?= $activeEmployees ?>
</h2>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card shadow border-0">

<div class="card-body">

<h6 class="text-muted">
Assigned Process
</h6>

<h3 class="text-danger">
<?= htmlspecialchars($process) ?>
</h3>

</div>

</div>

</div>

</div> -->

<!-- Quick Actions -->

<div class="row">

<div class="col-lg-12 mb-3">

<div class="card shadow border-0">

<div class="card-header bg-dark text-white">

<h5 class="mb-0">
<i class="bi bi-lightning-charge-fill"></i>
Quick Actions
</h5>

</div>

<div class="card-body">

<div class="d-flex flex-wrap gap-2">

<a href="employees.php" class="btn btn-primary">
<i class="bi bi-people"></i>
Manage Employees
</a>

<a href="aof.php" class="btn btn-success">
<i class="bi bi-clipboard-check"></i>
Add AOF
</a>

<a href="aof_list.php" class="btn btn-info text-white">
<i class="bi bi-file-earmark-text"></i>
View List
</a>

<a href="reports.php" class="btn btn-warning">
<i class="bi bi-bar-chart"></i>
Reports
</a>

<a href="../notifications/index.php" class="btn btn-secondary">
<i class="bi bi-bell"></i>
Notifications
</a>

</div>

</div>

</div>

</div>



</div>

<?php include("../layouts/footer.php"); ?>