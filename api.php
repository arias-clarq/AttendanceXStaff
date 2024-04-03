<?php
$API_URL = 'https://cyber-techo.000webhostapp.com/config/api.php';
$json = file_get_contents($API_URL);
$data = json_decode($json, true);

echo $json;