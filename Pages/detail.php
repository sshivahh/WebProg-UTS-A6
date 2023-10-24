<?php

    require_once('./../Database/db.php');

    $id = $_GET['id'];

    $sql = "SELECT * FROM menu WHERE id = ?";

    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<html>
    <head>
        <link rel="stylesheet" href="./../Styles/home.css" />
        <script defer src="./../Script/app.js"></script>
    </head>
    <body>
        <a href="home.php" ><button class="backBtn">Back</button></a>
        <h1 class="detail-title">Menu Details</h1>
        <div class="detail-container">
            <div class="detail-card detail-right hidden2">
                <div class="detail-namecat">
                    <h1><?= $data['nama']?></h1>
                    <h3><?= $data['kategori']?></h3>
                </div>
            </div>
            <div class="underline hidden2"></div>
            <div class="detail-card detail-right hidden">
                <h2>$<?= $data['harga']?></h2>
            </div>
            <div class="underline hidden"></div>
            <div class="detail-card detail-left hidden2">
                <img src="./../Src/Makanan<?= $data['gambar']?>" alt="" class="detail-img">
            </div>
            <div class="underline hidden2"></div>
            <div class="detail-card detail-left hidden">
                <p><?= $data['deskripsi'];?></p>
            </div>
        </div>
    </body>
</html>
