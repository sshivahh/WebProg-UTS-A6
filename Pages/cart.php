<?php

    session_start();
    require_once("./../Database/db.php");


    if(!isset($_SESSION['user'])){
        session_destroy();
        header("location: login.php");
        exit;
    }

    $id_user = $_SESSION['user']['id'];
    $id_menu = $_GET['id'];

    $sql = "INSERT INTO cart VALUES
            (?, ?)";
    
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_user, $id_menu]);

    header("location: home.php")
    
?>