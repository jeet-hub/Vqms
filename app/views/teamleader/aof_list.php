<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location:../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../models/AOF.php");

$model=new AOF();

$list=$model->getByProcess($_SESSION['user']['process_name']);

?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3">

<h3>

AOF Management

</h3>

<div>

<a href="employees.php" class="btn btn-success">

New AOF

</a>

<a href="export_aof.php" class="btn btn-primary">

Export Excel

</a>

</div>

</div>

<?php if(isset($_SESSION['success'])){ ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); } ?>

<div class="card shadow">

<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Date</th>

<th>Time</th>

<th>Employee</th>

<th>Employee ID</th>

<th>Ticket</th>

<th>Event</th>

<th>Status</th>

<th width="120">

Action

</th>

</tr>

</thead>

<tbody>

<?php foreach($list as $row){ ?>

<tr>

<td><?= $row['id']; ?></td>

<td><?= date("d-m-Y",strtotime($row['audit_date'])); ?></td>

<td><?= date("h:i A",strtotime($row['audit_time'])); ?></td>

<td><?= htmlspecialchars($row['employee_name']); ?></td>

<td><?= htmlspecialchars($row['employee_code']); ?></td>

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