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

$data = [
    'url' => $payurl, //
    'id' => $appId, //商户id
    'trade_no' => $orderId, //订单号
    'name' => $productName, //名称
    'money' => $price, //金额'
    'notify_url' => $notifyUrl, //这里是通知的地址，填入要给您get数据的地址
    'return_url' => $returnUrl, //这里是支付成功后跳转的地址，填入您想跳转的地址即可
    'AGENT' => $payInfo[8],
    'json' => 1, //输出页面
];

$data = array_filter($data);
if (@get_magic_quotes_gpc()) {
    $data = stripslashes($data);
}
ksort($data);
$parameter = $data;
unset($parameter['url']);
ksort($parameter);
reset($parameter);
$fieldString = http_build_query($parameter);
$sign = md5(substr(md5($parameter['trade_no'] . $appKey), 10));
$parameter['sign'] = $sign;
$parameter['sign_type'] = 'MD5';
$parameter['path'] = "/view/pay/checkOrderstatus_fangyoufang?orderId=".$orderId;
$fieldString = http_build_query($parameter);

updateRequest($orderId, json_encode($parameter));

$purl = $payGateway . "?" . $fieldString;


$htmls = "<form id='payForm' name='payForm' action='/view/pay/cusmtomPay?url=" . urlencode( $purl) . "' method='post'>";
$htmls .= "</form>";
#这个回调要特殊处理 太sb了
exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);


