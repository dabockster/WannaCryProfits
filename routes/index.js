var express = require('express'),
    config  = require('../config.js'),
    btc     = require('../utils/btc_processor.js');

var router = express.Router();

/* GET home page */
router.get('/', function(req, res){
  console.log(btc.getData);
  res.render('home', {
    address: config.addresses
  });
});

module.exports = router;
