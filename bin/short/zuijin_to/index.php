<?php
$args = $argv;
$execFile = $args[0];
$url = urlencode($args[1]);
$key = $args[2];



$api = "http://api.dwzjh.com/api/{$key}?name=jyouzancom&url={$url}";

$response = file_get_contents($api);
$jsonResponse = json_decode($response, true);

if ($jsonResponse['code'] == 200) {
    echo $jsonResponse['data']['url'];
} else {
    echo $response;
}
