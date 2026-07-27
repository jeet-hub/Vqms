<?php

$role = $_SESSION['user']['role_id'];

require_once __DIR__ . "/../../helpers/ModuleHelper.php";

?>

<style>

.sidebar{
    position:fixed;
    top:60px;
    left:0;
    width:250px;
    height:100%;
    background:#212529;
    padding-top:20px;
}

.sidebar a{
    display:block;
    padding:12px 20px;
    color:#fff;
    text-decoration:none;
}

.sidebar a:hover{
    background:#0d6efd;
}

</style>

<div class="sidebar">

<?php if($role==1){ ?>

    <?php if(ModuleHelper::isEnabled('dashboard')){ ?>
    <a href="/vqms/app/views/admin/dashboard.php">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('process')){ ?>
    <a href="/vqms/app/views/admin/processes.php">
        <i class="bi bi-diagram-3"></i>
        Processes
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('teamleader')){ ?>
    <a href="/vqms/app/views/admin/teamleaders.php">
        <i class="bi bi-person-badge"></i>
        Team Leaders
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('employee')){ ?>
    <a href="/vqms/app/views/admin/employees.php">
        <i class="bi bi-people"></i>
        Employees
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('evaluation')){ ?>
    <a href="/vqms/app/views/admin/evaluations.php">
        <i class="bi bi-clipboard-check"></i>
        Evaluations
    </a>
    <?php } ?>
    
     <?php if(ModuleHelper::isEnabled('aof')){ ?>
<a href="/vqms/app/views/admin/aof.php">
    <i class="bi bi-file-earmark-text"></i>
    AOF Management
</a>
<?php } ?>

    <!-- <?php if(ModuleHelper::isEnabled('aof')){ ?>
    <a href="/vqms/app/views/admin/aof_main.php">
        <i class="bi bi-file-earmark-text"></i>
        AOF
    </a>
    <?php } ?> -->

    <!-- <?php if(ModuleHelper::isEnabled('reports')){ ?>
    <a href="/vqms/app/views/admin/reports.php">
        <i class="bi bi-bar-chart"></i>
        Reports
    </a>
    <?php } ?> -->

    <?php if(ModuleHelper::isEnabled('settings')){ ?>
    <a href="/vqms/app/views/admin/settings/index.php">
        <i class="bi bi-gear"></i>
        Settings
    </a>
    <?php } ?>

<?php } ?>


<?php if($role==2){ ?>

    <?php if(ModuleHelper::isEnabled('dashboard')){ ?>
    <a href="/vqms/app/views/teamleader/dashboard.php">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('employee')){ ?>
    <a href="/vqms/app/views/teamleader/employees.php">
        <i class="bi bi-people"></i>
        Employees
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('evaluation')){ ?>
    <a href="/vqms/app/views/teamleader/evaluations.php">
        <i class="bi bi-clipboard-check"></i>
        Evaluations
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('aof')){ ?>
    <a href="/vqms/app/views/teamleader/aof_main.php">
        <i class="bi bi-file-earmark-text"></i>
        AOF
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('reports')){ ?>
<a href="/vqms/app/views/teamleader/reports.php">
    <i class="bi bi-bar-chart"></i>
    Reports
</a>
<?php } ?>

<?php } ?>


<?php if($role==3){ ?>

    <?php if(ModuleHelper::isEnabled('dashboard')){ ?>
    <a href="/vqms/app/views/employee/dashboard.php">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('evaluation')){ ?>
    <a href="/vqms/app/views/employee/evaluations.php">
        <i class="bi bi-clipboard-check"></i>
        My Evaluations
    </a>
    <?php } ?>

    <?php if(ModuleHelper::isEnabled('aof')){ ?>
    <a href="/vqms/app/views/employee/aof.php">
        <i class="bi bi-file-earmark-text"></i>
        My AOF
    </a>
    <?php } ?>

    <a href="/vqms/app/views/employee/profile.php">
        <i class="bi bi-person-circle"></i>
        My Profile
    </a>

<?php } ?>

</div>