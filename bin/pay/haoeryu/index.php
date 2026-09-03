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
$payConfig = findPayInfo($payInfo[5]);
$appId = $payConfig[2];
$appKey = $payConfig[3];
$payGateway = $payConfig[4];
$productName = $payConfig[6];
$notifyUrl = $params['notifyUrl'];
$returnUrl = $params['returnUrl'];
$price = $params['price'];




$data = array(
    'client_id' => $appId, //商户ID，后台提取
    'out_trade_no' => $orderId, //商户订单号
    'total_fee' => $price , //金额
    'notify_url' => $notifyUrl, //回调地址
    'callback_url' => $returnUrl, //同步跳转
);



updateRequest($orderId, json_encode($data));


$payUrl = "http://$payGateway/api/create"; //请求订单地址

$ret = curl($payUrl, json_encode($data));

$jsonResponse = json_decode($ret, true);
$url=$jsonResponse['data']['pay_url'];


$htmls = "<form id='payForm' name='payForm' action='" . $url . "' method='post'>";
$htmls .= "</form>";
exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);
