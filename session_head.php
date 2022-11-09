<?php

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    include 'login.php';
    exit;
}
