<?php

session_start();

$user_id = null;
$username = null;

if (array_key_exists('user_id', $_SESSION) && array_key_exists('name', $_SESSION)) {
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['name'];
}

if(!isset($user_id)){
    include 'login.php';
    exit;
}
