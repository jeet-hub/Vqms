<?php

session_start();

require_once "../models/TeamLeader.php";
require_once "../models/User.php";

require_once "../helpers/NotificationHelper.php";
require_once "../helpers/ActivityHelper.php";

$model = new TeamLeader();
$userModel = new User();


// =======================================
// ADD TEAM LEADER
// =======================================

if(isset($_POST['save']))
{

    $process  = trim($_POST['process_name']);
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($process) || empty($fullname) || empty($email) || empty($password))
    {
        $_SESSION['error']="All fields are required.";

        header("Location: ../views/admin/teamleaders.php");
        exit;
    }

    if($userModel->findByEmail($email))
    {
        $_SESSION['error']="Email already exists.";

        header("Location: ../views/admin/teamleaders.php");
        exit;
    }

    // Create Team Leader

    $teamleaderId = $model->create(

        $process,

        $fullname,

        $email,

        $password

    );



    // Notification

    NotificationHelper::send(

        $_SESSION['user']['id'],

        $teamleaderId,

        "Welcome",

        "Your Team Leader account has been created successfully.",

        "teamleader"

    );



    // Activity Log

    ActivityHelper::log(

        "Team Leader Created",

        "Created Team Leader : ".$fullname

    );



    $_SESSION['success']="Team Leader Added Successfully.";

    header("Location: ../views/admin/teamleaders.php");

    exit;

}



// =======================================
// UPDATE TEAM LEADER
// =======================================

if(isset($_POST['update']))
{

    $id = $_POST['id'];

    $process = trim($_POST['process_name']);

    $fullname = trim($_POST['fullname']);

    $email = trim($_POST['email']);

    if(empty($process) || empty($fullname) || empty($email))
    {
        $_SESSION['error']="All fields are required.";

        header("Location: ../views/admin/teamleaders.php");

        exit;
    }

    $model->update(

        $id,

        $process,

        $fullname,

        $email

    );



    ActivityHelper::log(

        "Team Leader Updated",

        "Updated Team Leader : ".$fullname

    );



    $_SESSION['success']="Team Leader Updated Successfully.";

    header("Location: ../views/admin/teamleaders.php");

    exit;

}



// =======================================
// DELETE TEAM LEADER
// =======================================

if(isset($_GET['delete']))
{

    $id = $_GET['delete'];

    $teamleader = $model->find($id);

    if(!$teamleader)
    {
        die("Team Leader Not Found");
    }

    $model->delete($id);



    ActivityHelper::log(

        "Team Leader Deleted",

        "Deleted Team Leader : ".$teamleader['fullname']

    );



    $_SESSION['success']="Team Leader Deleted Successfully.";

    header("Location: ../views/admin/teamleaders.php");

    exit;

}

?>