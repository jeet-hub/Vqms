<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location: ../../../../login.php");
    exit;
}

include("../../layouts/header.php");

?>

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>⚙️ System Settings</h2>

</div>

<div class="row">

<!-- Company -->

<div class="col-md-3 mb-4">

<div class="card shadow border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-building fs-1 text-primary"></i>

<h5 class="mt-3">Company</h5>

<p class="text-muted">

Company Details

</p>

<a href="company.php" class="btn btn-primary w-100">

Open

</a>

</div>

</div>

</div>

<!-- Modules -->

<div class="col-md-3 mb-4">

<div class="card shadow border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-grid fs-1 text-success"></i>

<h5 class="mt-3">Modules</h5>

<p class="text-muted">

Enable / Disable

</p>

<a href="modules.php" class="btn btn-success w-100">

Open

</a>

</div>

</div>

</div>

<!-- Email -->

<div class="col-md-3 mb-4">

<div class="card shadow border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-envelope fs-1 text-danger"></i>

<h5 class="mt-3">Email</h5>

<p class="text-muted">

SMTP Configuration

</p>

<a href="email.php" class="btn btn-danger w-100">

Open

</a>

</div>

</div>

</div>

<!-- Notification -->

<div class="col-md-3 mb-4">

<div class="card shadow border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-bell fs-1 text-warning"></i>

<h5 class="mt-3">Notifications</h5>

<p class="text-muted">

Notification Settings

</p>

<a href="notifications.php" class="btn btn-warning w-100">

Open

</a>

</div>

</div>

</div>

<!-- Security -->

<div class="col-md-3 mb-4">

<div class="card shadow border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-shield-lock fs-1 text-info"></i>

<h5 class="mt-3">Security</h5>

<p class="text-muted">

Security Settings

</p>

<a href="security.php" class="btn btn-info w-100">

Open

</a>

</div>

</div>

</div>

<!-- Appearance -->

<div class="col-md-3 mb-4">

<div class="card shadow border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-palette fs-1 text-secondary"></i>

<h5 class="mt-3">Appearance</h5>

<p class="text-muted">

Logo & Theme

</p>

<a href="appearance.php" class="btn btn-secondary w-100">

Open

</a>

</div>

</div>

</div>

<!-- Backup -->

<div class="col-md-3 mb-4">

<div class="card shadow border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-cloud-arrow-down fs-1 text-dark"></i>

<h5 class="mt-3">Backup</h5>

<p class="text-muted">

Backup & Restore

</p>

<a href="backup.php" class="btn btn-dark w-100">

Open

</a>

</div>

</div>

</div>

<!-- General -->

<div class="col-md-3 mb-4">

<div class="card shadow border-0 h-100">

<div class="card-body text-center">

<i class="bi bi-gear fs-1 text-primary"></i>

<h5 class="mt-3">General</h5>

<p class="text-muted">

General Settings

</p>

<a href="general.php" class="btn btn-primary w-100">

Open

</a>

</div>

</div>

</div>

</div>

</div>

<?php include("../../layouts/footer.php"); ?>