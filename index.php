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
				$usdValue = number_format($usdPrice * $currentTotal, 2);

				//add total for currently selected address to running total
				$totalBTC = $totalBTC + $currentTotal;

				//template HTML containing address stats
				echo
						"<div>\n" .
							"<span>Blockchain Address: " .
							"<a class = \"btcaddress\" href=\"https://blockchain.info/address/" . $btcData[$i]['address'] . "\">" . $btcData[$i]['address'] . "</a>" .
							"</span>\n" .
							"<span class=\"btcaddress\">" .
							"</span>" .
						"</div>\n" .
						"<br>\n" .
						"<div>\n" .
							"<span>Current BTC Value: </span>\n" .
							"<span class=\"addrvalue\">" . $currentTotal . " BTC</span>" .
						"</div>\n" .
						"<br>\n" .
						"<div>\n" .
							"<span>Current USD Value: </span>\n" .
							"<span class=\"usdvalue\">$" . $usdValue . "</span>\n" .
						"</div>\n" .
						"<br>\n" .
						"<br>\n"
						;
	    }

			//compute total USD value of total BTC count
			$totalUSD = $totalBTC * $usdPrice;

			//compute possible number of ransomes paid
			$totalRansomsPaid = $totalUSD / 300;

			//format totals for readability
			$totalUSD = number_format($totalUSD, 2);
			$totalRansomsPaid = number_format($totalRansomsPaid);

			//template HTML containing overall totals
			echo
					"<div class =\"highlights\">\n" .
						"<span>Estimated WannaCry ransomes paid (assuming $300 USD per infection): </span>\n" .
						"<span class=\"addrvalue\">" . $totalRansomsPaid . "</span>\n" .
						"<br>\n" .
						"<br>\n" .
						"<span>Total BTC spent by WannaCry victims: </span>\n" .
						"<span class=\"addrvalue\">" . $totalBTC . " BTC</span>\n" .
						"<br>\n" .
						"<br>\n" .
						"<span>Current USD equivalent total: </span>\n" .
						"<span class=\"usdvalue\">$" . $totalUSD . "</span>\n" .
					"</div>";
		?>
		<p>* USD prices for BTC are obtained from <a href="https://coinbase.com">CoinBase</a>.</p>
		<br>
		<p>This website was built as a favor to the digital community by <a href="http://stevenbock.me">Steven Bock</a>.</p>
		<p>If you have any questions or comments, feel free to contact me via <a href="mailto:steven@stevenbock.me">eMail</a> or on <a href="https://twitter.com/dabockster">Twitter</a>.
		<p>You can also follow further development of this site on <a href="https://github.com/dabockster/WannaCryProfits">GitHub</a>.</p>
		<br>
		<p>If you found this information useful, consider tipping me some BTC.</p>
		<p>1JwAifJtE9SXocZe2MvXTK1pdbCHPYwFVY</p>
	</body>
</html>
