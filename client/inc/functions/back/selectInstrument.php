<?php

/*if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../functions/login.php');
    exit;
}*/

function searchByInstrument($instrument){
    

    $url = 'http://localhost:4500/masterclass/instrument?';

    $url .= 'name=' . urlencode($instrument);

    $allMasterclass = callAPI('GET', $url);

    return [$allMasterclass];
}
?>