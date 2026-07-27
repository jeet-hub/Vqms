<?php

session_start();

require_once("../models/Setting.php");

$model = new Setting();


// ===============================
// COMPANY SETTINGS
// ===============================

if(isset($_POST['saveCompany']))
{

    $company = trim($_POST['company_name']);
    $email   = trim($_POST['company_email']);

    $logo = "";

    if(isset($_FILES['company_logo']) && $_FILES['company_logo']['name']!="")
    {

        $folder="../../../uploads/logo/";

        if(!is_dir($folder))
        {
            mkdir($folder,0777,true);
        }

        $filename=time()."_".$_FILES['company_logo']['name'];

        move_uploaded_file(
            $_FILES['company_logo']['tmp_name'],
            $folder.$filename
        );

        $logo=$filename;
    }
    else
    {
        $setting=$model->getCompany();
        $logo=$setting['company_logo'];
    }

    $model->saveCompany(

        $company,

        $email,

        $logo

    );

    $_SESSION['success']="Company Settings Saved Successfully.";

    header("Location: ../views/admin/settings/company.php");

    exit;

}



// ===============================
// SMTP SETTINGS
// ===============================

if(isset($_POST['saveSMTP']))
{

    $host=$_POST['smtp_host'];

    $port=$_POST['smtp_port'];

    $email=$_POST['smtp_email'];

    $password=$_POST['smtp_password'];

    $model->saveSMTP(

        $host,

        $port,

        $email,

        $password

    );

    $_SESSION['success']="SMTP Saved Successfully.";

    header("Location: ../views/admin/settings/email.php");

    exit;

}



// ===============================
// MODULE ON/OFF
// ===============================

if(isset($_POST['saveModule']))
{

    $modules = $model->getModules();

    foreach($modules as $module)
    {

        $status = isset($_POST['status'][$module['id']]) ? 1 : 0;

        $model->updateModule($module['id'],$status);

    }

    $_SESSION['success']="Modules Updated Successfully.";

    header("Location: ../views/admin/settings/modules.php");

    exit;

}

?>