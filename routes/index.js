var express = require('express'),
    config  = require('../config.js'),
    request = require('request');

var router = express.Router();

/* GET home page */
router.get('/', function(req, res){

  //set up api call with multiple addresses
  var addrApi = "https://blockchain.info/multiaddr?active="
  for (i in config.addresses){
    addrApi += config.addresses[i] + "|";
  }

  //cut off last '|' in the addrApi url
  addrApi = addrApi.substring(0, addrApi.length - 1);

  //init urls array to store each API url
  var urls = [];
  urls.push(addrApi);
  urls.push("https://api.coinbase.com/v2/prices/spot?currency=USD");

  //callback function
  __request(urls, function(responses){
    //get raw data from api response
    var blockchainData = JSON.parse(responses[0].body).addresses;

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
  });

  //make the api calls
  var __request = function(urls, callback){
    //init object to store responses
    var results = {};

    var urlNum = urls.length;

    var connectionCount = 0;

    var handler = function(error, response, body){
      //assmeble response data
      var url = response.request.uri.href;
      results[url] = {
        error: error,
        response: response,
        body: body
      };

      //if the data has been fetched, execute callback function
      if (connectionCount++ === urls.length){
        callback(results);
      }

      while(urlNum --){
        request(urls[urlNum], handler);
      }
    }
  }
});

module.exports = router;
