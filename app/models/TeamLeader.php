<?php

require_once __DIR__ . "/../config/database.php";

class TeamLeader
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // ==========================
    // All Team Leaders
    // ==========================

    public function all()
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE role_id = 2
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // Create Team Leader
    // ==========================

    // public function create($process,$fullname,$email,$password)
    // {
    //     $stmt = $this->conn->prepare("
    //         INSERT INTO users
    //         (
    //             role_id,
    //             process_name,
    //             fullname,
    //             email,
    //             password,
    //             status
    //         )
    //         VALUES
    //         (
    //             2,
    //             ?,
    //             ?,
    //             ?,
    //             ?,
    //             1
    //         )
    //     ");

    //     return $stmt->execute([

    //         $process,

    //         $fullname,

    //         $email,

    //         $password

    //     ]);
    // }

    public function create($process,$name,$email,$password)
{
    $stmt = $this->conn->prepare("
        INSERT INTO users
        (
            role_id,
            process_name,
            fullname,
            email,
            password
        )
        VALUES
        (
            2,?,?,?,?
        )
    ");

    $stmt->execute([
        $process,
        $name,
        $email,
        $password
    ]);

    return $this->conn->lastInsertId();
}

    // ==========================
    // Find
    // ==========================

    public function find($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE id=?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================
    // Update
    // ==========================

    public function update($id,$process,$fullname,$email)
    {
        $stmt = $this->conn->prepare("
            UPDATE users
            SET

            process_name=?,

            fullname=?,

            email=?

            WHERE id=?
        ");

        return $stmt->execute([

            $process,

            $fullname,

            $email,

            $id

        ]);
    }

    // ==========================
    // Delete
    // ==========================

    public function delete($id)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM users
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

}