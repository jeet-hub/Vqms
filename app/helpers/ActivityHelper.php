<?php

require_once __DIR__."/../models/ActivityLog.php";

class ActivityHelper
{

    public static function log($action,$description)
    {
        if(!isset($_SESSION['user']))
        {
            return;
        }

        $model = new ActivityLog();

        $model->save(

            $_SESSION['user']['id'],

            $_SESSION['user']['role_id'],

            $action,

            $description,

            $_SERVER['REMOTE_ADDR']

        );

    }

}