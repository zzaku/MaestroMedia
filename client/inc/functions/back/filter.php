<?php

/*if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header('Location: ../functions/login.php');
    exit;
}*/

function filter($teacher, $status, $language, $statusMasterclass, $langueMasterclass, $teacherMasterclass){
    
    $url = 'http://localhost:4500/masterclass/filter?';

    if ($teacher === null) {
      $teacher = '';
    } else {
      $teacherMasterclass = $teacher;
    }
    
    if ($language === null) {
      $language = '';
    } else if($language === 'FR'){
      $langueMasterclass = 'FR';
    } else if($language === 'EN'){
      $langueMasterclass = 'EN';
    }
    
    if ($status === null) {
        $status = '';
    } else if($status === 'Online'){
        $statusMasterclass = 'online';
    } else if($status === 'A post-produire'){
        $statusMasterclass = 'preprod';
    } else if($status === 'En cours édito'){
        $statusMasterclass = 'progress';
    }

    $url .= 'teacher=' . urlencode($teacher) . '&' . 'language=' . urlencode($language) . '&' . 'status=' . urlencode($status);

    $allMasterclass = callAPI('GET', $url);

    return [$allMasterclass, $statusMasterclass, $langueMasterclass, $teacherMasterclass];
}
?>