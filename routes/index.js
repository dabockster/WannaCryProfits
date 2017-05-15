var express = require('express'),
    config  = require('../config.js');

var router = express.Router();

/* GET home page */
router.get('/', function(req, res){
  res.render('home', {
    address: config.addresses
  });
});

module.exports = router;
