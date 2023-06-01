let cards = document.querySelectorAll(".card");
let cardList = document.querySelector(".list-content");
let editForm = document.querySelector(".styled-form");
let backToListBtn = document.querySelector("#back");

// Tableau pour stocker les données de chaque carte
let cardData = [];

function handleEditForm(event) {
    let card = event.currentTarget;
    let cardId = card.id;
  
    // Accès aux données supplémentaires à partir des attributs data
    let oeuvreCompositeur = card.getAttribute("data-oeuvre-compositeur");
    let masterclassStatus = card.getAttribute("data-masterclass-status");
    let masterclassLangue = card.getAttribute("data-masterclass-langue");
    let masterclass_nom = card.getAttribute("data-masterclass_nom");
    let utilisateur_nom = card.getAttribute("data-utilisateur_nom");
    let professeur_nom = card.getAttribute("data-professeur_nom");
    let oeuvre_nom = card.getAttribute("data-oeuvre_nom");
    let instrumentNom = card.getAttribute("data-instrument-nom");

    // Sélection des champs de formulaire
    let idMasterclass = editForm.querySelector("#idMasterclass");
    let idMasterclassInput = editForm.querySelector("#masterclass_id");
    let masterclassNomInput = editForm.querySelector("#masterclass_nom");
    let masterclassLangueInput = editForm.querySelector("#masterclass_langue");
    let masterclassStatusInput = editForm.querySelector("#masterclass_status");
    let oeuvreNomCompositeurInput = editForm.querySelector("#oeuvre_nom_compositeur");
    let oeuvreNomInput = editForm.querySelector("#oeuvre_nom");
    let professeurNomInput = editForm.querySelector("#professeur_nom");
    let utilisateurNomInput = editForm.querySelector("#utilisateur_nom");
    let instrumentNomInput = editForm.querySelector("#instrument_nom");

    // Attribution des valeurs aux champs de formulaire
    idMasterclassInput.value = cardId;
    masterclassNomInput.value = masterclass_nom;
    masterclassLangueInput.value = masterclassLangue;
    masterclassStatusInput.value = masterclassStatus;
    oeuvreNomCompositeurInput.value = oeuvreCompositeur;
    oeuvreNomInput.value = oeuvre_nom;
    professeurNomInput.value = professeur_nom;
    utilisateurNomInput.value = utilisateur_nom;
    instrumentNomInput.value = instrumentNom;

    // Attribution des placeholder aux champs de formulaire
    masterclassNomInput.placeholder = masterclass_nom;
    masterclassLangueInput.placeholder = masterclassLangue;
    masterclassStatusInput.placeholder = masterclassStatus;
    oeuvreNomCompositeurInput.placeholder = oeuvreCompositeur;
    oeuvreNomInput.placeholder = oeuvre_nom;
    professeurNomInput.placeholder = professeur_nom;
    utilisateurNomInput.placeholder = utilisateur_nom;
    instrumentNomInput.placeholder = instrumentNom;
    
    cardList.style.display = "none";
    editForm.style.display = "flex";
    idMasterclass.style.display = "none";
}

function handleBackToCardList() {
  cardList.style.display = "flex";
  editForm.style.display = "none";
  cardList.style.flexDirection = "column";
}

cards.forEach((card) => {
  let cardId = card.getAttribute("data"); // Obtenir l'ID de la carte
  let cardDataObj = {
    masterclass_id: cardId,
    // Ajoutez ici d'autres propriétés avec les données spécifiques de la carte
    // Exemple: oeuvre_nom_compositeur: "Nom compositeur", professeur_nom: "Nom professeur", etc.
  };
  cardData.push(cardDataObj); // Ajouter les données de la carte dans le tableau cardData

  card.addEventListener("click", handleEditForm); // Utiliser addEventListener pour ajouter un gestionnaire d'événements
});

backToListBtn.addEventListener("click", handleBackToCardList);