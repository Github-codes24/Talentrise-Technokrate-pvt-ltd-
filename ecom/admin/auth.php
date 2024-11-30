<?php
if(empty($_SESSION["username"]) || empty($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}
?>