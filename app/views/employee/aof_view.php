<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../models/AOF.php");

$model = new AOF();

$id = $_GET['id'];

$row = $model->find($id);

if(!$row)
{
    die("AOF Not Found");
}

// Security
if($row['employee_id'] != $_SESSION['user']['id'])
{
    die("Access Denied");
}

?>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">
AOF Details
</h4>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<label class="fw-bold">Audit Date</label>

<input
type="text"
class="form-control"
value="<?= $row['audit_date'] ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold">Audit Time</label>

<input
type="text"
class="form-control"
value="<?= $row['audit_time'] ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold">Employee Name</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['employee_name']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold">Employee Vertex ID</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['employee_code']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold">Team Leader</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['teamleader_name']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold">Process</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['process_name']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold">Ticket ID</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['ticket_id']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label class="fw-bold">Event Name</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['event_name']) ?>"
readonly>

</div>

<div class="col-md-12 mb-3">

<label class="fw-bold">RIDE Parameter</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['ride_parameter']) ?>"
readonly>

</div>

<div class="col-md-12 mb-3">

<label class="fw-bold">Chat Observation</label>

<textarea
class="form-control"
rows="6"
readonly><?= htmlspecialchars($row['chat_observation']) ?></textarea>

</div>

<div class="col-md-6">

<label class="fw-bold">Status</label><br>

<?php if($row['status']=="Pending"){ ?>

<span class="badge bg-warning fs-6">
Pending
</span>

<?php }else{ ?>

<span class="badge bg-success fs-6">
Acknowledged
</span>

<?php } ?>

</div>

<div class="col-md-6 text-end">

<?php if($row['status']=="Pending"){ ?>

<a
href="../../controllers/AOFController.php?ack=<?= $row['id'] ?>"
class="btn btn-success"
onclick="return confirm('Are you sure you want to acknowledge this AOF?')">

<i class="bi bi-check-circle"></i>

Acknowledge

</a>

<?php } ?>

</div>

</div>

</div>

</div>

</div>

<?php include("../layouts/footer.php"); ?>