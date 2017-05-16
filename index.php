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
      $addresses = array(
        "12t9YDPgwueZ9NyMgw519p7AA8isjr6SMw",
        "115p7UMMngoj1pMvkpHijcRdfJNXj6LrLn",
        "13AM4VW2dhxYgXeQepoHkHSQuy6NgaEb94",
        "1QAc9S5EmycqjzzWDc1yiWzr9jJLC8sLiY",
        "15zGqZCTcys6eCjDkE3DypCjXi6QWRV6V1"
      );

      
    ?>
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
