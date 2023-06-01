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
        <link rel="stylesheet" href="./index.css">
        <link rel="stylesheet" href="./pages/home/home.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-KldBTSdRdEhZ1cIeicBASL0vuk+rjDz5ixSfFVypxnDRjD/8yU0l4aTPC/RPvRVtuvID3YjtS8WoyOJw7hEZGw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap" rel="stylesheet">
        <script src="https://kit.fontawesome.com/72d345e137.js" crossorigin="anonymous"></script>
        
    </head>
    <body>
        <?php 
        require_once('./inc/routes/functions.php');
        require_once('./inc/routes/router.php');
        ?>
    </body>
</html>