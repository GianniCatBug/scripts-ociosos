<?php

$medals = json_decode(file_get_contents("medallas_khux.json"), true);
$limit = isset($argv[1]) ? (int) $argv[1] : null;
$medalCount = 0;
$responses = [];
$headers = [
"name_star", //Nombre de la medalla y número de estrellas
"method", //Esto tiene que ver con un parámetro que necesita la aplicación para devolver la información
"name", //Nombre de la carta
"mid", 
"kid", 
"alt", 
"rarity", //Al parecer coincide con el numero de estrellas
"supernova", 
"unlocked", 
"active", 
"jid", 
"tier", 
"attribute", //3: Magic, 2: Speed, 1: Power
"type", //0: Upright, 1: Reversed
"special", "special_sb", "special_sb_slot", "min_low_damage", "min_high_damage", "max_low_damage", "max_high_damage", 
"max_low_damage_sb", "max_high_damage_sb", "strength", "strength_min", "hits", "traitslots", "gauges", "gauges_additional", 
"aoe", "aoe_sb", "ability", "ability_sb", "review", "img"];

//TODO: Crear columnas para cada habilidad y binarizar

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://khuxtracker.com/ajax.php");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

foreach ($medals as $index => $star) {
	
	foreach ($star["medals"] as $medal) {
		$medalCount++;

		if ($medalCount <= $limit || is_null($limit)) {
			//echo $medal["slug"] . PHP_EOL;
			curl_setopt($ch, CURLOPT_POSTFIELDS, "id={$medal["slug"]}&method=single&type=view");
			$output = curl_exec ($ch);
			$responses[$medal["slug"]] = json_decode($output, true);
		}
	}
}

curl_close ($ch);

$fp = fopen("khux_medallas.csv", "w");
fputcsv($fp, $headers);

foreach ($responses as $medalSlug => $data) {

	foreach ($data as $key => $value) {
		if (is_int($key)) {
			array_unshift($value, $medalSlug . "_" . $key);
			fputcsv($fp, $value);
		}
	}
}

fclose($fp);
