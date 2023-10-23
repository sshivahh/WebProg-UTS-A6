<?php

    session_start();
    require_once('./../Database/db.php');

    if(!isset($_SESSION['admin'])){
        header('location: home.php');
    }

    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $filename = $_FILES['pic']['name'];
    $foto = $filename;
    $foto = "/$category/$filename";
    $temp_file = $_FILES['pic']['tmp_name'];

    $file_ext = explode(".", $filename);
    $file_ext = end($file_ext);
    $file_ext = strtolower($file_ext);

    switch($file_ext){
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'svg':
        case 'webp':
        case 'bmp':
        case 'gif':
            move_uploaded_file($temp_file, "./../Src/Makanan/$category/{$filename}");
            break;
        default: header('location: home.php');
    }

    $sql = "INSERT INTO menu(nama, deskripsi, harga, kategori, gambar) VALUES
            (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $desc, $price, $category, $foto]);

    header('location: home.php');
?>