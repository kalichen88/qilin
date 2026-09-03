<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";

$args = $argv;
$execFile = $args[0];
$orderId = $args[1];
$payInfo = findOrder($orderId);
$params = json_decode($payInfo[2], true);
$payConfig = findPayInfo($payInfo[4]);
$appId = $payConfig[2];
$appKey = $payConfig[3];
$payGateway = $payConfig[4];
$productName = $payConfig[6];
$notifyUrl = $params['notifyUrl'];
$returnUrl = $params['returnUrl'];
$price = $params['price'];

$payChannel = $payConfig[7];
$data = [
    'pid' => $appId,
    'type' => $payChannel,
    'money' => $price,
    'name' => 'test',
    'out_trade_no' => $orderId,
    'notify_url' => $notifyUrl,
    'return_url' => $returnUrl,
];


$data = [
    'pid' => $appId,
    'out_trade_no' => $orderId,
    'name' => "test",
    'type' => $payChannel,
    'money' => $price,
    //'mchid' => '5jl5dXZ5ss7R2DGks9GS',
    'notify_url' => $notifyUrl,
    'return_url' => $returnUrl,
];

$data = array_filter($data);
ksort($data);
$str1 = '';
foreach ($data as $k => $v) {
    $str1 .= '&' . $k . "=" . $v;
}
$url = $payGateway;
$key = $appKey;
$sign = md5(trim($str1 . $key, '&'));

$data['sign'] = $sign;
$data['sign_type'] = 'MD5';

updateRequest($orderId, json_encode($data));

$htmls = "<form id='payForm' name='payForm' action='" . $url . "' method='post'>";
foreach ($data as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";

exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);
