<?php

    session_start();
    require_once('./../Database/db.php');

    if(!isset($_SESSION['admin'])){
        header('location: home.php');
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM menu WHERE id = ?";

    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "DELETE FROM menu WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);

    unlink("./../Src/Makanan{$data['gambar']}");

    header("location: home.php");

?>