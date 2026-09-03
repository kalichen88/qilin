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
$payChannel = $payConfig[7];



$domain = $payGateway;
$merchantCode = $appId;
$merchantKey = $appKey;

$bodyJson->amount = $price * 100;
$bodyJson->channelType = '2:1';
$bodyJson->merchantOrderCode = $orderId;
$bodyJson->noticeUrl = $notifyUrl;
$bodyJson->returnUrl = $returnUrl;


$signStr = '';
foreach ($bodyJson as $key => $value) {
    $signStr .= $key . '=' . $value;
}
$signStr .= 'key=' . $merchantKey;
$requestJson=array();

$requestJson['merchantCode'] = $appId;
$requestJson['sign'] = md5($signStr);
$requestJson['body'] = $bodyJson;

$ch = curl_init($domain . '/order/payment/create');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestJson));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$response =  json_decode(curl_exec($ch),true);
curl_close($ch);



$htmls = "<form id='payForm' name='payForm' action='" . $response['body']['paymentUrl'] . "' method='get'>";
$htmls .= "</form>";

exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);
