const express = require('express');
const app = express();
const myDatabase = require('./config/database');

const cors = require('cors')
require('dotenv/config');
const port = process.env.PORT

//Import Routes
const postsRoute = require('./api/routes/catalogue')

//Middlewares
app.use(cors({
  origin: "*"
}));
app.use('/masterclass', postsRoute.router);

//Connect to DB
myDatabase.connect((err) => {
  if (err) {
    console.error('erreur de connexion: ' + err.stack);
    return;
  }

  console.log("connecté à la bdd avec l'id " + myDatabase.threadId);
});

//Listening to the server
app.listen(port || 4500)