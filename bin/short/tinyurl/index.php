<?php
$args = $argv;
$execFile = $args[0];
$url = urlencode($args[1]);
$key = $args[2];

$short = "tinyurl";
$api = "http://91up.top/api/tools/$short?token=$key&domain=" . $url;

$curl = curl_init();
//设置抓取的url
curl_setopt($curl, CURLOPT_URL, $api);
//设置头文件的信息作为数据流输出
curl_setopt($curl, CURLOPT_HEADER, false);
//设置获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//执行命令
$data = curl_exec($curl);
//关闭URL请求
$response = json_decode($data, true);
if ($response['data']['status_code'] == 0) {
    echo $response['data']['short_url'];
} else {
    echo $data;
}
