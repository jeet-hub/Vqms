<?php

require_once __DIR__ . "/../config/database.php";

class Process
{
    private $conn;

    public function __construct()
    {
        $db=new Database();
        $this->conn=$db->connect();
    }

    //=========================
    // All Process
    //=========================

    public function all()
    {
        $stmt=$this->conn->prepare("

            SELECT *

            FROM processes

            ORDER BY id DESC

        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //=========================
    // Insert
    //=========================

    public function create($name,$code,$description)
    {
        $stmt=$this->conn->prepare("

            INSERT INTO processes

            (
                process_name,
                process_code,
                description
            )

            VALUES

            (
                ?,
                ?,
                ?
            )

        ");

        return $stmt->execute([

            $name,

            $code,

            $description

        ]);
    }

    //=========================
    // Single
    //=========================

    public function find($id)
    {
        $stmt=$this->conn->prepare("

            SELECT *

            FROM processes

            WHERE id=?

        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //=========================
    // Update
    //=========================

    public function update($id,$name,$code,$description)
    {
        $stmt=$this->conn->prepare("

            UPDATE processes

            SET

            process_name=?,

            process_code=?,

            description=?

            WHERE id=?

        ");

        return $stmt->execute([

            $name,

            $code,

            $description,

            $id

        ]);
    }

    //=========================
    // Delete
    //=========================

    public function delete($id)
    {
        $stmt=$this->conn->prepare("

            DELETE FROM processes

            WHERE id=?

        ");

        return $stmt->execute([$id]);
    }

}