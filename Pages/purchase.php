<?php

    session_start();
    require_once("./../Database/db.php");

    if(!isset($_SESSION['user'])){
        header("location: login.php");
    }

    $id_user = $_SESSION['user']['id'];

    $sql = "DELETE FROM cart WHERE id_user = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id_user]);

    header("location: home.php")
?>

