<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../../../../login.php");
    exit;
}

include("../../layouts/header.php");

require_once("../../../models/Setting.php");

$model = new Setting();

$modules = $model->getModules();

?>

<div class="container-fluid">

<div class="card shadow">

<div class="card-header bg-dark text-white">

<h4 class="mb-0">

Module Management

</h4>

</div>

<div class="card-body">

<?php

if(isset($_SESSION['success']))
{

?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php

unset($_SESSION['success']);

}

?>

<form
action="../../../controllers/SettingController.php"
method="POST">

<table class="table table-bordered align-middle">

<thead class="table-light">

<tr>

<th width="60">ID</th>

<th>Module</th>

<th width="150">Status</th>

</tr>

</thead>

<tbody>

<?php foreach($modules as $row){ ?>

<tr>

<td>

<?= $row['id']; ?>

</td>

<td>

<strong>

<?= htmlspecialchars($row['display_name']); ?>

</strong>

<br>

<small class="text-muted">

<?= htmlspecialchars($row['module_name']); ?>

</small>

</td>

<td>

<div class="form-check form-switch">

<input
class="form-check-input"
type="checkbox"
name="status[<?= $row['id']; ?>]"
value="1"
<?= ($row['status']==1)?'checked':''; ?>

>

</div>

</td>

</tr>

<?php } ?>

</tbody>

</table>

<button
class="btn btn-primary"
name="saveModule">

Save Changes

</button>

</form>

</div>

</div>

</div>

<?php include("../../layouts/footer.php"); ?>