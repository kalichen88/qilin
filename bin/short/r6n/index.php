<?php
$args = $argv;
$execFile = $args[0];
$url = urlencode($args[1]);
$key = $args[2];


$api = "http://api.ft12.com/r6m.php?format=json&url={$url}&apikey=$key";

$response = file_get_contents($api);
$jsonResponse = json_decode($response, true);

if ($jsonResponse['status'] != -1) {
    echo $jsonResponse['url'];
} else {
    echo $response;
}
