<?php
require_once('./inc/functions/api.php');
$allMasterclass = callAPI('GET', 'http://localhost:4500/masterclass/allmasterclass');
/*if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../functions/login.php');
    exit;
}*/

$methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");

$message = "";
$isShort = false;

$submitUrl = filter_input(INPUT_POST, "submitUrl");

if ($methode == "POST") {

    $submitUrl = filter_input(INPUT_POST, "submitUrl");

    if(isset($submitUrl)){
        [$message, $isShort] = addUrl();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <title>Accueil</title>
  <link rel="stylesheet" href="home.css">
</head>
<body>
  <div class="masterclass-container d-flex content-s-b">
    <div class="dashboard-container">
  
    </div>
    <div class="list-masterclass-container">
      <div class="list-container d-flex flex-column content-s-a">
        <div class="list-header-container d-flex item-center">
          <h1>Gérez et organisez vos Masterclass</h1>
          <form onsubmit="console.log('submited');" role="search"  method="POST" action="">
            <label for="search">Search</label>
            <input id="search" type="search" placeholder="Rechercher une oeuvre" autofocus required />
            <button type="submit">Go</button>    
          </form>
          <div class="filter-container d-flex content-center item-center">
            <i class="fa fa-filter" style="color: #CC34AE; font-size: 45px;"></i>
          </div>
        </div>
        <div class="list-content">
          <h2>Catalogue des masterclass</h2>
          <div class="list-card-container d-flex content-start">
            <?php
            foreach ($allMasterclass as $masterclass): ?>
            <div id="<?php echo $masterclass['masterclass_id'] ?>" class="card d-flex flex-column content-s-b">
              <div class="overlay-container d-flex">
                <img src="./inc/assets/css/images/card.png"/>
                <div class="data-content d-flex flex-column content-s-b item-center">
                  <div class="header-data d-flex content-s-b">
                    <div class="d-flex flex-column">
                      <h2><?php echo $masterclass['oeuvre_nom_compositeur'] ?></h2>
                      <span><?php echo $masterclass['masterclass_status'] ?>(<?php echo $masterclass['masterclass_langue'] ?>)</span>
                    </div>
                    <h3><?php echo $masterclass['instrument_nom'] ?></h3>
                  </div>
                  <div class="footer-data d-flex">
                    <h4><?php echo $masterclass['professeur_nom'] ?></h4>
                  </div>
                </div>
              </div>
              <div class="title-work d-flex item-center content-s-a">
                <h2><?php echo strlen($masterclass['oeuvre_nom']) > 19 ? substr($masterclass['oeuvre_nom'], 0, 19) . '...' : $masterclass['oeuvre_nom'] ?></h2>
                <i class="fa fa-play" style="color: #CC34AE;"></i>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="instrument-container">
  
    </div>
  </div>
</body>
</html>
