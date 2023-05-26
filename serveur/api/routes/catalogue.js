const express = require('express');
const router = express.Router();
const myDatabase = require('../../config/database');

//GET BACK ALL MASTERCLASS
router.get('/allmasterclass', async (req, res) => {
    try{
        myDatabase.query('SELECT * FROM masterclass', (error, results, fields) => {
            if (error) throw error;
            console.log(results);
            res.status(200).json(results)
          });
    }catch(err){
        res.json({message: err})
    }
});

module.exports = {
    router: router,
}