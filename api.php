<?php
$API_URL = 'http://localhost/ims/api/employee/read.php';
$json = file_get_contents($API_URL);
$data = json_decode($json, true);

// print_r ($data['data']);

foreach($data['data'] as $data){
    echo $data['username'].'<br>';
}