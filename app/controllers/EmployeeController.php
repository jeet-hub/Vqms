<?php

session_start();

require_once "../models/Employee.php";
require_once "../helpers/NotificationHelper.php";
require_once "../helpers/ActivityHelper.php";

$model = new Employee();


// =======================================
// ADD EMPLOYEE
// =======================================

if(isset($_POST['save']))
{

    $role = $_SESSION['user']['role_id'];

if($role == 1)
{
    $process = $_POST['process_name'];
}
else
{
    $process = $_SESSION['user']['process_name'];
}
    $employee_code = trim($_POST['employee_code']);
    $fullname = trim($_POST['fullname']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    if(empty($fullname) || empty($email) || empty($password))
    {
        $_SESSION['error'] = "All fields are required.";

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    }

    if($model->emailExists($email))
    {
        $_SESSION['error'] = "Email already exists.";

        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    }

    // Create Employee

    $employeeId = $model->create(

        $process,

        $employee_code,

        $fullname,

        $email,

        $password

    );



    // Notification

    NotificationHelper::send(

        $_SESSION['user']['id'],

        $employeeId,

        "Welcome",

        "Welcome to Quality Management System.",

        "employee"

    );



    // Activity Log

    ActivityHelper::log(

        "Employee Created",

        "Employee ".$fullname." created successfully."

    );



    $_SESSION['success']="Employee Added Successfully.";

    header("Location: ".$_SERVER['HTTP_REFERER']);

    exit;

}



// =======================================
// UPDATE EMPLOYEE
// =======================================

if(isset($_POST['update']))
{

    $id = $_POST['id'];

    $employee = $model->find($id);

    if(!$employee)
    {
        die("Employee Not Found");
    }

    $role = $_SESSION['user']['role_id'];

    if($role==2)
    {
        if($employee['process_name'] != $_SESSION['user']['process_name'])
        {
            die("Access Denied");
        }

        $process = $_SESSION['user']['process_name'];
    }
    else
    {
        $process = $_POST['process_name'];
    }
    $employee_code = trim($_POST['employee_code']);
    $fullname = trim($_POST['fullname']);

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $model->update(

        $id,

        $process,

        $employee_code,

        $fullname,

        $email,

        $password

    );



    ActivityHelper::log(

        "Employee Updated",

        "Employee ".$fullname." updated."

    );



    $_SESSION['success']="Employee Updated Successfully.";

    header("Location: ".$_SERVER['HTTP_REFERER']);

    exit;

}



// =======================================
// DELETE EMPLOYEE
// =======================================

if(isset($_GET['delete']))
{

    $id = $_GET['delete'];

    $employee = $model->find($id);

    if(!$employee)
    {
        die("Employee Not Found");
    }

    $role = $_SESSION['user']['role_id'];

    if($role==2)
    {
        if($employee['process_name'] != $_SESSION['user']['process_name'])
        {
            die("Access Denied");
        }
    }

    $model->delete($id);



    ActivityHelper::log(

        "Employee Deleted",

        "Employee ".$employee['fullname']." deleted."

    );



    $_SESSION['success']="Employee Deleted Successfully.";

    header("Location: ".$_SERVER['HTTP_REFERER']);

    exit;

}

?>