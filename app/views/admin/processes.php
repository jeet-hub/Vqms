<?php

session_start();

require_once("../../helpers/AuthHelper.php");

AuthHelper::checkRole([1]);

AuthHelper::checkModule("process");

include("../layouts/header.php");

require_once("../../models/Process.php");

$model = new Process();

$list = $model->all();

?>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h3>Process Management</h3>

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addModal">

            <i class="bi bi-plus-circle"></i>

            Add Process

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


    <table class="table table-bordered table-hover">

        <thead class="table-dark">

        <tr>

            <th width="80">ID</th>

            <th>Process</th>

            <th>Code</th>

            <th>Description</th>

            <th width="120">Status</th>

            <th width="180">Action</th>

        </tr>

        </thead>

        <tbody>

        <?php foreach($list as $row){ ?>

            <tr>

                <td><?= $row['id']; ?></td>

                <td><?= htmlspecialchars($row['process_name']); ?></td>

                <td><?= htmlspecialchars($row['process_code']); ?></td>

                <td><?= htmlspecialchars($row['description']); ?></td>

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

                    <button

                        class="btn btn-warning btn-sm"

                        data-bs-toggle="modal"

                        data-bs-target="#edit<?= $row['id']; ?>">

                        Edit

                    </button>

                    <a

                        href="../../controllers/ProcessController.php?delete=<?= $row['id']; ?>"

                        class="btn btn-danger btn-sm"

                        onclick="return confirm('Delete Process ?')">

                        Delete

                    </a>

                </td>

            </tr>



<!-- ========================= EDIT MODAL ========================= -->

<div

class="modal fade"

id="edit<?= $row['id']; ?>">

<div class="modal-dialog">

<div class="modal-content">

<form

action="../../controllers/ProcessController.php"

method="POST">

<div class="modal-header">

<h5>Edit Process</h5>

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

<label>Process Name</label>

<input

type="text"

name="process_name"

class="form-control mb-3"

value="<?= htmlspecialchars($row['process_name']); ?>"

required>

<label>Process Code</label>

<input

type="text"

name="process_code"

class="form-control mb-3"

value="<?= htmlspecialchars($row['process_code']); ?>">

<label>Description</label>

<textarea

name="description"

class="form-control"><?= htmlspecialchars($row['description']); ?></textarea>

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





<!-- ====================== ADD MODAL ====================== -->

<div

class="modal fade"

id="addModal">

<div class="modal-dialog">

<div class="modal-content">

<form

action="../../controllers/ProcessController.php"

method="POST">

<div class="modal-header">

<h5>Add Process</h5>

<button

class="btn-close"

data-bs-dismiss="modal">

</button>

</div>

<div class="modal-body">

<label>Process Name</label>

<input

type="text"

name="process_name"

class="form-control mb-3"

required>

<label>Process Code</label>

<input

type="text"

name="process_code"

class="form-control mb-3">

<label>Description</label>

<textarea

name="description"

class="form-control"></textarea>

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