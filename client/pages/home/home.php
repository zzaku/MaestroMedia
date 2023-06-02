<?php
require_once "./inc/functions/back/api.php";
require_once "./inc/functions/back/filter.php";
require_once "./inc/functions/back/selectInstrument.php";
require_once "./inc/functions/back/editMasterclass.php";
require_once "./inc/functions/back/logout.php";

if (!$_SESSION["loggedin"]) {
    header("Location: ./index.php?page=login"); // Remplacez "login.php" par l'URL de votre page de connexion
    exit();
}

$statusMasterclass = "";
$langueMasterclass = "";
$teacherMasterclass = "";

$role = isset($_SESSION["user"]["role"])
    ? htmlspecialchars($_SESSION["user"]["role"])
    : "";

$allMasterclass = callAPI(
    "GET",
    "https://maestromedia.herokuapp.com/masterclass/allmasterclass"
);
$allTeachers = callAPI(
    "GET",
    "https://maestromedia.herokuapp.com/masterclass/allteachers"
);

$methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");

if ($methode === "POST") {
    $workName = filter_input(INPUT_POST, "workName");
    $encodedWorkName = urlencode($workName);

    $teacher = filter_input(INPUT_POST, "teacher");
    $status = filter_input(INPUT_POST, "status");
    $language = filter_input(INPUT_POST, "language");

    $instrument = filter_input(INPUT_POST, "instrument");

    $editMasterclass = filter_input(INPUT_POST, "sumbit-form-edit");
    $masterclass_id = filter_input(INPUT_POST, "masterclass_id");
    $masterclass_nom = filter_input(INPUT_POST, "masterclass_nom");
    $masterclass_langue = filter_input(INPUT_POST, "masterclass_langue");
    $masterclass_status = filter_input(INPUT_POST, "masterclass_status");
    $oeuvre_nom_compositeur = filter_input(
        INPUT_POST,
        "oeuvre_nom_compositeur"
    );
    $oeuvre_nom = filter_input(INPUT_POST, "oeuvre_nom");
    $professeur_nom = filter_input(INPUT_POST, "professeur_nom");
    $utilisateur_nom = filter_input(INPUT_POST, "utilisateur_nom");
    $instrument_nom = filter_input(INPUT_POST, "instrument_nom");

    $logout = filter_input(INPUT_POST, "logout");

    if (isset($workName)) {
        $allMasterclass = callAPI(
            "GET",
            "https://maestromedia.herokuapp.com/masterclass/research/work?name=" .
                $encodedWorkName
        );
    } elseif (isset($status) || isset($teacher) || isset($language)) {
        [
            $allMasterclass,
            $statusMasterclass,
            $langueMasterclass,
            $teacherMasterclass,
        ] = filter(
            $teacher,
            $status,
            $language,
            $statusMasterclass,
            $langueMasterclass,
            $teacherMasterclass
        );
    } elseif (isset($instrument)) {
        [$allMasterclass] = searchByInstrument($instrument);
    } elseif (isset($editMasterclass)) {
        [$allMasterclass] = editMasterclass(
            $masterclass_id,
            $masterclass_nom,
            $masterclass_langue,
            $masterclass_status,
            $oeuvre_nom_compositeur,
            $oeuvre_nom,
            $professeur_nom,
            $utilisateur_nom,
            $instrument_nom
        );
    } elseif (isset($logout)) {
        signOut();
    }
}
?>

  <div class="masterclass-container d-flex content-s-b">
  <div class="dashboard-container d-flex flex-column item-center" style="padding-top: 80px;">
    <?php
        if ($role === 'Admin') {
            echo '<i class="fas fa-crown fa-3x" style="color: gold;"></i>';
        } else if ($role === 'Musicologue') {
            echo '<i class="fas fa-music fa-3x" style="color: #579279;"></i>';
        } else if ($role === 'Utilisateur') {
            echo '<i class="fas fa-user fa-3x" style="color: #333;"></i>';
        }
    ?>
    <h3 class="mt-2" style="font-size: 25px; color: white;">
        <?php echo isset($_SESSION['user']['nom']) ? htmlspecialchars($_SESSION['user']['nom']) : ''; ?>
    </h3>
    <h3 style="font-size: 25px; color: white;">
        <?php echo isset($_SESSION['user']['prenom']) ? htmlspecialchars($_SESSION['user']['prenom']) : ''; ?>
    </h3>
    <h4 style="font-size: 25px; color: white;">
        <?php echo isset($_SESSION['user']['role']) ? htmlspecialchars($_SESSION['user']['role']) : ''; ?>
    </h4>
    <form class="logout-btn-container d-flex content-center item-center" role="logout"  method="POST" action="">
      <input class="logout-btn" id="logout" name="logout" type="submit" value="Se déconnecter">
    </form>
</div>
    <div class="list-masterclass-container">
      <div class="list-container d-flex flex-column content-s-a">
        <div class="list-header-container d-flex item-center content-center">
          <h1>Gérez et organisez vos Masterclass</h1>
          <form class="searche-form-container" role="search"  method="POST" action="">
            <label for="search">Search</label>
            <input id="search" name="workName" type="search" placeholder="Rechercher une oeuvre" autofocus required />
            <button type="submit">Go</button>    
          </form>
          <div class="filter-icon-container d-flex content-center item-center">
            <img src="./inc/assets/css/images/filter.png" />
          </div>
          <div class="filter-container d-flex flex-column item-center content-s-b">
            <form class="filter-form-container d-flex flex-column item-center content-s-b" role="filter" method="POST" action="">
              <div class="status-container d-flex flex-column content-s-a">
                <div class="section-title">
                  <h5>Status</h5>
                </div>
                <div class="option-status-container d-flex flex-column item-center content-s-a">
                  <div class="option-status online d-flex item-center content-center" style="background: <?php echo $statusMasterclass === 'online' ? 'hwb(156 34% 43% / 0.418)' : 'none' ?>">
                    <i class="fa fa-check-double" style="color: #579279;"></i>
                    <input style="display: none;" id="online" type="radio" name="status" value="Online" <?php echo $statusMasterclass === 'online' ? 'checked' : '' ?>  />
                    <h3>En ligne</h3>
                  </div>
                  <div class="option-status preprod d-flex item-center content-center" style="background: <?php echo $statusMasterclass === 'preprod' ? '#f47a078a' : 'none' ?>">
                    <i class="fa fa-spinner" style="color: #f47a07;"></i>
                    <input style="display: none;" id="preprod" type="radio" name="status" value="A post-produire" <?php echo $statusMasterclass === 'preprod' ? 'checked' : '' ?> />
                    <h3>À post-produire</h3>
                  </div>
                  <div class="option-status progress d-flex item-center content-center" style="background: <?php echo $statusMasterclass === 'progress' ? '#808f9e5b' : 'none' ?>">
                    <i class="fa fa-pen" style="color: #808f9e;"></i>
                    <input style="display: none;" id="progress" type="radio" name="status" value="En cours édito" <?php echo $statusMasterclass === 'progress' ? 'checked' : '' ?> />
                    <h3>En cours édito</h3>
                  </div>
                </div>
              </div>
              <div class="professeur-container d-flex flex-column content-s-a item-center">
                <div class="section-title d-flex">
                  <h5>Professeur</h5>
                </div>
                <div class="select-container d-flex content-center">
                  <label class="select" for="slct">
                    <select id="slct" name="teacher">
                      <option value="<?php echo strlen($teacherMasterclass) > 0 ? $teacherMasterclass : null ?>" disabled="<?php echo strlen($teacherMasterclass) === 0 ? 'disabled' : null ?>" selected="selected"><?php echo strlen($teacherMasterclass) > 0 ? $teacherMasterclass : 'Séléctionner un professeur' ?></option>
                      <?php foreach($allTeachers as $teacher): ?>
                      <option value="<?php echo $teacher['nom'] ?>"><?php echo $teacher['nom'] ?></option>
                      <?php endforeach; ?>
                    </select>
                    <svg>
                      <use xlink:href="#select-arrow-down"></use>
                    </svg>
                  </label>
                  <svg class="sprites">
                    <symbol id="select-arrow-down" viewbox="0 0 10 6">
                      <polyline points="1 1 5 5 9 1"></polyline>
                    </symbol>
                  </svg>
                </div>
              </div>
              <div class="langue-container d-flex flex-column content-s-a item-center">
                <div class="section-title d-flex">
                  <h5>Langue</h5>
                </div>
                <div class="langue-option-container d-flex content-s-b">
                  <h5>FR</h5>
                  <input id="01" type="radio" name="language" value="FR" <?php echo $langueMasterclass === 'FR' ? 'checked' : null ?>>
                  <h5>EN</h5>
                  <input id="02" type="radio" name="language" value="EN" <?php echo $langueMasterclass === 'EN' ? 'checked' : null ?>>
                </div>
              </div>
              <div class="btn-container">
                <button type="submit">Appliquer</button>
              </div>
            </div>
          </form>
        </div>
        <div class="list-content">
          <h2>Catalogue des masterclass</h2>
          <?php echo count($allMasterclass) > 0 ? '<span>Nombre de résultats trouvés: ' . count($allMasterclass) . '</span>' : null ?>
          <div class="list-card-container d-flex" style="justify-content: <?php echo count($allMasterclass) === 0 ? 'center' : 'start' ?>; align-item: <?php echo count($allMasterclass) === 0 ? 'center' : 'start' ?>; overflow-y: <?php echo count($allMasterclass) === 0 ? 'none' : 'scroll' ?>;">
            <?php echo count($allMasterclass) === 0 ? '<h3 style="color: #2f2f2f">Aucun résultat trouvé</h3>' : null ?>
            <?php
            foreach ($allMasterclass as $masterclass): ?>
            <div id="<?php echo $masterclass['masterclass_id'] ?>" class="card d-flex flex-column content-s-b" data-masterclass_nom="<?php echo $masterclass['masterclass_nom'] ?>" data-utilisateur_nom="<?php echo $masterclass['utilisateur_nom'] ?>" data-oeuvre-compositeur="<?php echo $masterclass['oeuvre_nom_compositeur'] ?>" data-professeur_nom="<?php echo $masterclass['professeur_nom'] ?>" data-oeuvre_nom="<?php echo $masterclass['oeuvre_nom'] ?>" data-masterclass-status="<?php echo $masterclass['masterclass_status'] ?>" data-masterclass-langue="<?php echo $masterclass['masterclass_langue'] ?>" data-instrument-nom="<?php echo $masterclass['instrument_nom'] ?>" >
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
        <form action="" method="POST" class="styled-form">
          <div id="idMasterclass">
              <input type="text" id="masterclass_id" name="masterclass_id" value="" required>
          </div>
          <div class="styled-field">
              <input type="text" id="masterclass_nom" name="masterclass_nom" <?php echo ($role === 'Admin') ? '' : 'readonly' ?> style="background: <?php echo ($role === 'Admin') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin') ? '' : '#E1E1E1' ?>;" placeholder="Nom de la masterclass" value="" required>
          </div>
          <div class="styled-field">
              <input type="text" id="masterclass_langue" name="masterclass_langue" <?php echo ($role === 'Admin') ? '' : 'readonly' ?> style="background: <?php echo ($role === 'Admin') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin') ? '' : '#E1E1E1' ?>;" placeholder="Langue de la masterclass" value="" required>
          </div>
          <div class="styled-field">
              <input type="text" id="masterclass_status" name="masterclass_status" <?php echo ($role === 'Admin') ? '' : 'readonly' ?> style="background: <?php echo ($role === 'Admin') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin') ? '' : '#E1E1E1' ?>;" placeholder="Statut de la masterclass" value="" required>
          </div>
          <div class="styled-field">
              <input type="text" id="oeuvre_nom_compositeur" name="oeuvre_nom_compositeur" <?php echo ($role === 'Admin' || $role ===  'Musicologue') ? '' : 'readonly' ?> style="background: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#E1E1E1' ?>;" placeholder="Nom du compositeur de l'oeuvre" value="" required>
          </div>
          <div class="styled-field">
              <input type="text" id="oeuvre_nom" name="oeuvre_nom" <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : 'readonly' ?> style="background: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#E1E1E1' ?>;" placeholder="Nom de l'oeuvre" value="" required>
          </div>
          <div class="styled-field">
              <input type="text" id="professeur_nom" name="professeur_nom" <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : 'readonly' ?> style="background: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#E1E1E1' ?>;" placeholder="Nom du professeur" value="" required>
          </div>
          <div class="styled-field">
              <input type="text" id="utilisateur_nom" name="utilisateur_nom" <?php echo ($role === 'Admin') ? '' : 'readonly' ?> style="background: <?php echo ($role === 'Admin') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin') ? '' : '#E1E1E1' ?>;" placeholder="Nom de l'utilisateur" value="" required>
          </div>
          <div class="styled-field">
              <input type="text" id="instrument_nom" name="instrument_nom" <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : 'readonly' ?> style="background: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#E1E1E1' ?>;" placeholder="Nom de l'instrument" value="" required>
          </div>
          <div class="edit-form-btn-container d-flex content-s-a item-center">
            <input id="sumbit-form-edit" name="sumbit-form-edit" type="submit" <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : 'disabled' ?> style="background: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#575c73' ?>; color: <?php echo ($role === 'Admin' || $role === 'Musicologue') ? '' : '#E1E1E1' ?>;" value="Modifier">
            <input id="back" type="button" value="Retour">
          </div>
      </form>
      </div>
    </div>
    <div class="instrument-container">
      <div class="instrument-content d-flex flex-column content-s-a item-center">
        <div class="instrument-header-container">
          <h1>Instruments</h1>
        </div>
        <div class="list-instruments-container">
          <form class="list-instruments-form-container d-flex flex-column content-s-a item-center" role="search"  method="POST" action="">
            <button type="submit" name="instrument" value="Piano"><h3>Piano</h3></button>
            <button type="submit" name="instrument" value="Violon"><h3>Violon</h3></button>
            <button type="submit" name="instrument" value="Chant"><h3>Chant</h3></button>
            <button type="submit" name="instrument" value="Voix"><h3>Voix</h3></button>
            <button type="submit" name="instrument" value="Alto"><h3>Alto</h3></button>
            <button type="submit" name="instrument" value="Flute"><h3>Flute</h3></button>
            <button type="submit" name="instrument" value="Violoncelle"><h3>Violoncelle</h3></button>
            <button type="submit" name="instrument" value="Clarinette"><h3>Clarinette</h3></button>
            <button type="submit" name="instrument" value="Trombone"><h3>Trombone</h3></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="./inc/functions/front/filter.js"></script>
  <script src="./inc/functions/front/editForm.js"></script>
  <script src="./inc/functions/front/SelectStatus.js"></script>