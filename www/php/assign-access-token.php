<?php
include 'db.php';
$userId = $_POST["user-id"];
$token = $_POST["token"];
$c->query("UPDATE users SET fcm_access_token='" . $token . "' WHERE id='" . $userId . "'");