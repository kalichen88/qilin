<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";
include "dynamic/lib/sign.php";

$args = $argv;
$execFile = $args[0];
$orderId = $args[1];
$payInfo = findOrder($orderId);
$params = json_decode($payInfo[2], true);
$payConfig = findPayInfo($payInfo[5]);
$appId = $payConfig[2];
$appKey = $payConfig[3];
$payGateway = $payConfig[4];
$productName = $payConfig[6];
$notifyUrl = $params['notifyUrl'];
$returnUrl = $params['returnUrl'];
$price = $params['price'];
$payChannel = $payConfig[7];

$data = array(
    "pid" => $appId,
    "type" => $payChannel,
    "notify_url" => $notifyUrl,
    "return_url" => $returnUrl,
    "out_trade_no" => $orderId,
    "name" => $productName,
    "money" => $price,
);

$data = array_filter($data);
ksort($data);
$str1 = '';
foreach ($data as $k => $v) {
    $str1 .= '&' . $k . "=" . $v;
}

$key = $appKey;
$sign = md5(trim($str1 . $key, '&'));

$data['sign'] = $sign;
$data['sign_type'] = 'MD5';

updateRequest($orderId, json_encode($data));

$htmls = "<form id='payForm' name='payForm' action='" . $payGateway . "submit.php" . "' method='post'>";
foreach ($data as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";
exit(
json_encode(array("type" => "form", "data" => $htmls, "status" => "success"))
);