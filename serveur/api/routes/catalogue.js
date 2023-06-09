const express = require('express');
const router = express.Router();
const myDatabase = require('../services/database');

//GET BACK ALL MASTERCLASS
router.get('/allmasterclass', async (req, res) => {
    try{
        myDatabase.query(`SELECT mc.id AS masterclass_id, mc.nom AS masterclass_nom, mc.langue AS masterclass_langue, mc.status AS masterclass_status,o.id AS oeuvre_id, o.nom_compositeur AS oeuvre_nom_compositeur, o.nom AS oeuvre_nom,p.id AS professeur_id, p.nom AS professeur_nom,
        u.id AS utilisateur_id, u.nom AS utilisateur_nom,
        i.nom AS instrument_nom
        FROM Masterclass mc
        JOIN oeuvre o ON mc.id_oeuvre = o.id
        JOIN professeurs p ON o.id_professeurs = p.id
        JOIN utilisateur u ON mc.id_utilisateur = u.id
        JOIN instruments i ON i.id_oeuvre = o.id
        ORDER BY masterclass_id ASC`, (error, results, fields) => {
            if (error) throw error;
            res.status(200).json(results)
          });
    }catch(err){
        res.json({message: err})
    }
});

//GET BACK ALL MASTERCLASS BY WORK'S NAME
router.get('/research/work', async (req, res) => {
    const workName = req.query.name
    try{
        myDatabase.query(`SELECT mc.id AS masterclass_id, mc.nom AS masterclass_nom, mc.langue AS masterclass_langue, mc.status AS masterclass_status,o.id AS oeuvre_id, o.nom_compositeur AS oeuvre_nom_compositeur, o.nom AS oeuvre_nom,p.id AS professeur_id, p.nom AS professeur_nom,
        u.id AS utilisateur_id, u.nom AS utilisateur_nom,
        i.nom AS instrument_nom
        FROM Masterclass mc
        JOIN oeuvre o ON mc.id_oeuvre = o.id
        JOIN professeurs p ON o.id_professeurs = p.id
        JOIN utilisateur u ON mc.id_utilisateur = u.id
        JOIN instruments i ON i.id_oeuvre = o.id
        WHERE o.nom LIKE '%${workName}%'
        ORDER BY masterclass_id ASC`, (error, results, fields) => {
            if (error) throw error;
            res.status(200).json(results)
          });
    }catch(err){
        res.json({message: err})
    }
});

//GET BACK ALL MASTERCLASS BY INSTRUMENT
router.get('/instrument', async (req, res) => {
    try{
        const instrument = req.query.name;
        myDatabase.query(`SELECT mc.id AS masterclass_id, mc.nom AS masterclass_nom, mc.langue AS masterclass_langue, mc.status AS masterclass_status,o.id AS oeuvre_id, o.nom_compositeur AS oeuvre_nom_compositeur, o.nom AS oeuvre_nom,p.id AS professeur_id, p.nom AS professeur_nom,
            u.id AS utilisateur_id, u.nom AS utilisateur_nom,
            i.nom AS instrument_nom
            FROM Masterclass mc
            JOIN oeuvre o ON mc.id_oeuvre = o.id
            JOIN professeurs p ON o.id_professeurs = p.id
            JOIN utilisateur u ON mc.id_utilisateur = u.id
            JOIN instruments i ON i.id_oeuvre = o.id
            WHERE i.nom='${instrument}'
            ORDER BY masterclass_id ASC`, (error, results, fields) => {
                if (error) throw error;
                res.status(200).json(results)
            });
    } catch(err){
        res.json({message: err})
    }
});

//GET BACK ALL TEACHERS
router.get('/allteachers', async (req, res) => {
    try{
        myDatabase.query(`SELECT nom FROM professeurs`, (error, results, fields) => {
                if (error) throw error;
                res.status(200).json(results)
            });
    } catch(err){
        res.json({message: err})
    }
});

//GET BACK ALL MASTERCLASS BY INSTRUMENT
router.get('/filter', async (req, res) => {
    try{
        const teacher = req.query.teacher;
        const status = req.query.status;
        const language = req.query.language;

        myDatabase.query(`SELECT mc.id AS masterclass_id, mc.nom AS masterclass_nom, mc.langue AS masterclass_langue, mc.status AS masterclass_status,
        o.id AS oeuvre_id, o.nom_compositeur AS oeuvre_nom_compositeur, o.nom AS oeuvre_nom,
        p.id AS professeur_id, p.nom AS professeur_nom,
        u.id AS utilisateur_id, u.nom AS utilisateur_nom,
        i.nom AS instrument_nom
        FROM Masterclass mc
        JOIN oeuvre o ON mc.id_oeuvre = o.id
        JOIN professeurs p ON o.id_professeurs = p.id
        JOIN utilisateur u ON mc.id_utilisateur = u.id
        JOIN instruments i ON i.id_oeuvre = o.id
        WHERE (p.nom IS NULL OR p.nom LIKE '%${teacher}%') AND (mc.status IS NULL OR mc.status LIKE '%${status}%') AND (mc.langue IS NULL OR mc.langue LIKE '%${language}%')
        ORDER BY masterclass_id ASC;`, (error, results, fields) => {
                if (error) throw error;
                res.status(200).json(results)
            });
    } catch(err){
        res.json({message: err})
    }
});

module.exports = {
    router: router,
}