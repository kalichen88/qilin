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
#支付渠道
$payType=$payConfig[7];
$notifyUrl = $params['notifyUrl'];
$returnUrl = $params['returnUrl'];
$price = $params['price'];


$bodyJson = [
    'amount' => $price * 100,
    'channelType' => $payType,
    'merchantOrderCode' => $orderId,
    'noticeUrl' => $notifyUrl,
    'returnUrl' => $returnUrl
];



$signStr = '';
foreach ($bodyJson as $key => $value) {
    $signStr .= $key . '=' . $value;
}
$signStr .= 'key=' . $appKey;



$requestJson = [
    'merchantCode' => $appId,
    'sign' => md5($signStr),
    'body' => $bodyJson
];


updateRequest($orderId, json_encode($requestJson));

$ch = curl_init($payGateway . '/order/payment/create');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestJson, 256));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$response = curl_exec($ch);
curl_close($ch);

$jsonResponse = json_decode($response, true);
$htmls = "<form id='payForm' name='payForm' action='" . $jsonResponse['body']['paymentUrl'] . "' method='get'>";
$htmls .= "</form>";
exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);



