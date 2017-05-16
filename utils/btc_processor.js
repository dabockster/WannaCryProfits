var config  = require('../config.js');
var request = require('request');

//global vars for various pieces of information relevant to the webpage
var blockchainData = {};

//loop through the addresses in config.js and get info for each
function getBlockchainInfo(){
  //set up api call with multiple addresses
  var api = "https://blockchain.info/multiaddr?active="

  for (i in config.addresses){
    api += config.addresses[i] + "|";
  }

  //cut off last | in api call
  api = api.substring(0, api.length - 1);

  //make the api call
  request(api, function(error, response, body){
    if (!error && response.statusCode == 200){
      console.log(JSON.parse(body));
      blockchainData = JSON.parse(body);
    }
  });
}

var getData = function(){
  getBlockchainInfo();
  return blockchainData;
}


module.exports = {
  getData: getData()
};
