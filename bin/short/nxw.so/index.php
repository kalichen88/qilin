<?php
$args = $argv;
$execFile = $args[0];
$url = urlencode($args[1]);
$key = $args[2];

$date = date('Y-m-d', time() + 86400);
$api = "http://api.3w.cn/api.htm?format=json&url={$url}&key={$key}&expireDate={$date}";


$response = file_get_contents($api);
$jsonResponse = json_decode($response, true);
echo $jsonResponse['url'];
