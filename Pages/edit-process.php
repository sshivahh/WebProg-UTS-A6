<?php

    session_start();
    require_once('./../Database/db.php');


    if(!isset($_SESSION['admin'])){
        header('location: home.php');
    }

    $id = $_GET['id'];
    $nama = $_POST['nama'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    
    echo "$id <br />";
    echo "$nama <br />";
    echo "$desc <br />";
    echo "$price <br />";
    echo "$category <br />";

    $sql = "SELECT * FROM menu WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    var_dump($data);

    if(isset($_FILES['pic']) && $_FILES['pic']['error'] === UPLOAD_ERR_OK){
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
                move_uploaded_file($temp_file, "./../Src/Makanan/{$data['kategori']}/{$filename}");
                break;
            default: header('location: home.php');
        }
    }else{
        $foto = "/$category/{$data['gambar']}";
    }

    echo "datagambar adalah {$data['gambar']} <br>";
    echo "foto adalah $foto";

    $sql = "UPDATE menu
            SET
                nama = ?,
                harga = ?,
                kategori = ?,
                deskripsi = ?,
                gambar = ?
            WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$nama, $price, $category, $desc, $foto, $id]);

    header("location: home.php");
?>