<?php

include("../layouts/header.php");

require_once("../../models/Employee.php");

$model = new Employee();

$process = $_SESSION['user']['process_name'];

$list = $model->byProcess($process);

?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-3">

<h3>

My Employees

</h3>

<button

class="btn btn-primary"

data-bs-toggle="modal"

data-bs-target="#addModal">

<i class="bi bi-plus-circle"></i>

Add Employee

</button>

</div>


<?php if(isset($_SESSION['success'])){ ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); } ?>


<?php if(isset($_SESSION['error'])){ ?>

<div class="alert alert-danger">

<?= $_SESSION['error']; ?>

</div>

<?php unset($_SESSION['error']); } ?>


<div class="alert alert-info">

<b>Assigned Process :</b>

<?= $_SESSION['user']['process_name']; ?>

</div>


<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Employee ID</th>

<th>Name</th>

<th>Email</th>

<th>Status</th>

<th width="180">

Action

</th>

</tr>

</thead>

<tbody>

<?php foreach($list as $row){ ?>

<tr>

<td><?= $row['id']; ?></td>

<td>
    <?= htmlspecialchars($row['employee_code']); ?>
</td>

<td>
    <?= htmlspecialchars($row['fullname']); ?>
</td>

<td>
    <?= htmlspecialchars($row['email']); ?>
</td>

<td>

<?php if($row['status']==1){ ?>

<span class="badge bg-success">

Active

</span>

<?php } else { ?>

<span class="badge bg-danger">

Inactive

</span>

<?php } ?>

</td>

<td>

<a
href="create_aof.php?employee_id=<?= $row['id']; ?>"
class="btn btn-info btn-sm">

AOF

</a>

<a href="employee_aof.php?employee_id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">
    view
</a>
<button

class="btn btn-warning btn-sm"

data-bs-toggle="modal"

data-bs-target="#edit<?= $row['id']; ?>">

Edit

</button>

<a

href="../../controllers/EmployeeController.php?delete=<?= $row['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete Employee?')">

Delete

</a>

</td>

</tr>


<!-- EDIT MODAL -->

<div

class="modal fade"

id="edit<?= $row['id']; ?>">

<div class="modal-dialog">

<div class="modal-content">

<form

action="../../controllers/EmployeeController.php"

method="POST">

<div class="modal-header">

<h5>

Edit Employee

</h5>

<button

class="btn-close"

data-bs-dismiss="modal">

</button>

</div>

<div class="modal-body">

<input

type="hidden"

name="id"

value="<?= $row['id']; ?>">

<label>
Employee ID
</label>

<input
type="text"
name="employee_code"
class="form-control mb-3"
value="<?= htmlspecialchars($row['employee_code']); ?>"
required>

<label>

Full Name

</label>

<input

type="text"

name="fullname"

class="form-control mb-3"

value="<?= $row['fullname']; ?>"

required>

<label>

Email

</label>

<input

type="email"

name="email"

class="form-control"

value="<?= $row['email']; ?>"

required>

</div>

<div class="modal-footer">

<button

class="btn btn-success"

name="update">

Update

</button>

</div>

</form>

</div>

</div>

</div>

<?php } ?>

</tbody>

</table>

</div>


<!-- ADD MODAL -->

<div

class="modal fade"

id="addModal">

<div class="modal-dialog">

<div class="modal-content">

<form

action="../../controllers/EmployeeController.php"

method="POST">

<div class="modal-header">

<h5>

Add Employee

</h5>

<button

class="btn-close"

data-bs-dismiss="modal">

</button>

</div>

<div class="modal-body">

<label>
Employee ID
</label>

<input
type="text"
name="employee_code"
class="form-control mb-3"
placeholder="Example : RPD001"
required>

<label>

Full Name

</label>

<input

type="text"

name="fullname"

class="form-control mb-3"

required>

<label>

Email

</label>

<input

type="email"

name="email"

class="form-control mb-3"

required>

<label>

Password

</label>

<input

type="text"

name="password"

class="form-control"

required>

</div>

<div class="modal-footer">

<button

class="btn btn-primary"

name="save">

Save

</button>

</div>

</form>

</div>

</div>

</div>

<?php include("../layouts/footer.php"); ?>