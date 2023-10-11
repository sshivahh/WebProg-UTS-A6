<?php

    require_once('./../Database/db.php');

    $sql = "SELECT * FROM users WHERE username = ?"; //query

    $stmt = $db->prepare($sql); //query prep

    if(!isset($_POST['username'])){
        header("location: ./../Pages/error.php?error=No username input"); //no username input error
    }

    $username = $_POST['username'];

    $temp = $stmt->execute([$username]);
    $data = $temp->fetch(PDO::FETCH_ASSOC); //put data in a variable

    if(!$data){
        header("location: ./../Pages/error.php?error=Username not found"); //username is not in the database
    }

    $password = $_POST['password'];

    if(!password_verify($password, $row['password'])){
        header("location: ./../Pages/error.php?error=Password incorrect"); //password does not match
    }

    //set session
    session_start();
    $_SESSION['username'] = $row['username']; 
    $_SESSION['password'] = $row['password'];

    header('location: ./../Pages/home.php');

?>