<?php
require_once('./inc/functions/back/api.php');
require_once('./inc/functions/back/filter.php');
require_once('./inc/functions/back/selectInstrument.php');

$statusMasterclass = "";
$langueMasterclass = "";
$teacherMasterclass = "";

$allMasterclass = callAPI('GET', 'http://localhost:4500/masterclass/allmasterclass');
var_dump($allMasterclass);
$allTeachers = callAPI('GET', 'http://localhost:4500/masterclass/allteachers');

$methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");

if ($methode === "POST") {

    $workName = filter_input(INPUT_POST, "workName");
    $encodedWorkName = urlencode($workName);

    $teacher = filter_input(INPUT_POST, "teacher");
    $status = filter_input(INPUT_POST, "status");
    $language = filter_input(INPUT_POST, "language");

    $instrument = filter_input(INPUT_POST, "instrument");
    
    if(isset($workName)){
      $allMasterclass = callAPI('GET', 'http://localhost:4500/masterclass/research/work?name=' . $encodedWorkName);
    } else if (isset($status) || isset($teacher) || isset($language)){
      [$allMasterclass, $statusMasterclass, $langueMasterclass, $teacherMasterclass] = filter($teacher, $status, $language, $statusMasterclass, $langueMasterclass, $teacherMasterclass);
    } else if (isset($instrument)){
      [$allMasterclass] = searchByInstrument($instrument);
    }
}
?>

  <div class="masterclass-container d-flex content-s-b">

  <div class="dashboard-container d-flex flex-column item-center" style="padding-top: 80px;">
    <?php
        $role = isset($_SESSION['user']['role']) ? htmlspecialchars($_SESSION['user']['role']) : '';

        if ($role === 'Admin') {
            echo '<i class="fas fa-crown fa-3x" style="color: gold;"></i>';
        } else if ($role === 'musicologue') {
            echo '<i class="fas fa-music fa-3x" style="color: #579279;"></i>';
        } else if ($role === 'user') {
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
</div>










    <div class="list-masterclass-container">
      <div class="list-container d-flex flex-column content-s-a">
        <div class="list-header-container d-flex item-center">
          <h1>Gérez et organisez vos Masterclass</h1>
          <form class="searche-form-container" role="search"  method="POST" action="">
            <label for="search">Search</label>
            <input id="search" name="workName" type="search" placeholder="Rechercher une oeuvre" autofocus required />
            <button type="submit">Go</button>    
          </form>
          <div class="filter-icon-container d-flex content-center item-center">
            <i class="fa fa-filter" style="color: #CC34AE; font-size: 45px;"></i>
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
                <div>
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
        <form action="" method="post" class="styled-form">
    <div class="styled-field">
        <input type="text" id="masterclass_nom" name="masterclass_nom" placeholder="Nom de la masterclass" required>
    </div>
    <div class="styled-field">
        <input type="text" id="masterclass_langue" name="masterclass_langue" placeholder="Langue de la masterclass" required>
    </div>
    <div class="styled-field">
        <input type="text" id="masterclass_status" name="masterclass_status" placeholder="Statut de la masterclass" required>
    </div>
    <div class="styled-field">
        <input type="text" id="oeuvre_nom_compositeur" name="oeuvre_nom_compositeur" placeholder="Nom du compositeur de l'oeuvre" required>
    </div>
    <div class="styled-field">
        <input type="text" id="oeuvre_nom" name="oeuvre_nom" placeholder="Nom de l'oeuvre" required>
    </div>
    <div class="styled-field">
        <input type="text" id="professeur_nom" name="professeur_nom" placeholder="Nom du professeur" required>
    </div>
    <div class="styled-field">
        <input type="text" id="utilisateur_nom" name="utilisateur_nom" placeholder="Nom de l'utilisateur" required>
    </div>
    <div class="styled-field">
        <input type="text" id="instrument_nom" name="instrument_nom" placeholder="Nom de l'instrument" required>
    </div>
    <input type="submit" value="Envoyer">
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
            <button type="submit" name="instrument" value="Celle"><h3>Celle</h3></button>
            <button type="submit" name="instrument" value="Voice"><h3>Voice</h3></button>
            <button type="submit" name="instrument" value="Clarinet"><h3>Clarinet</h3></button>
            <button type="submit" name="instrument" value="Flute"><h3>Flute</h3></button>
            <button type="submit" name="instrument" value="Oboe"><h3>Oboe</h3></button>
            <button type="submit" name="instrument" value="Chamber music"><h3>Chamber music</h3></button>
            <button type="submit" name="instrument" value="Trambone"><h3>Trambone</h3></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script src="./inc/functions/front/filter.js"></script>
  <script src="./inc/functions/front/SelectStatus.js"></script>