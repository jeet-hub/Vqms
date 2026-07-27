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


// ==========================
// FILTER
// ==========================

$where = " WHERE 1=1 ";
$params = [];

// Process
if(!empty($_GET['process']))
{
    $where .= " AND process_name=?";
    $params[] = $_GET['process'];
}

// Team Leader
if(!empty($_GET['teamleader']))
{
    $where .= " AND teamleader_id=?";
    $params[] = $_GET['teamleader'];
}

// Employee
if(!empty($_GET['employee']))
{
    $where .= " AND employee_id=?";
    $params[] = $_GET['employee'];
}

// Status
if(!empty($_GET['status']))
{
    $where .= " AND status=?";
    $params[] = $_GET['status'];
}

// From Date
if(!empty($_GET['from']))
{
    $where .= " AND audit_date>=?";
    $params[] = $_GET['from'];
}

// To Date
if(!empty($_GET['to']))
{
    $where .= " AND audit_date<=?";
    $params[] = $_GET['to'];
}



// ==========================
// DROPDOWN DATA
// ==========================

$processes = $conn->query("
SELECT DISTINCT process_name
FROM aof_forms
ORDER BY process_name
")->fetchAll(PDO::FETCH_ASSOC);

$teamleaders = $conn->query("
SELECT DISTINCT teamleader_id,teamleader_name
FROM aof_forms
ORDER BY teamleader_name
")->fetchAll(PDO::FETCH_ASSOC);

$employees = $conn->query("
SELECT DISTINCT employee_id,employee_name,employee_code
FROM aof_forms
ORDER BY employee_name
")->fetchAll(PDO::FETCH_ASSOC);



// ==========================
// MAIN LIST
// ==========================

$stmt = $conn->prepare("
SELECT *
FROM aof_forms
$where
ORDER BY audit_date DESC,audit_time DESC,id DESC
");

$stmt->execute($params);

$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3">

<h3>All AOF Management</h3>

<!-- <a href="export_aof.php" class="btn btn-success">
<i class="bi bi-download"></i>
Export Excel
</a> -->

<a
href="export_aof.php?<?= http_build_query($_GET); ?>"
class="btn btn-success">

<i class="bi bi-download"></i>

Export Excel

</a>

</div>

<?php
// ==========================
// DASHBOARD CARDS
// ==========================

// Total AOF
$totalAOF = $conn->query("
SELECT COUNT(*) total
FROM aof_forms
")->fetch()['total'];

// Today's AOF
$todayAOF = $conn->query("
SELECT COUNT(*) total
FROM aof_forms
WHERE audit_date=CURDATE()
")->fetch()['total'];

// Pending
$pending = $conn->query("
SELECT COUNT(*) total
FROM aof_forms
WHERE status='Pending'
")->fetch()['total'];

// Acknowledged
$ack = $conn->query("
SELECT COUNT(*) total
FROM aof_forms
WHERE status='Acknowledged'
")->fetch()['total'];

// Employees
$employees = $conn->query("
SELECT COUNT(DISTINCT employee_id) total
FROM aof_forms
")->fetch()['total'];

// Team Leaders
$teamleaders = $conn->query("
SELECT COUNT(DISTINCT teamleader_id) total
FROM aof_forms
")->fetch()['total'];

?>

<div class="row mb-4">

<div class="col-md-2">

<div class="card bg-primary text-white shadow">

<div class="card-body text-center">

<h6>Total AOF</h6>

<h2><?= $totalAOF ?></h2>

</div>

</div>

</div>

<div class="col-md-2">

<div class="card bg-success text-white shadow">

<div class="card-body text-center">

<h6>Today's</h6>

<h2><?= $todayAOF ?></h2>

</div>

</div>

</div>

<div class="col-md-2">

<div class="card bg-warning shadow">

<div class="card-body text-center">

<h6>Pending</h6>

<h2><?= $pending ?></h2>

</div>

</div>

</div>

<div class="col-md-2">

<div class="card bg-info text-white shadow">

<div class="card-body text-center">

<h6>Acknowledged</h6>

<h2><?= $ack ?></h2>

</div>

</div>

</div>

<div class="col-md-2">

<div class="card bg-dark text-white shadow">

<div class="card-body text-center">

<h6>Employees</h6>

<h2><?= $employees ?></h2>

</div>

</div>

</div>

<div class="col-md-2">

<div class="card bg-secondary text-white shadow">

<div class="card-body text-center">

<h6>Team Leaders</h6>

<h2><?= $teamleaders ?></h2>

</div>

</div>

</div>

</div>

<div class="card shadow">



<div class="card-body">

<form method="GET">

<div class="row">

<div class="col-md-2">

<label>Process</label>

<select name="process" class="form-control">

<option value="">All</option>

<?php foreach($processes as $p){ ?>

<option
value="<?= $p['process_name']; ?>"
<?= (($_GET['process'] ?? '')==$p['process_name'])?'selected':''; ?>>

<?= $p['process_name']; ?>

</option>

<?php } ?>

</select>

</div>



<div class="col-md-2">

<label>Team Leader</label>

<select name="teamleader" class="form-control">

<option value="">All</option>

<?php foreach($teamleaders as $t){ ?>

<option
value="<?= $t['teamleader_id']; ?>"
<?= (($_GET['teamleader'] ?? '')==$t['teamleader_id'])?'selected':''; ?>>

<?= $t['teamleader_name']; ?>

</option>

<?php } ?>

</select>

</div>



<div class="col-md-2">

<label>Employee</label>

<select name="employee" class="form-control">

<option value="">All</option>

<?php foreach($employees as $e){ ?>

<option
value="<?= $e['employee_id']; ?>"
<?= (($_GET['employee'] ?? '')==$e['employee_id'])?'selected':''; ?>>

<?= $e['employee_code']; ?>

-

<?= $e['employee_name']; ?>

</option>

<?php } ?>

</select>

</div>



<div class="col-md-2">

<label>Status</label>

<select name="status" class="form-control">

<option value="">All</option>

<option
value="Pending"
<?= (($_GET['status'] ?? '')=="Pending")?'selected':''; ?>>

Pending

</option>

<option
value="Acknowledged"
<?= (($_GET['status'] ?? '')=="Acknowledged")?'selected':''; ?>>

Acknowledged

</option>

</select>

</div>



<div class="col-md-2">

<label>From Date</label>

<input
type="date"
name="from"
value="<?= $_GET['from'] ?? ''; ?>"
class="form-control">

</div>



<div class="col-md-2">

<label>To Date</label>

<input
type="date"
name="to"
value="<?= $_GET['to'] ?? ''; ?>"
class="form-control">

</div>

</div>

<br>

<button class="btn btn-primary">

<i class="bi bi-search"></i>

Search

</button>

<a href="aof.php" class="btn btn-secondary">

Reset

</a>

</form>

<hr>

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Date</th>

<th>Time</th>

<th>Process</th>

<th>Employee</th>

<th>Employee ID</th>

<th>Team Leader</th>

<th>Ticket</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php foreach($list as $row){ ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= date("d-m-Y",strtotime($row['audit_date'])); ?></td>

<td><?= date("h:i A",strtotime($row['audit_time'])); ?></td>

<td><?= htmlspecialchars($row['process_name']); ?></td>

<td><?= htmlspecialchars($row['employee_name']); ?></td>

<td><?= htmlspecialchars($row['employee_code']); ?></td>

<td><?= htmlspecialchars($row['teamleader_name']); ?></td>

<td><?= htmlspecialchars($row['ticket_id']); ?></td>

<td>

<?php if($row['status']=="Pending"){ ?>

<span class="badge bg-warning">

Pending

</span>

<?php } else { ?>

<span class="badge bg-success">

Acknowledged

</span>

<?php } ?>

</td>

<td>

<a
href="view_aof.php?id=<?= $row['id']; ?>"
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