<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../../login.php");
    exit;
}

include("../layouts/header.php");

require_once("../../config/database.php");

$db = new Database();
$conn = $db->connect();

$userId = $_SESSION['user']['id'];
$process = $_SESSION['user']['process_name'];

/* My Details */
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

/* Placeholder Counts (Evaluation/AOF tables baad me banengi) */
$totalEvaluations = 0;
$averageScore = 0;
$pendingAOF = 0;
?>

<div class="container-fluid">

    <div class="row mb-4">

        <div class="col-md-12">

            <h2>Employee Dashboard</h2>

            <p class="text-muted">

                Welcome,

                <b><?= htmlspecialchars($user['fullname']) ?></b>

            </p>

        </div>

    </div>

    <div class="row">

        <div class="col-md-3 mb-3">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <h6>My Process</h6>

                    <h3 class="text-primary">

                        <?= htmlspecialchars($process) ?>

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <h6>Total Evaluations</h6>

                    <h3 class="text-success">

                        <?= $totalEvaluations ?>

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <h6>Average Score</h6>

                    <h3 class="text-warning">

                        <?= $averageScore ?>%

                    </h3>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-3">

            <div class="card shadow border-0">

                <div class="card-body text-center">

                    <h6>Pending AOF</h6>

                    <h3 class="text-danger">

                        <?= $pendingAOF ?>

                    </h3>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-3">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-header bg-dark text-white">

                    Quick Actions

                </div>

                <div class="card-body">

                    <a href="evaluations.php" class="btn btn-primary">

                        My Evaluations

                    </a>

                    <a href="aof.php" class="btn btn-success">

                        Submit AOF

                    </a>

                    <a href="profile.php" class="btn btn-warning">

                        My Profile

                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    My Information

                </div>

                <div class="card-body">

                    <table class="table table-borderless">

                        <tr>

                            <td><b>Name</b></td>

                            <td><?= htmlspecialchars($user['fullname']) ?></td>

                        </tr>

                        <tr>

                            <td><b>Email</b></td>

                            <td><?= htmlspecialchars($user['email']) ?></td>

                        </tr>

                        <tr>

                            <td><b>Process</b></td>

                            <td><?= htmlspecialchars($user['process_name']) ?></td>

                        </tr>

                        <tr>

                            <td><b>Status</b></td>

                            <td>

                                <?php if($user['status']==1){ ?>

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                <?php } else { ?>

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                <?php } ?>

                            </td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-md-12">

            <div class="card shadow">

                <div class="card-header bg-success text-white">

                    Recent Evaluation Summary

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <thead>

                            <tr>

                                <th>Date</th>

                                <th>Evaluation</th>

                                <th>Score</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td colspan="4" class="text-center text-muted">

                                    No Evaluation Found

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include("../layouts/footer.php"); ?>