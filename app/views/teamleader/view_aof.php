<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location:../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../models/AOF.php");

if(!isset($_GET['id']))
{
    die("Invalid Request");
}

$model = new AOF();

$row = $model->find($_GET['id']);

if(!$row)
{
    die("AOF Not Found");
}

?>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<div class="d-flex justify-content-between">

<h4 class="mb-0">

AOF Details

</h4>

<a href="javascript:history.back()" class="btn btn-light btn-sm">

Back

</a>

</div>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6 mb-3">

<label><b>Audit Date</b></label>

<input
type="text"
class="form-control"
value="<?= date('d-m-Y',strtotime($row['audit_date'])) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label><b>Audit Time</b></label>

<input
type="text"
class="form-control"
value="<?= date('h:i A',strtotime($row['audit_time'])) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label><b>Employee Name</b></label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['employee_name']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label><b>Employee Vertex ID</b></label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['employee_code']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label><b>Team Leader</b></label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['teamleader_name']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label><b>Process</b></label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['process_name']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label><b>Ticket ID</b></label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['ticket_id']) ?>"
readonly>

</div>

<div class="col-md-6 mb-3">

<label><b>Event Name</b></label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['event_name']) ?>"
readonly>

</div>

<div class="col-md-12 mb-3">

<label><b>RIDE Parameter</b></label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($row['ride_parameter']) ?>"
readonly>

</div>

<div class="col-md-12 mb-3">

<label><b>Chat Observation</b></label>

<textarea
class="form-control"
rows="6"
readonly><?= htmlspecialchars($row['chat_observation']) ?></textarea>

</div>

<div class="col-md-6 mb-3">

<label><b>Status</b></label>

<?php if($row['status']=="Pending"){ ?>

<input
type="text"
class="form-control text-warning fw-bold"
value="Pending"
readonly>

<?php } else { ?>

<input
type="text"
class="form-control text-success fw-bold"
value="Acknowledged"
readonly>

<?php } ?>

</div>

<div class="col-md-6 mb-3">

<label><b>Acknowledged At</b></label>

<input
type="text"
class="form-control"
value="<?= !empty($row['acknowledged_at']) ? date('d-m-Y h:i A',strtotime($row['acknowledged_at'])) : '-' ?>"
readonly>

</div>

</div>

</div>

</div>

</div>

<?php include("../layouts/footer.php"); ?>