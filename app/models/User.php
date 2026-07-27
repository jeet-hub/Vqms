<?php

require_once __DIR__ . "/../config/database.php";

class User
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // ===============================
    // LOGIN USER
    // ===============================
    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE email = ?
            LIMIT 1
        ");

        $stmt->execute([$email]);

        if($stmt->rowCount() > 0)
        {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Plain Password (Testing)
            if($user['password'] == $password)
            {
                return $user;
            }
        }

        return false;
    }

    // ===============================
    // FIND USER BY ID
    // ===============================
    public function find($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===============================
    // FIND USER BY EMAIL
    // ===============================
    public function findByEmail($email)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE email = ?
        ");

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===============================
    // CHANGE PASSWORD
    // ===============================
    public function changePassword($id, $password)
    {
        $stmt = $this->conn->prepare("
            UPDATE users
            SET password = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $password,
            $id
        ]);
    }

    // ===============================
    // UPDATE PROFILE
    // ===============================
    public function updateProfile($id, $fullname, $email)
    {
        $stmt = $this->conn->prepare("
            UPDATE users
            SET
                fullname = ?,
                email = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $fullname,
            $email,
            $id
        ]);
    }
}