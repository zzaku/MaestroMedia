<?php

/*if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../functions/login.php');
    exit;
}*/

function searchByInstrument($instrument){
    

    $url = 'https://maestromedia.herokuapp.com/masterclass/instrument?';

    $url .= 'name=' . urlencode($instrument);

    $allMasterclass = callAPI('GET', $url);

    return [$allMasterclass];
}
?>