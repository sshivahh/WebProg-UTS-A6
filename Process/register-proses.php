<?php

    require_once('./../Database/db.php');

    $sql = "SELECT * FROM users WHERE username = ?";

    if(!isset($_POST['username'])){
        header('location: ./../Pages/error.php?error=No username input');
    }
    
    $username = $_POST['username'];
    
    $data = $db->query($sql);
    
    if($data){
        header('location: ./../Pages/error.php?error=Username taken');
    }
    
    if(!isset($_POST['username'])){
        header('location: ./../Pages/error.php?error=No password input');
    }
    $tempPassword = $_POST['password'];

    $password = password_hash($tempPassword, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users(username, password) VALUES
            (?, ?)";

    $stmt = $db->prepare($sql);
    $data = [$username, $password];
    $stmt->execute($data);

    header('location: ./../Pages/login.php');
?>