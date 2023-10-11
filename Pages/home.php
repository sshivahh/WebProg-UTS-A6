<?php

    require_once('./../Database/db.php');
    $sql = "SELECT * FROM menu";

    $data = $db->query($sql);

    session_start();
?>

<html>
    <head>
        <title>IF330-A6</title>
        <link rel="stylesheet" href="./../Styles/home.css" />
    </head>
    <body>
        <nav>
            <div class="logo">
                <h2 class="logo-blue">IF330<h2>-A6</h2></h2>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search Menu or Categories"/>
                <button>
                    <img src="./../Src/Icons/Search.png" alt="search" />
                </button>
            </div>
            <div class='profile'>
                <?php 
                    if(isset($_SESSION['user'])){
                        ?>
                    <h2 class="profile-name"><?= $_SESSION['user']['name']?></h2>
                    <?php
                    }
                    elseif(isset($_SESSION['admin'])){
                        ?>
                        <h2 class="profile-name"><?= $_SESSION['admin']['name']?></h2>
                        <?php
                    }
                    else{
                        ?>
                        <a href="login.php">
                            <button class='login-button'>Log in</button>
                        </a>
                    <?php
                    }
                    ?>
            </div>
        </nav>
            <table class="menu-table">
                <tr>
                    <th>Name</th>
                    <th>Picture</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Description</th>
                </tr>
                <?php
                    while($row = $data->fetch(PDO::FETCH_ASSOC)){
                ?>
                    <tr>
                        <td><?= $row['nama']?></td>
                        <td><img src="./../Src/Makanan/<?= $row['gambar']?>" alt="gambar pizza" style="width: 100px"></td>
                        <td><?= $row['harga']?></td>
                        <td><?= $row['kategori']?></td>
                        <td><?= $row['deskripsi']?></td>
                    </tr>
                <?php } ?>
            </table>
    </body>
</html>