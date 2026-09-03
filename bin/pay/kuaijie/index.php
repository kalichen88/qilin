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


// 部分代码
$data = [
'pid'=>$appId,
'name'=>$productName,
'type'=>'wxpay',
'money'=>$price,
'out_trade_no'=>$orderId,
'notify_url'=>$notifyUrl,
'return_url'=>$returnUrl
];
$key = $appKey; // 例子

// 签名方法
function getSign($param, $key)
{
$signPars = "";
ksort($param);
foreach ($param as $k => $v) {
if ("sign" != $k) {
$signPars .= $k . "=" . $v . "&";
}
}
$signPars = rtrim($signPars, '&');
$signPars .= $key;
$sign = md5($signPars); // 此处要md5加密小写
return $sign;
}



$sign=getSign($data,$key);
$data['sign']=$sign;
updateRequest($orderId, json_encode($data));
$htmls = "<form id='payForm' name='payForm' action='" . $payGateway . "/submit' method='post'>";
foreach ($data as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";

exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);

