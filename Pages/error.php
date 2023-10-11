<?php

    $error = $_GET['error'];

?>

<html>
    <head>
        <title>IF330 A6</title>
    </head>
    <body>
        <div class="error-msg">
            <p>Error Caugt</p>
            <p>Cause of error: <?= $error ?></p>
        </div>
    </body>
</html>