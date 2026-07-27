<?php

require_once __DIR__.'/../config/database.php';

class PermissionHelper
{

    public static function check($module,$permission)
    {

        $db=new Database();

        $conn=$db->connect();

        $role=$_SESSION['user']['role_id'];

        $stmt=$conn->prepare("

        SELECT *

        FROM role_permissions

        WHERE role_id=?

        AND module_name=?

        ");

        $stmt->execute([$role,$module]);

        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if(!$row)
        {

            die("Permission Denied");

        }

        if($row[$permission]!=1)
        {

            die("Permission Denied");

        }

    }

}