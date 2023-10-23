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

?>

<html>
    <head>
        <link rel="stylesheet" href="./../Styles/crud.css">
    </head>
    <body>
        <div class="container">
            <h1>Edit Menu</h1>
            <form action="edit-process.php?id=<?= $data['id']?>" method="POST" enctype="multipart/form-data">
                <label for="">Name</label>
                <br>
                <input type="text" value="<?= $data['nama'];?>" name="nama">
                <br>
                <label for="">Description</label>
                <br>
                <input type="text" value="<?= $data['deskripsi'];?>" name="desc">
                <br>
                <label for="">Price</label>
                <br>
                <input type="text" value="<?= $data['harga'];?>" name="price">
                <br>
                <label for="">Category</label>
                <br>
                <input type="text" value="<?= $data['kategori'];?>" name="category">
                <br>
                <label for="">Picture</label>
                <br>
                <input type="file" name="pic">
                <br>
                <button type="submit">Finish</button>
            </form>
        </div>
    </body>
</html>