<?php
//setting header to json
header('Content-Type: application/json');

//database
$dbhost = "localhost";
$dbname = "dbname";
$dbusername = "username";
$dbpassword = "password";

$link = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['last1440'])) {
	$statement = $link->query("(SELECT id, height, round(alreadyGeneratedCoins/1000/100) as alreadyGeneratedCoins, round(difficulty/60) as hashrate, difficulty, timestamp FROM blockinfo WHERE (height % 25) = 0 ORDER BY id DESC LIMIT 1440) ORDER BY height ASC;");
	$result = $statement ->fetchAll();
} else {
	$statement = $link->query("SELECT height, round(alreadyGeneratedCoins/1000/100) as alreadyGeneratedCoins, round(difficulty/60) as hashrate, difficulty, timestamp FROM blockinfo WHERE (height % 1000) = 0;");
	$result = $statement ->fetchAll();
}

//now print the data
print json_encode($result);


?>