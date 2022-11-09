<?php
include 'session_head.php';

$_SESSION['user_id'] = null;
$_SESSION['name'] = null;

session_destroy();
header('Location: login.php');
exit;