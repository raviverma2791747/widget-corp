<?php require_once("./include/functions.php"); ?>

<?php

$_SESSION["admin_id"] = null;
$_SESSION["username"] = null;
session_start();
session_unset();
session_destroy();
redirect("login.php");

?>