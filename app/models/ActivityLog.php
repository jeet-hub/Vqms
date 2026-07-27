<?php

require_once __DIR__ . "/../config/database.php";

class ActivityLog
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function save($user_id,$role_id,$action,$description,$ip)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO activity_logs
            (
                user_id,
                role_id,
                action,
                description,
                ip_address
            )
            VALUES
            (
                ?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $user_id,
            $role_id,
            $action,
            $description,
            $ip
        ]);
    }

    public function all()
    {
        $stmt = $this->conn->prepare("
            SELECT
                activity_logs.*,
                users.fullname
            FROM activity_logs
            LEFT JOIN users
            ON users.id=activity_logs.user_id
            ORDER BY activity_logs.id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}