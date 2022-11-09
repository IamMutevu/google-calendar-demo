<?php
session_start();

require_once 'classes/DatabaseConnection.php';

$email = $_POST['email'];
$password = $_POST['password'];

try {
    $connection = DatabaseConnection::connect();
    $query = $connection->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $query->execute(array($email));

    $user = $query->fetch(PDO::FETCH_OBJ);

    // echo json_encode($user);
    if($user){
        if($user->password == $password){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['name'] = $user->name;

            header('Location: dashboard.php?success=Login successful');
        }
        else{
            header('Location: login.php?error=Wrong password');
        }
    }
    else{
        header('Location: login.php?error=User does not exist');
    }

} catch (PDOException $e) {
    header('Location: login.php?error='.$e->getMessage());
    // echo $sql . "<br>" . $e->getMessage();
}
