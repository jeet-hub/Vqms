<?php

require_once __DIR__ . "/ModuleHelper.php";

class AuthHelper
{
    public static function checkModule($module)
    {
        if(!ModuleHelper::isEnabled($module))
        {
            header("Location: /vqms/app/views/admin/dashboard.php");
            exit;
        }
    }

    public static function checkRole($roles=[])
    {
        if(!isset($_SESSION['user']))
        {
            header("Location: /vqms/login.php");
            exit;
        }

        if(!in_array($_SESSION['user']['role_id'],$roles))
        {
            die("Access Denied");
        }
    }
}