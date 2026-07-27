<?php
session_start();

if(isset($_SESSION['user']))
{
    if($_SESSION['user']['role_id']==1)
    {
        header("Location: app/views/admin/dashboard.php");
    }

    if($_SESSION['user']['role_id']==2)
    {
        header("Location: app/views/teamleader/dashboard.php");
    }

    if($_SESSION['user']['role_id']==3)
    {
        header("Location: app/views/employee/dashboard.php");
    }

    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>QMS Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{

background:#f5f6fa;

height:100vh;

display:flex;

justify-content:center;

align-items:center;

}

.card{

width:420px;

border:none;

border-radius:15px;

box-shadow:0 10px 30px rgba(0,0,0,.15);

}

.logo{

font-size:30px;

font-weight:bold;

text-align:center;

margin-bottom:10px;

}

</style>

</head>

<body>

<div class="card">

<div class="card-body p-4">

<div class="logo">

QMS

</div>

<h4 class="text-center mb-4">

Quality Management System

</h4>

<?php
if(isset($_SESSION['error']))
{
?>

<div class="alert alert-danger">

<?= $_SESSION['error']; ?>

</div>

<?php

unset($_SESSION['error']);

}

?>

<form

action="app/controllers/AuthController.php"

method="POST">

<div class="mb-3">

<label>Email</label>

<input

type="email"

name="email"

class="form-control"

required>

</div>

<div class="mb-3">

<label>Password</label>

<input

type="password"

name="password"

class="form-control"

required>

</div>

<button

class="btn btn-primary w-100"

name="login">

Login

</button>

</form>

<hr>

<div class="text-center">

Admin

<br>

admin@qms.com

<br>

123456

</div>

</div>

</div>

</body>

</html>