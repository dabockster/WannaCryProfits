var express = require('express'),
    config  = require('../config.js'),
    request = require('request');

var router = express.Router();

/* GET home page */
router.get('/', function(req, res){

  //set up api call with multiple addresses
  var api = "https://blockchain.info/multiaddr?active="
  for (i in config.addresses){
    api += config.addresses[i] + "|";
  }

  //cut off last '|' in the api url
  api = api.substring(0, api.length - 1);

  //make the api call
  request(api, function(error, response, body){
    //if data is received, process it
    if (!error && response.statusCode == 200){
      //get raw data from api response
      var blockchainData = JSON.parse(body).addresses;

      //init variable for storing total received BTC for all WannaCry addresses
      var addressData = {};

      //init variable for counting the total amount of BTC across all WannaCry addresses
      var totalBTC = 0;

      if (config.addresses.length != blockchainData.length){
        console.error("ERROR: Prefilled address length does not match Blockchain API data!");
      }

      for(i=0; i<config.addresses.length; i++){
        var currentAddress = config.addresses[i];
        var currentTotal = blockchainData[i].total_received;

        addressData[currentAddress] = currentTotal
        totalBTC += currentTotal;
      }

      //render the page after the data has beenr received
      res.render('home', {
        addressData: addressData,
        totalBTC: totalBTC
      });
    }
    else{
      res.send("ERROR: " + error);
    }
  });
});

module.exports = router;
