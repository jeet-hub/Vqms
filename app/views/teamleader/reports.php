<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location:../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../config/database.php");

$db = new Database();
$conn = $db->connect();

$process = $_SESSION['user']['process_name'];

$where = " WHERE process_name=? ";
$params = [$process];

if(!empty($_GET['employee']))
{
    $where .= " AND employee_id=?";
    $params[] = $_GET['employee'];
}

if(!empty($_GET['status']))
{
    $where .= " AND status=?";
    $params[] = $_GET['status'];
}

if(!empty($_GET['from_date']))
{
    $where .= " AND audit_date>=?";
    $params[] = $_GET['from_date'];
}

if(!empty($_GET['to_date']))
{
    $where .= " AND audit_date<=?";
    $params[] = $_GET['to_date'];
}

$stmt = $conn->prepare("
SELECT *
FROM aof_forms
$where
ORDER BY audit_date DESC,audit_time DESC,id DESC
");

$stmt->execute($params);

$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$emp = $conn->prepare("
SELECT id,employee_code,fullname
FROM users
WHERE role_id=3
AND process_name=?
ORDER BY fullname
");

$emp->execute([$process]);

$employees = $emp->fetchAll(PDO::FETCH_ASSOC);

// Today's AOF
$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM aof_forms
WHERE process_name=?
AND audit_date=CURDATE()
");
$stmt->execute([$process]);
$todayAOF = $stmt->fetch()['total'];


// Pending
$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM aof_forms
WHERE process_name=?
AND status='Pending'
");
$stmt->execute([$process]);
$pending = $stmt->fetch()['total'];


// Acknowledged
$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM aof_forms
WHERE process_name=?
AND status='Acknowledged'
");
$stmt->execute([$process]);
$ack = $stmt->fetch()['total'];


// Total
$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM aof_forms
WHERE process_name=?
");
$stmt->execute([$process]);
$total = $stmt->fetch()['total'];

?>

<div class="row mb-4">

<div class="col-md-3">

<div class="card border-0 shadow bg-primary text-white">

<div class="card-body">

<h6>Today's AOF</h6>

<h2><?= $todayAOF ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card border-0 shadow bg-warning text-dark">

<div class="card-body">

<h6>Pending</h6>

<h2><?= $pending ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card border-0 shadow bg-success text-white">

<div class="card-body">

<h6>Acknowledged</h6>

<h2><?= $ack ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card border-0 shadow bg-dark text-white">

<div class="card-body">

<h6>Total AOF</h6>

<h2><?= $total ?></h2>

</div>

</div>

</div>

</div>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-dark text-white">

<h4 class="mb-0">

AOF Reports

</h4>

</div>

<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-3">

<label>From Date</label>

<input
type="date"
name="from_date"
value="<?= $_GET['from_date'] ?? '' ?>"
class="form-control">

</div>

<div class="col-md-3">

<label>To Date</label>

<input
type="date"
name="to_date"
value="<?= $_GET['to_date'] ?? '' ?>"
class="form-control">

</div>

<div class="col-md-3">

<label>Employee</label>

<select
name="employee"
class="form-control">

<option value="">All Employees</option>

<?php foreach($employees as $e){ ?>

<option
value="<?= $e['id'] ?>"
<?= (($_GET['employee'] ?? '')==$e['id'])?'selected':''; ?>>

<?= $e['employee_code'] ?> - <?= $e['fullname'] ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-3">

<label>Status</label>

<select
name="status"
class="form-control">

<option value="">All</option>

<option value="Pending">Pending</option>

<option value="Acknowledged">Acknowledged</option>

</select>

</div>

</div>

<br>

<button class="btn btn-primary">

Search

</button>

<a href="reports.php" class="btn btn-secondary">

Reset

</a>

<a href="export_aof.php" class="btn btn-success">

Export Excel

</a>

</form>

<hr>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Date</th>

<th>Employee</th>

<th>Ticket</th>

<th>Event</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php foreach($list as $row){ ?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= date("d-m-Y",strtotime($row['audit_date'])) ?></td>

<td><?= $row['employee_name'] ?></td>

<td><?= $row['ticket_id'] ?></td>

<td><?= $row['event_name'] ?></td>

<td>

<?php if($row['status']=="Pending"){ ?>

<span class="badge bg-warning">

Pending

</span>

<?php }else{ ?>

<span class="badge bg-success">

Acknowledged

</span>

<?php } ?>

</td>

<td>

<a
href="view_aof.php?id=<?= $row['id'] ?>"
class="btn btn-info btn-sm">

View

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php include("../layouts/footer.php"); ?>