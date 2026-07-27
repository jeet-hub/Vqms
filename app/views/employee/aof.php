<?php

session_start();

include("../layouts/header.php");

require_once("../../models/AOF.php");

$model = new AOF();

$list = $model->byEmployee($_SESSION['user']['id']);

?>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">

My AOF

</h4>

</div>

<div class="card-body">

<?php if(isset($_SESSION['success'])){ ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); } ?>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Audit Date</th>

<th>Event</th>

<th>Ticket ID</th>

<th>Status</th>

<th width="180">

Action

</th>

</tr>

</thead>

<tbody>

<?php foreach($list as $row){ ?>

<tr>

<td><?= $row['id'] ?></td>

<td><?= $row['audit_date'] ?></td>

<td><?= htmlspecialchars($row['event_name']) ?></td>

<td><?= htmlspecialchars($row['ticket_id']) ?></td>

<td>

<?php

if($row['status']=="Pending")
{

echo '<span class="badge bg-warning">Pending</span>';

}
else
{

echo '<span class="badge bg-success">Acknowledged</span>';

}

?>

</td>

<td>

<a

href="aof_view.php?id=<?= $row['id'] ?>"

class="btn btn-primary btn-sm">

View

</a>

<?php if($row['status']=="Pending"){ ?>

<a

href="../../controllers/AOFController.php?ack=<?= $row['id'] ?>"

class="btn btn-success btn-sm"

onclick="return confirm('Acknowledge this AOF?')">

Acknowledge

</a>

<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

<?php include("../layouts/footer.php"); ?>