const fs = require("fs");
const csv = require("csv-parser");
const mysql = require("mysql2");

// Configuration de la connexion à la base de données
const connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "maestromedia",
});

// Tableaux pour stocker les noms des professeurs, instruments et oeuvres déjà insérés
const professeursInseres = [];
const oeuvresInseres = [];

// Lecture du fichier CSV et insertion des données dans les tables
fs.createReadStream("./JeuDonnees.csv")
  .pipe(csv({ separator: ";" }))
  .on("data", (row) => {
    const {
      "Nom compositeur": nomCompositeur,
      "Titre de l'œuvre": titreOeuvre,
      Professeur: nomProfesseur,
      Instrument: nomInstrument,
      Filename: nomMasterclass,
      Langue: langue,
      Status: status,
    } = row;

    // Vérifier si le champ "nom" des tables est présent et non null
    if (nomProfesseur && nomCompositeur && titreOeuvre) {
      // Vérifier si le professeur existe déjà
      if (!professeursInseres.includes(nomProfesseur)) {
        professeursInseres.push(nomProfesseur);

        // Insérer le professeur dans la table "professeurs"
        connection.query(
          "INSERT INTO professeurs (nom) VALUES (?)",
          [nomProfesseur],
          (error, results) => {
            if (error) {
              console.error(error);
            } else {
              const idProfesseur = results.insertId;

              // Insérer les données dans la table "oeuvre"
              insertOeuvre(idProfesseur);
            }
          }
        );
      } else {
        // Récupérer l'ID du professeur existant
        connection.query(
          "SELECT id FROM professeurs WHERE nom = ?",
          [nomProfesseur],
          (error, results) => {
            if (error) {
              console.error(error);
            } else {
              const idProfesseur = results[0].id;

              // Insérer les données dans la table "oeuvre"
              insertOeuvre(idProfesseur);
            }
          }
        );
      }

      // Fonction pour insérer les données dans la table "oeuvre"
      function insertOeuvre(idProfesseur) {
        // Vérifier si l'oeuvre existe déjà
        if (!oeuvresInseres.includes(titreOeuvre)) {
          oeuvresInseres.push(titreOeuvre);

          // Insérer les données dans la table "oeuvre"
          connection.query(
            "INSERT INTO oeuvre (nom_compositeur, nom, id_professeurs) VALUES (?, ?, ?)",
            [nomCompositeur, titreOeuvre, idProfesseur],
            (error, results) => {
              if (error) {
                console.error(error);
              } else {
                const idOeuvre = results.insertId;

                // Insérer les données dans la table "Masterclass"
                connection.query(
                  "INSERT INTO Masterclass (nom, langue, status, id_oeuvre, id_utilisateur) VALUES (?, ?, ?, ?, ?)",
                  [nomMasterclass, langue, status, idOeuvre, 1]
                );

                // Insérer l'instrument dans la table "instruments"
                connection.query(
                  "INSERT INTO instruments (nom, id_oeuvre) VALUES (?, ?)",
                  [nomInstrument, idOeuvre],
                  (error) => {
                    if (error) {
                      console.error(error);
                    }
                  }
                );
              }
            }
          );
        }
      }
    }
  });
console.log("données insérées");