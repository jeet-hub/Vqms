<?php

session_start();

if(!isset($_SESSION['user']))
{
    header("Location:../../../login.php");
    exit;
}

require_once("../../config/database.php");

$db = new Database();
$conn = $db->connect();

$process = $_SESSION['user']['process_name'];

$stmt = $conn->prepare("
SELECT *
FROM aof_forms
WHERE process_name=?
ORDER BY audit_date DESC,audit_time DESC,id DESC
");

$stmt->execute([$process]);

$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$process."_AOF_".date("Y-m-d").".xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<table border="1">

<tr style="background:#d9d9d9;font-weight:bold;">

<th>Sr No</th>

<th>Audit Date</th>

<th>Audit Time</th>

<th>Employee ID</th>

<th>Employee Name</th>

<th>Team Leader</th>

<th>Process</th>

<th>Ticket ID</th>

<th>Event Name</th>

<th>Ride Parameter</th>

<th>Chat Observation</th>

<th>Status</th>

<th>Acknowledged At</th>

</tr>

<?php

$i=1;

foreach($list as $row)
{

?>

<tr>

<td><?= $i++ ?></td>

<td><?= date("d-m-Y",strtotime($row['audit_date'])) ?></td>

<td><?= date("h:i A",strtotime($row['audit_time'])) ?></td>

<td><?= htmlspecialchars($row['employee_code']) ?></td>

<td><?= htmlspecialchars($row['employee_name']) ?></td>

<td><?= htmlspecialchars($row['teamleader_name']) ?></td>

<td><?= htmlspecialchars($row['process_name']) ?></td>

<td><?= htmlspecialchars($row['ticket_id']) ?></td>

<td><?= htmlspecialchars($row['event_name']) ?></td>

<td><?= htmlspecialchars($row['ride_parameter']) ?></td>

<td><?= htmlspecialchars($row['chat_observation']) ?></td>

<td><?= htmlspecialchars($row['status']) ?></td>

<td>

<?php

if(!empty($row['acknowledged_at']))
{
    echo date("d-m-Y h:i A",strtotime($row['acknowledged_at']));
}
else
{
    echo "-";
}

?>

</td>

</tr>

<?php } ?>

</table>