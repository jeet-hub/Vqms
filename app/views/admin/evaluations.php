<?php
session_start();

require_once("../../helpers/AuthHelper.php");

AuthHelper::checkRole([1]);

AuthHelper::checkModule("evaluation");
?>