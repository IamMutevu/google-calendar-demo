<?php
require_once 'classes/DatabaseConnection.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

try {
    $connection = DatabaseConnection::connect();
    $query = $connection->prepare("INSERT INTO `users`(name, email, password, created_at, updated_at) VALUES(?, ?, ?, ?, ?)");
    $query->execute(array($name, $email, $password, date("d-m-Y H:i"), date("d-m-Y H:i")));
    $connection = null;

    header('Location: dashboard.php?success=Registration successful');
} catch (PDOException $e) {
    header('Location: signup.php?error='.$e->getMessage());
    // echo $sql . "<br>" . $e->getMessage();
}
