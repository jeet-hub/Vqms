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

/* Dashboard Counts */

$totalProcesses = $conn->query("SELECT COUNT(*) FROM processes")->fetchColumn();

$totalTL = $conn->query("SELECT COUNT(*) FROM users WHERE role_id=2")->fetchColumn();

$totalEmployees = $conn->query("SELECT COUNT(*) FROM users WHERE role_id=3")->fetchColumn();

$activeEmployees = $conn->query("SELECT COUNT(*) FROM users WHERE role_id=3 AND status=1")->fetchColumn();

?>
<div class="container-fluid">

<div class="row mb-4">

<div class="col-md-12">

<h2>Admin Dashboard</h2>

<p class="text-muted">

Welcome,

<b><?= htmlspecialchars($_SESSION['user']['fullname']) ?></b>

</p>

</div>

</div>


<div class="row">

<div class="col-lg-3 col-md-6 mb-3">

<div class="card shadow border-0">

<div class="card-body">

<h6>Total Processes</h6>

<h2 class="text-primary">

<?= $totalProcesses ?>

</h2>

</div>

</div>

</div>


<div class="col-lg-3 col-md-6 mb-3">

<div class="card shadow border-0">

<div class="card-body">

<h6>Team Leaders</h6>

<h2 class="text-success">

<?= $totalTL ?>

</h2>

</div>

</div>

</div>


<div class="col-lg-3 col-md-6 mb-3">

<div class="card shadow border-0">

<div class="card-body">

<h6>Total Employees</h6>

<h2 class="text-warning">

<?= $totalEmployees ?>

</h2>

</div>

</div>

</div>


<div class="col-lg-3 col-md-6 mb-3">

<div class="card shadow border-0">

<div class="card-body">

<h6>Active Employees</h6>

<h2 class="text-danger">

<?= $activeEmployees ?>

</h2>

</div>

</div>

</div>

</div>



<div class="row mt-4">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-dark text-white">

Quick Actions

</div>

<div class="card-body">

<a href="processes.php" class="btn btn-primary me-2 mb-2">

Processes

</a>

<a href="teamleaders.php" class="btn btn-success me-2 mb-2">

Team Leaders

</a>

<a href="employees.php" class="btn btn-warning me-2 mb-2">

Employees

</a>

<a href="#" class="btn btn-info me-2 mb-2">

Evaluations

</a>

<a href="#" class="btn btn-secondary me-2 mb-2">

Reports

</a>

<a href="#" class="btn btn-danger me-2 mb-2">

Settings

</a>

</div>

</div>

</div>


<div class="col-md-4">

<div class="card shadow">

<div class="card-header bg-primary text-white">

Admin Information

</div>

<div class="card-body">

<table class="table table-borderless">

<tr>

<td><b>Name</b></td>

<td><?= htmlspecialchars($_SESSION['user']['fullname']) ?></td>

</tr>

<tr>

<td><b>Email</b></td>

<td><?= htmlspecialchars($_SESSION['user']['email']) ?></td>

</tr>

<tr>

<td><b>Role</b></td>

<td>Super Admin</td>

</tr>

<tr>

<td><b>Processes</b></td>

<td><?= $totalProcesses ?></td>

</tr>

<tr>

<td><b>Employees</b></td>

<td><?= $totalEmployees ?></td>

</tr>

</table>

</div>

</div>

</div>

</div>



<div class="row mt-4">

<div class="col-md-6">

<div class="card shadow">

<div class="card-header bg-success text-white">

Latest Team Leaders

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>

<th>Name</th>

<th>Process</th>

</tr>

</thead>

<tbody>

<?php

$stmt=$conn->query("SELECT * FROM users WHERE role_id=2 ORDER BY id DESC LIMIT 5");

foreach($stmt as $row){

?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td><?= htmlspecialchars($row['process_name']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>



<div class="col-md-6">

<div class="card shadow">

<div class="card-header bg-secondary text-white">

Latest Employees

</div>

<div class="card-body">

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>

<th>Name</th>

<th>Process</th>

</tr>

</thead>

<tbody>

<?php

$stmt=$conn->query("SELECT * FROM users WHERE role_id=3 ORDER BY id DESC LIMIT 5");

foreach($stmt as $row){

?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['fullname']) ?></td>

<td><?= htmlspecialchars($row['process_name']) ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>



<div class="row mt-4">

<div class="col-md-12">

<div class="card shadow">

<div class="card-header bg-info text-white">

System Summary

</div>

<div class="card-body">

<div class="row text-center">

<div class="col-md-3">

<h5 class="text-primary">0</h5>

<p>Pending Evaluations</p>

</div>

<div class="col-md-3">

<h5 class="text-success">0%</h5>

<p>Average Quality</p>

</div>

<div class="col-md-3">

<h5 class="text-warning">0</h5>

<p>Pending AOF</p>

</div>

<div class="col-md-3">

<h5 class="text-danger">0</h5>

<p>Today's Audits</p>

</div>

</div>

</div>

</div>

</div>

</div>

<?php include("../layouts/footer.php"); ?>