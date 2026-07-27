<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../models/Employee.php");

$employee = new Employee();

$list = $employee->byProcess($_SESSION['user']['process_name']);

$auditDate = date("Y-m-d");
$auditTime = date("H:i:s");
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

<div class="row">

<div class="col-md-6">

<label>Audit Date</label>

<input
type="date"
name="audit_date"
class="form-control"
value="<?= $auditDate ?>"
readonly>

</div>

<div class="col-md-6">

<label>Audit Time</label>

<input
type="time"
name="audit_time"
class="form-control"
value="<?= $auditTime ?>"
readonly>

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

<label>Select Employee</label>

<select
name="employee_id"
id="employee_id"
class="form-control"
required>

<option value="">Select Employee</option>

<?php foreach($list as $row){ ?>

<option

value="<?= $row['id']; ?>"

data-name="<?= htmlspecialchars($row['fullname']); ?>"

data-code="<?= htmlspecialchars($row['employee_code']); ?>">

<?= $row['employee_code']; ?>

-

<?= htmlspecialchars($row['fullname']); ?>

</option>

<?php } ?>

</select>

</div>

<div class="col-md-6">

<label>Employee Name</label>

<input

type="text"

id="employee_name"

name="employee_name"

class="form-control"

readonly>

</div>

</div>

<br>

<div class="row">

<div class="col-md-6">

<label>Employee Vertex ID</label>

<input

type="text"

id="employee_code"

name="employee_code"

class="form-control"

readonly>

</div>

<div class="col-md-6">

<label>Team Leader</label>

<input

type="text"

class="form-control"

value="<?= $_SESSION['user']['fullname']; ?>"

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

<div class="row">

<div class="col-md-12">

<label class="fw-bold mb-2">
RIDE Parameter
</label>

<div class="border rounded p-3">

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Ride" required>
<label class="form-check-label">
Ride
</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Reassurance">
<label class="form-check-label">
Reassurance
</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Identify">
<label class="form-check-label">
Identify
</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Deliver">
<label class="form-check-label">
Deliver
</label>
</div>

<div class="form-check">
<input class="form-check-input" type="radio" name="ride_parameter" value="Elevate">
<label class="form-check-label">
Elevate
</label>
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

</div>

</div>

<br>

<div class="row">

<div class="col-md-12">

<label>
Chat Observation
</label>

<textarea
name="chat_observation"
class="form-control"
rows="6"
placeholder="Enter Chat Observation..."
required></textarea>

</div>

</div>

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

<script>

document
.getElementById("employee_id")
.addEventListener("change", function(){

let selected=this.options[this.selectedIndex];

document.getElementById("employee_name").value=
selected.getAttribute("data-name");

document.getElementById("employee_code").value=
selected.getAttribute("data-code");

});

</script>

<?php include("../layouts/footer.php"); ?>