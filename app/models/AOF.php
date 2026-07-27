<?php

require_once __DIR__ . "/../config/database.php";

class AOF
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // ==========================
    // SAVE AOF
    // ==========================

    public function create(
        $employee_id,
        $employee_code,
        $employee_name,
        $teamleader_id,
        $teamleader_name,
        $process_name,
        $audit_date,
        $audit_time,
        $ticket_id,
        $event_name,
        $ride_parameter,
        $chat_observation
    )
    {
        $stmt = $this->conn->prepare("
            INSERT INTO aof_forms
            (
                employee_id,
                employee_code,
                employee_name,
                teamleader_id,
                teamleader_name,
                process_name,
                audit_date,
                audit_time,
                ticket_id,
                event_name,
                ride_parameter,
                chat_observation
            )

            VALUES
            (
                ?,?,?,?,?,?,?,?,?,?,?,?
            )
        ");

        return $stmt->execute([
            $employee_id,
            $employee_code,
            $employee_name,
            $teamleader_id,
            $teamleader_name,
            $process_name,
            $audit_date,
            $audit_time,
            $ticket_id,
            $event_name,
            $ride_parameter,
            $chat_observation
        ]);
    }

    // ==========================
    // ADMIN
    // ==========================

    public function all()
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM aof_forms
            ORDER BY id DESC
        ");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // TEAM LEADER
    // ==========================

    public function byTeamLeader($teamleader_id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM aof_forms
            WHERE teamleader_id=?
            ORDER BY id DESC
        ");

        $stmt->execute([$teamleader_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // EMPLOYEE
    // ==========================

    public function byEmployee($employee_id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM aof_forms
            WHERE employee_id=?
            ORDER BY id DESC
        ");

        $stmt->execute([$employee_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // ==========================
    // SINGLE RECORD
    // ==========================

    public function find($id)
    {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM aof_forms
            WHERE id=?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ==========================
    // ACKNOWLEDGE
    // ==========================

    public function acknowledge($id)
    {
        $stmt = $this->conn->prepare("
            UPDATE aof_forms
            SET
                status='Acknowledged',
                acknowledged_at=NOW()
            WHERE id=?
        ");

        return $stmt->execute([$id]);
    }

// ==========================
// TEAM LEADER ALL AOF
// ==========================

public function getByProcess($process_name)
{
    $stmt = $this->conn->prepare("
        SELECT *
        FROM aof_forms
        WHERE process_name=?
        ORDER BY audit_date DESC,audit_time DESC,id DESC
    ");

    $stmt->execute([$process_name]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// ==========================
// EMPLOYEE HISTORY
// ==========================

public function getByEmployee($employee_id)
{
    $stmt=$this->conn->prepare("
        SELECT *
        FROM aof_forms
        WHERE employee_id=?
        ORDER BY audit_date DESC,audit_time DESC,id DESC
    ");

    $stmt->execute([$employee_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}