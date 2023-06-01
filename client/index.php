<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Saline</title>
        <link rel="stylesheet" href="./pages/home/home.css">
        <script src="https://kit.fontawesome.com/72d345e137.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php 
        require_once('./inc/routes/functions.php');
        require_once('./inc/routes/router.php');
        ?>
    </body>
</html>