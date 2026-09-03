<?php
$args = $argv;
$execFile = $args[0];
$url = urlencode($args[1]);
$key = $args[2];


$api = "http://r8n.cn/api/?key={$key}&url={$url}&format=json";


$response = file_get_contents($api);
$jsonResponse = json_decode($response, true);
if ($jsonResponse['error'] == 0) {
    echo $jsonResponse['short'];
} else {
    echo $response;
}
