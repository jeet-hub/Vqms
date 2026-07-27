<?php

session_start();

require_once __DIR__ . "/../models/Notification.php";

$model = new Notification();


// Mark Single Notification Read

if(isset($_GET['read']))
{
    $id = $_GET['read'];

    $model->markAsRead($id);

    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
}


// Mark All Notifications Read

if(isset($_GET['readall']))
{
    $user_id = $_SESSION['user']['id'];

    $model->markAllRead($user_id);

    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
}


// Delete Notification

if(isset($_GET['delete']))
{
    $id = $_GET['delete'];

    $model->delete($id);

    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit;
}