<?php 

function editMasterclass($masterclass_id, $masterclass_nom, $masterclass_langue, $masterclass_status, $oeuvre_nom_compositeur, $oeuvre_nom, $professeur_nom, $utilisateur_nom, $instrument_nom){

    $url = 'https://maestromedia.herokuapp.com/masterclass/' . $masterclass_id;

    $myMasterclass = array("nom"=>$masterclass_nom, "langue"=>$masterclass_langue, "status"=>$masterclass_status, "nom_compositeur" => $oeuvre_nom_compositeur, "nom_oeuvre"=>$oeuvre_nom, "nom_professeur"=>$professeur_nom, "nom_utilisateur"=>$utilisateur_nom, "nom_instrument"=>$instrument_nom);

    callAPI('PATCH', $url, $myMasterclass);

    $allMasterclass = callAPI('GET', 'https://maestromedia.herokuapp.com/masterclass/allmasterclass');

    return [$allMasterclass];
}