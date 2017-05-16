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

    {{#each addressData}}
    <div>
      <span class="regularText">Address: </span>
      <br>
      <span class="btcAddress">{{@key}}</span>
    </div>
    <br>
    <div>
      <span class="regularText">Value (BTC): </span>
      <br>
      <span class ="btcValue">{{this}} BTC</span>
    </div>
    <br>
    <div>
      <span class="regularText">Value (USD): </span>
      <br>
      <span class="usdValue">$</span>
    </div>
    <br>
    <br>
    {{/each}}

    <h3>Total BTC spent by WannaCry victims: {{totalBTC}} BTC</h3>
    <h3>Current USD equivalent: <u>${{totalUSD}}</u></h3>
    <p>* USD prices for BTC are obtained from <a href="https://coinbase.com">CoinBase</a>.</p>

	</body>
</html>