<?php

session_start();

require_once "../models/User.php";

$userModel = new User();


// ===============================
// LOGIN
// ===============================
if(isset($_POST['login']))
{

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($email) || empty($password))
    {
        $_SESSION['error'] = "Email and Password are required.";
        header("Location: ../../login.php");
        exit;
    }

    $user = $userModel->login($email,$password);

    if($user)
    {

        if($user['status'] == 0)
        {
            $_SESSION['error'] = "Your account is inactive.";
            header("Location: ../../login.php");
            exit;
        }

        // Create Session
        $_SESSION['user'] = [

            'id' => $user['id'],

            'role_id' => $user['role_id'],

            'fullname' => $user['fullname'],

            'email' => $user['email'],

            'process_name' => $user['process_name']

        ];



        // =====================
        // ADMIN
        // =====================
        if($user['role_id']==1)
        {
            header("Location: ../views/admin/dashboard.php");
            exit;
        }

        // =====================
        // TEAM LEADER
        // =====================
        if($user['role_id']==2)
        {
            header("Location: ../views/teamleader/dashboard.php");
            exit;
        }

        // =====================
        // EMPLOYEE
        // =====================
        if($user['role_id']==3)
        {
            header("Location: ../views/employee/dashboard.php");
            exit;
        }

    }

    $_SESSION['error']="Invalid Email or Password.";

    header("Location: ../../login.php");

    exit;

}