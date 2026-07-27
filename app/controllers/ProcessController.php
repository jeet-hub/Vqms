<?php

session_start();

require_once "../models/Process.php";

$model = new Process();


// =====================================
// ADD PROCESS
// =====================================

if(isset($_POST['save']))
{

    $name = trim($_POST['process_name']);
    $code = trim($_POST['process_code']);
    $description = trim($_POST['description']);

    if(empty($name))
    {
        $_SESSION['error'] = "Process Name is required.";
        header("Location: ../views/admin/processes.php");
        exit;
    }

    $model->create($name,$code,$description);

    $_SESSION['success'] = "Process Added Successfully.";

    header("Location: ../views/admin/processes.php");

    exit;

}



// =====================================
// UPDATE PROCESS
// =====================================

if(isset($_POST['update']))
{

    $id = $_POST['id'];

    $name = trim($_POST['process_name']);

    $code = trim($_POST['process_code']);

    $description = trim($_POST['description']);

    if(empty($name))
    {
        $_SESSION['error'] = "Process Name is required.";
        header("Location: ../views/admin/processes.php");
        exit;
    }

    $model->update(

        $id,

        $name,

        $code,

        $description

    );

    $_SESSION['success']="Process Updated Successfully.";

    header("Location: ../views/admin/processes.php");

    exit;

}



// =====================================
// DELETE PROCESS
// =====================================

if(isset($_GET['delete']))
{

    $id=$_GET['delete'];

    $model->delete($id);

    $_SESSION['success']="Process Deleted Successfully.";

    header("Location: ../views/admin/processes.php");

    exit;

}