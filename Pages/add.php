<?php

    session_start();

    if(!isset($_SESSION['admin'])){
        session_destroy();
        header('location: home.php');
    }

?>

<html>
    <head>
        <link rel="stylesheet" href="./../Styles/crud.css">
    </head>
    <body>
        <div class="container">
            <h1>Add new item</h1>
        <form action="add-process.php" method="POST" enctype="multipart/form-data">
            <label for="">Name</label>
            <br>
            <input type="text" name="name" autocomplete="off" required>
            <br>
            <label for="">Category</label>
            <br>
            <select name="category" id="">
                <option value="Pizza">Pizza</option>
                <option value="Burger">Drinks</option>
                <option value="Steak">Steak</option>
                <option value="Drinks">Drinks</option>
            </select>
            <br>
            <label for="">Price</label>
            <br>
            <input type="text" name="price" required>
            <br>
            <label for="">Picture</label>
            <br>
            <input type="file" name="pic" required>
            <br>
            <label for="">Description</label>
            <br>
            <input type="text" name="desc" required>
            <br>
            <button type="submit">Finish</button>
        </form>
        </div>
        
    </body>
</html>