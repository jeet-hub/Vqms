<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../models/Employee.php");

$model = new Employee();

if(!isset($_GET['employee_id']))
{
    die("Employee Not Found");
}

$employee = $model->find($_GET['employee_id']);

if(!$employee)
{
    die("Employee Not Found");
}

$auditDate = date("Y-m-d");
$auditTime = date("H:i");
?>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h4 class="mb-0">
Rapido AOF Form
</h4>

</div>

<div class="card-body">

<?php if(isset($_SESSION['success'])){ ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); } ?>

<form action="../../controllers/AOFController.php" method="POST">

<input
type="hidden"
name="employee_id"
value="<?= $employee['id']; ?>">

<div class="row">

<div class="col-md-6">

<label>Audit Date</label>

<input
type="date"
name="audit_date"
class="form-control"
value="<?= $auditDate; ?>"
readonly>

</div>

<div class="col-md-6">

<label>Audit Time</label>

<input
type="time"
name="audit_time"
class="form-control"
value="<?= $auditTime; ?>"
readonly>

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

<label>Employee Name</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($employee['fullname']); ?>"
readonly>

</div>

<div class="col-md-6">

<label>Employee Vertex ID</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($employee['employee_code']); ?>"
readonly>

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

<label>Team Leader</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($_SESSION['user']['fullname']); ?>"
readonly>

</div>

<div class="col-md-6">

<label>Process</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($_SESSION['user']['process_name']); ?>"
readonly>

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

<label>Chat / Ticket ID</label>

<input
type="text"
name="ticket_id"
class="form-control"
required>

</div>

<div class="col-md-6">

<label>Event Name</label>

<input
type="text"
name="event_name"
class="form-control"
required>

</div>

</div>

<br>

<label class="fw-bold">
RIDE Parameter
</label>

<div class="border rounded p-3">

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Ride" required>
<label class="form-check-label">Ride</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Reassurance">
<label class="form-check-label">Reassurance</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Identify">
<label class="form-check-label">Identify</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Deliver">
<label class="form-check-label">Deliver</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Elevate">
<label class="form-check-label">Elevate</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="All Above">
<label class="form-check-label text-success fw-bold">
All Above
</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="None of them (AutoFail)">
<label class="form-check-label text-danger fw-bold">
None of them (AutoFail)
</label>
</div>

</div>

<br>

<label>Chat Observation</label>

<textarea
name="chat_observation"
class="form-control"
rows="6"
required></textarea>

<br>

<div class="text-end">

<button
type="submit"
name="save"
class="btn btn-primary btn-lg">

<i class="bi bi-check-circle"></i>

Submit AOF

</button>

</div>

</form>

</div>

</div>

</div>

<?php include("../layouts/footer.php"); ?>