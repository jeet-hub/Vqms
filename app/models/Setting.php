<?php

require_once __DIR__ . "/../config/database.php";

class Setting
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // ===========================
    // COMPANY SETTINGS
    // ===========================

    public function getCompany()
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM settings
            LIMIT 1
        ");

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function saveCompany($company,$email,$logo)
    {
        $stmt = $this->conn->prepare("

        UPDATE settings

        SET

        company_name=?,

        company_email=?,

        company_logo=?

        WHERE id=1

        ");

        return $stmt->execute([

            $company,

            $email,

            $logo

        ]);
    }

    // ===========================
    // SMTP
    // ===========================

    public function saveSMTP($host,$port,$email,$password)
    {

        $stmt=$this->conn->prepare("

        UPDATE settings

        SET

        smtp_host=?,

        smtp_port=?,

        smtp_email=?,

        smtp_password=?

        WHERE id=1

        ");

        return $stmt->execute([

            $host,

            $port,

            $email,

            $password

        ]);

    }

    // ===========================
    // MODULES
    // ===========================

    public function getModules()
    {

        $stmt=$this->conn->prepare("

        SELECT *

        FROM modules

        ORDER BY id ASC

        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function updateModule($id,$status)
    {

        $stmt=$this->conn->prepare("

        UPDATE modules

        SET

        status=?

        WHERE id=?

        ");

        return $stmt->execute([

            $status,

            $id

        ]);

    }

    // ===========================
    // SINGLE MODULE
    // ===========================

    public function moduleStatus($module)
    {

        $stmt=$this->conn->prepare("

        SELECT status

        FROM modules

        WHERE module_name=?

        ");

        $stmt->execute([$module]);

        return $stmt->fetchColumn();

    }

}