<?php

$medals = json_decode(file_get_contents("medallas_khux.json"), true);
$responses = [];
$csv = "";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://khuxtracker.com/ajax.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

foreach ($medals as $index => $tier) {
	foreach ($tier["medals"] as $medal) {
		//echo $medal["slug"] . PHP_EOL;

		curl_setopt($ch, CURLOPT_POSTFIELDS, "id={$medal["slug"]}&method=single&type=view");
		$output = curl_exec ($ch);
		$responses[$medal["slug"]] = json_decode($output, true);
	}
}

curl_close ($ch);
