<?php

require_once __DIR__ . "/../config/database.php";

class Employee
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // ==============================
    // ALL EMPLOYEES (ADMIN)
    // ==============================

    public function all()
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE role_id = 3
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==============================
    // TEAM LEADER EMPLOYEES
    // ==============================

    public function byProcess($process)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM users
            WHERE role_id = 3
            AND process_name = ?
            ORDER BY id DESC
        ");

        $stmt->execute([$process]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==============================
    // CREATE EMPLOYEE
    // ==============================

    public function create($process,$employee_code,$fullname,$email,$password)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO users
            (
                role_id,
                process_name,
                employee_code,
                fullname,
                email,
                password,
                status
            )
            VALUES
            (
                3,
                ?,
                ?,
                ?,
                ?,
                ?,
                1
            )
        ");

        $stmt->execute([
            $process,
            $employee_code,
            $fullname,
            $email,
            $password
        ]);

        return $this->conn->lastInsertId();
    }

    // ==============================
    // FIND EMPLOYEE
    // ==============================

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

    // ==============================
    // UPDATE EMPLOYEE
    // ==============================

    // public function update($id,$process,$employee_code,$fullname,$email)
    // {
    //     $stmt = $this->conn->prepare("
    //         UPDATE users
    //         SET
    //             process_name=?,
    //             employee_code=?,
    //             fullname=?,
    //             email=?
    //         WHERE id=?
    //     ");

    //     return $stmt->execute([
    //         $process,
    //         $employee_code,
    //         $fullname,
    //         $email,
    //         $id
    //     ]);
    // }

    public function update($id,$process,$employee_code,$fullname,$email,$password)
{
    if($password!="")
    {
        $stmt=$this->conn->prepare("
            UPDATE users
            SET
                process_name=?,
                employee_code=?,
                fullname=?,
                email=?,
                password=?
            WHERE id=?
        ");

        return $stmt->execute([
            $process,
            $employee_code,
            $fullname,
            $email,
            $password,
            $id
        ]);
    }
    else
    {
        $stmt=$this->conn->prepare("
            UPDATE users
            SET
                process_name=?,
                employee_code=?,
                fullname=?,
                email=?
            WHERE id=?
        ");

        return $stmt->execute([
            $process,
            $employee_code,
            $fullname,
            $email,
            $id
        ]);
    }
}

    // ==============================
    // DELETE EMPLOYEE
    // ==============================

    public function delete($id)
    {
        $stmt = $this->conn->prepare("
            DELETE FROM users
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

    // ==============================
    // CHECK EMAIL
    // ==============================

    public function emailExists($email)
    {
        $stmt = $this->conn->prepare("
            SELECT id
            FROM users
            WHERE email=?
        ");

        $stmt->execute([$email]);

        return $stmt->rowCount() > 0;
    }

    // ==============================
    // CHECK EMPLOYEE CODE
    // ==============================

    public function employeeCodeExists($employee_code)
    {
        $stmt = $this->conn->prepare("
            SELECT id
            FROM users
            WHERE employee_code=?
        ");

        $stmt->execute([$employee_code]);

        return $stmt->rowCount() > 0;
    }

}