<?php

    require_once('./../Database/db.php');

    if(!isset($_POST['search'])){
        $sql = "SELECT * FROM menu";
        $data = $db->query($sql);
    }
    else{
        $sql = "SELECT * FROM menu WHERE nama LIKE ?";
        $show = "%{$_POST['search']}%";
        $data = $db->prepare($sql);
        $data->execute([$show]);
    }

    session_start();

    if(isset($_SESSION['user'])){
        $sql1 = "SELECT
                    m.nama,
                    m.harga
                FROM cart c
                INNER JOIN menu m ON m.id = c.id_menu
                WHERE c.id_user = ?";
        $data2 = $db->prepare($sql1);
        $data2->execute([$_SESSION['user']['id']]);
    }
?>

<html>
    <head>
        <title>IF330-A6</title>
        <link rel="stylesheet" href="./../Styles/home.css" />
        <script defer src="./../Script/app.js"></script>
    </head>
    <body>
        <nav>
            <div class="logo">
                <h2 class="logo-blue">IF330<h2>-A6</h2></h2>
            </div>
            <div class="search-bar">
                <form action="home.php" method="POST">
                    <input type="text" placeholder="Search Menu or Categories" name="search"/>
                    <button type="submit">
                        <img src="./../Src/Icons/Search.png" alt="search" />
                    </button>
                </form>
            </div>
            <div class='profile'>
                <?php 
                    if(isset($_SESSION['user'])){
                ?>
                        <h2 class="profile-name"><?= $_SESSION['user']['name']?></h2>
                        <a href="logout.php">
                            <button>Log Out</button>
                        </a>
                <?php
                    }
                    elseif(isset($_SESSION['admin'])){
                ?>
                        <h2 class="profile-name"><?= $_SESSION['admin']['name']?></h2>
                        <a href="logout.php">
                            <button>Log Out</button>
                        </a>
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
        <?php
            if(isset($_SESSION['user'])){
        ?>
        <div class="cart-container">
            <h1>Cart</h1>
            <?php
                $total = 0;
                while($cart = $data2->fetch(PDO::FETCH_ASSOC)){
                    $total = $total + $cart['harga'];
            ?>
            <div class="cartItem">
                <p class="cartName"><?= $cart['nama']?> <p class="cartPrice">$<?= $cart['harga']?></p></p>
            </div>
            <?php
            }?>
            <h3>Total = $<?= $total?></h3>
            <a href="purchase.php">
                <button class="purchaseBtn">Purchase</button>
            </a>
        </div>
        <?php
        }
        ?>
        <div class='logo-div hidden'>
            <h1>IF330-A6</h1>
        </div>
        <div class="info-container">
            <div class="info-card info-right hidden2">
                <p>Our restaurant has opened over 53.000 outlets accross the country of Indonesia</p>
                <img id="Indo" src="./../Src/Backgrounds/Indonesia.png" alt="">
            </div>
            <div class="underline hidden2"></div>
            <div class="info-card info-left hidden">
                <img id="cow" src="./../Src/Backgrounds/cow.png" alt="">
                <p>Our beef comes from the best Cows from the barns of Ireland</p>
            </div>
            <div class="underline hidden"></div>
            <div class="info-card info-right hidden2">
                <p>Our team consist of 4 of the greatest chef the world has ever known</p>
                <img id="chef" src="./../Src/Backgrounds/chef.png" alt="">
            </div>
        </div>
        <div class="card-container">
            <?php
                while($row = $data->fetch(PDO::FETCH_ASSOC)){
            ?>
                <div class="card hidden">
                    <h2><?= $row['nama']?></h2>
                    <p class="category"><?= $row['kategori']?></p>
                    <img src="./../Src/Makanan/<?= $row['gambar']?>" alt="picture of menu">
                    <p class="price">$<?= $row['harga']?></p>
                    <p class='description'><?= $row['deskripsi']?></p>
                    <a  href="cart.php?id=<?= $row['id'];?>">
                        <button class="cartBtn">Add to cart +</button>
                    </a>
                    <?php
                        if(isset($_SESSION['admin'])){
                    ?>
                    <a href="edit.php?id=<?= $row['id'];?>" >
                        <button class="cardBtn">Edit</button>
                    </a>
                    <a href="delete.php?id=<?= $row['id'];?>" >
                        <button class="cardBtn">Delete</button>
                    </a>
                    <?php }?>
                </div>
            <?php } ?>
        </div>
        <?php
            if(isset($_SESSION['admin'])){
        ?>
        <a href="add.php">
            <button class="addBtn">Add Item</button>
        </a>
        <?php
        }?>
    </body>
</html>