<!DOCTYPE html>
<html>
	<head>
		<title>WannaCry Profits</title>
		<link href="style.css" rel="stylesheet">
	</head>
	<body>
    <h1>WannaCry Profits</h1>

    <p>Stats for each known BTC address associated with the <a href="https://en.wikipedia.org/wiki/WannaCry_ransomware_attack">WannaCry ransomware</a>:</p>
    <br>

    <?php
			//all known BTC addresses associated with WannaCry
      $addresses = array(
        "12t9YDPgwueZ9NyMgw519p7AA8isjr6SMw",
        "115p7UMMngoj1pMvkpHijcRdfJNXj6LrLn",
        "13AM4VW2dhxYgXeQepoHkHSQuy6NgaEb94",
        "1QAc9S5EmycqjzzWDc1yiWzr9jJLC8sLiY",
        "15zGqZCTcys6eCjDkE3DypCjXi6QWRV6V1"
      );

			//blockchain api URL
      $btcAPI = "https://blockchain.info/multiaddr?active=";

			//USD price URL
			$usdAPI = "https://api.coinbase.com/v2/prices/spot?currency=USD";

			//append addersses to blockchain API call
			foreach($addresses as $addr){
				$btcAPI = $btcAPI . $addr;
				$btcAPI = $btcAPI . "|";
			}

			//remove extra "|" from blockchain API call
			$btcAPI = rtrim($btcAPI, '|');

			//make API call to blockchain
			$btcRawData = file_get_contents($btcAPI);
			$btcData = json_decode($btcRawData, true)['addresses'];

			//make API call to coinbase price api
			$usdRawData = file_get_contents($usdAPI);
			$usdPrice = json_decode($usdRawData, true)['data']['amount'];

			//create running total BTC
			$totalBTC = 0;

			for ($i = 0; $i < count($addresses); $i++){
				//get total btc for currently selected address
				$currentTotal = $btcData[$i]['total_received'];

				//format current total to correct API data for satoshi values -> -8
				$currentTotal = substr_replace($currentTotal, ".", -8, -8);

				//compute total USD value for selected address
				$usdValue = number_format($usdPrice * $currentTotal);

				//add total for currently selected address to running total
				$totalBTC = $totalBTC + $currentTotal;

				//template HTML containing address stats
				echo "<div>\n" .
							"<span class=\"regularText\">Address: </span>\n" .
							"<span class=\"btcaddress\">" . $btcData[$i]['address'] . "</span>" .
						"</div>\n" .
						"<br>\n" .
						"<div>\n" .
							"<span class=\"regularText\">Value (BTC): </span>\n" .
							"<span class=\"addrvalue\">" . $currentTotal . " BTC</span>" .
						"</div>\n" .
						"<br>\n" .
						"<div>\n" .
							"<span class=\"regularText\">Value (USD): </span>\n" .
							"<span cladd=\"usdvalue\">$" . $usdValue . "</span>\n" .
						"</div>\n" .
						"<br>\n" .
						"<br>\n"
						;
	    }

			//compute total USD value of total BTC count
			$totalUSD = number_format($totalBTC * $usdPrice);

			//template HTML containing overall totals
			echo "<h3>Total BTC spent by WannaCry victims: " . $totalBTC . " BTC</h3>\n" .
					"<h3>Current USD equivalent: <u>$" . $totalUSD . "</u></h3>\n";
		?>
		<p>* USD prices for BTC are obtained from <a href="https://coinbase.com">CoinBase</a>.</p>
	</body>
</html>
