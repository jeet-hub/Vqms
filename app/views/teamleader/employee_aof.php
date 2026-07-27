<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location:../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../models/AOF.php");
require_once("../../models/Employee.php");

if(!isset($_GET['employee_id']))
{
    die("Employee Not Found");
}

$employee_id = $_GET['employee_id'];

$empModel = new Employee();
$employee = $empModel->find($employee_id);

if(!$employee)
{
    die("Employee Not Found");
}

$model = new AOF();

$list = $model->getByEmployee($employee_id);



?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>

<h3>

Employee AOF History

</h3>

<p class="text-muted">

<?= htmlspecialchars($employee['fullname']); ?>

(

<?= htmlspecialchars($employee['employee_code']); ?>

)

</p>

</div>

<a href="employees.php" class="btn btn-secondary">

Back

</a>

</div>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Date</th>

<th>Time</th>

<th>Ticket</th>

<th>Event</th>

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

<td><?= htmlspecialchars($row['ticket_id']); ?></td>

<td><?= htmlspecialchars($row['event_name']); ?></td>

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