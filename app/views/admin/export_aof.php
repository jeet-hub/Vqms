<?php

session_start();

if(!isset($_SESSION['user']))
{
    exit;
}

require_once("../../config/database.php");

$db = new Database();
$conn = $db->connect();

$where = " WHERE 1=1 ";
$params = [];

// Process
if(!empty($_GET['process']))
{
    $where .= " AND process_name=?";
    $params[] = $_GET['process'];
}

// Team Leader
if(!empty($_GET['teamleader']))
{
    $where .= " AND teamleader_id=?";
    $params[] = $_GET['teamleader'];
}

// Employee
if(!empty($_GET['employee']))
{
    $where .= " AND employee_id=?";
    $params[] = $_GET['employee'];
}

// Status
if(!empty($_GET['status']))
{
    $where .= " AND status=?";
    $params[] = $_GET['status'];
}

// From
if(!empty($_GET['from']))
{
    $where .= " AND audit_date>=?";
    $params[] = $_GET['from'];
}

// To
if(!empty($_GET['to']))
{
    $where .= " AND audit_date<=?";
    $params[] = $_GET['to'];
}

$stmt = $conn->prepare("
SELECT *
FROM aof_forms
$where
ORDER BY audit_date DESC,audit_time DESC,id DESC
");

$stmt->execute($params);

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=AOF_Report_".date("Ymd_His").".csv");

$output = fopen("php://output","w");

fputcsv($output,[
    "ID",
    "Audit Date",
    "Audit Time",
    "Process",
    "Employee Code",
    "Employee Name",
    "Team Leader",
    "Ticket ID",
    "Event",
    "Ride Parameter",
    "Status",
    "Observation"
]);

while($row=$stmt->fetch(PDO::FETCH_ASSOC))
{
    fputcsv($output,[
        $row['id'],
        $row['audit_date'],
        $row['audit_time'],
        $row['process_name'],
        $row['employee_code'],
        $row['employee_name'],
        $row['teamleader_name'],
        $row['ticket_id'],
        $row['event_name'],
        $row['ride_parameter'],
        $row['status'],
        $row['chat_observation']
    ]);
}

fclose($output);
exit;