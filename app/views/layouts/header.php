<?php

if(session_status()==PHP_SESSION_NONE)
{
    session_start();
}

if(!isset($_SESSION['user']))
{
    header("Location: /vqms/login.php");
    exit;
}

require_once __DIR__ . "/../../models/Notification.php";

$user = $_SESSION['user'];

$notification = new Notification();

$user_id = $user['id'];

$count = $notification->getUnreadCount($user_id);

$list = $notification->getByUser($user_id);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Quality Management System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    margin:0;
    background:#f4f6f9;
    font-family:Arial,sans-serif;
}

.topbar{
    height:60px;
    background:#0d6efd;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 20px;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    z-index:999;
}

.content{
    margin-left:250px;
    margin-top:70px;
    padding:20px;
}

.dropdown-menu{
    width:350px;
    max-height:450px;
    overflow:auto;
}

.notification-item:hover{
    background:#f8f9fa;
}

</style>

</head>

<body>

<div class="topbar">

    <h4 class="m-0">
        Quality Management System
    </h4>

    <div class="d-flex align-items-center gap-3">

        <!-- Notification -->

        <div class="dropdown">

            <button
                class="btn btn-light position-relative"
                data-bs-toggle="dropdown">

                <i class="bi bi-bell fs-5"></i>

                <?php if($count>0){ ?>

                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                    <?= $count ?>

                </span>

                <?php } ?>

            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow">

                <li class="dropdown-header fw-bold">

                    Notifications

                </li>

                <li><hr class="dropdown-divider"></li>

                <?php if(count($list)>0){ ?>

                    <?php foreach($list as $row){ ?>

                        <li class="notification-item">

                            <div class="p-3">

                                <strong>

                                    <?= htmlspecialchars($row['title']) ?>

                                </strong>

                                <br>

                                <small>

                                    <?= htmlspecialchars($row['message']) ?>

                                </small>

                                <br>

                                <small class="text-muted">

                                    <?= date("d M Y h:i A",strtotime($row['created_at'])) ?>

                                </small>

                                <div class="mt-2">

                                    <?php if($row['is_read']==0){ ?>

                                    <a
                                        href="/vqms/app/controllers/NotificationController.php?read=<?= $row['id'] ?>"
                                        class="btn btn-success btn-sm">

                                        Read

                                    </a>

                                    <?php } ?>

                                    <a
                                        href="/vqms/app/controllers/NotificationController.php?delete=<?= $row['id'] ?>"
                                        class="btn btn-danger btn-sm">

                                        Delete

                                    </a>

                                </div>

                            </div>

                        </li>

                        <li><hr class="dropdown-divider"></li>

                    <?php } ?>

                <?php } else { ?>

                    <li>

                        <div class="text-center p-3">

                            No Notifications

                        </div>

                    </li>

                <?php } ?>

                <li>

                    <a
                        href="/vqms/app/controllers/NotificationController.php?readall=1"
                        class="dropdown-item text-center fw-bold">

                        Mark All Read

                    </a>

                </li>

            </ul>

        </div>

        <!-- User -->

        <span>

            Welcome,

            <strong>

                <?= htmlspecialchars($user['fullname']) ?>

            </strong>

        </span>

        <!-- Logout -->

        <a
            href="/vqms/logout.php"
            class="btn btn-light btn-sm">

            <i class="bi bi-box-arrow-right"></i>

            Logout

        </a>

    </div>

</div>

<?php include("sidebar.php"); ?>

<div class="content">