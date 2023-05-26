const express = require('express');
const app = express();
const mysql = require('mysql');
const bodyParser = require('body-parser')
const cors = require('cors')
require('dotenv/config');
const connectionDB = mysql.createConnection({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_DATABASE,
})
const port = process.env.PORT

//Import Routes
//const postsRoute = require('./routes/Masterclass')

//Middlewares
app.use(cors({
  origin: "*"
}));
app.use(bodyParser.urlencoded({extended: true, parameterLimit: 1000000, limit: '10000kb'}))
app.use(bodyParser.json())
//app.use('/masterclass', postsRoute.router);

//Connect to DB
connectionDB.connect((err) => {
  if (err) {
    console.error('erreur de connexion: ' + err.stack);
    return;
  }

  console.log("connecté à la bdd avec l'id " + connectionDB.threadId);
});

//Listening to the server
app.listen(port || 4500)