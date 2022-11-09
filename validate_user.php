<?php
require_once 'classes/DatabaseConnection.php';

$name = $_POST['name'];
$password = $_POST['password'];

try {
    $connection = DatabaseConnection::connect();
    $query = $connection->prepare("SELECT * FROM users WHERE email = ?");
    $query->execute(array($email));
    $connection = null;

    header('Location: dashboard.php?success=Login successful');
} catch (PDOException $e) {
    header('Location: login.php?error='.$e->getMessage());
    // echo $sql . "<br>" . $e->getMessage();
}
