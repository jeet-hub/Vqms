<?php

session_start();

require_once "../models/AOF.php";
require_once "../helpers/NotificationHelper.php";
require_once "../helpers/ActivityHelper.php";

$model = new AOF();


// ======================================
// SAVE AOF
// ======================================

if(isset($_POST['save']))
{

    $employee_id       = $_POST['employee_id'];
    $employee_code     = $_POST['employee_code'];
    $employee_name     = $_POST['employee_name'];

    $teamleader_id     = $_SESSION['user']['id'];
    $teamleader_name   = $_SESSION['user']['fullname'];

    $process_name      = $_SESSION['user']['process_name'];

    $audit_date        = $_POST['audit_date'];
    $audit_time        = $_POST['audit_time'];

    $ticket_id         = trim($_POST['ticket_id']);
    $event_name        = trim($_POST['event_name']);

    $ride_parameter    = $_POST['ride_parameter'];

    $chat_observation  = trim($_POST['chat_observation']);



    $model->create(

        $employee_id,
        $employee_code,
        $employee_name,

        $teamleader_id,
        $teamleader_name,

        $process_name,

        $audit_date,
        $audit_time,

        $ticket_id,
        $event_name,

        $ride_parameter,

        $chat_observation

    );



    // Notification

    NotificationHelper::send(

        $teamleader_id,

        $employee_id,

        "New AOF",

        "A new AOF has been submitted for you.",

        "employee"

    );



    // Activity Log

    ActivityHelper::log(

        "AOF Created",

        "AOF submitted for ".$employee_name

    );



    $_SESSION['success']="AOF Submitted Successfully.";

    header("Location: ".$_SERVER['HTTP_REFERER']);

    exit;

}



// ======================================
// EMPLOYEE ACKNOWLEDGE
// ======================================

if(isset($_GET['ack']))
{

    $id=$_GET['ack'];

    $model->acknowledge($id);

    ActivityHelper::log(

        "AOF Acknowledged",

        "Employee acknowledged AOF"

    );

    $_SESSION['success']="AOF Acknowledged Successfully.";

    header("Location: ".$_SERVER['HTTP_REFERER']);

    exit;

}