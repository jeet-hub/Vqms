<?php

require_once __DIR__ . "/../config/database.php";

class ModuleHelper
{
    private static $conn = null;

    private static function connect()
    {
        if(self::$conn==null)
        {
            $db=new Database();
            self::$conn=$db->connect();
        }
    }

    public static function isEnabled($module)
    {
        self::connect();

        $stmt=self::$conn->prepare("
            SELECT status
            FROM modules
            WHERE module_name=?
            LIMIT 1
        ");

        $stmt->execute([$module]);

        return $stmt->fetchColumn()==1;
    }

}