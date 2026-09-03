<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";


function markSign($paydata, $signkey)
{
    ksort($paydata);
    $str = '';
    foreach ($paydata as $k => $v) {
        if ($k != "sign" && $v != "") {
            $str .= $k . "=" . $v . "&";
        }
    }
    return strtoupper(md5($str . "key=" . $signkey));
}


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
$pay_applydate = date("Y-m-d H:i:s");  //订单时间
$payChannel = $payConfig[7];
 //支付宝扫码  //商户后台通道费率页 获取银行编码

$data = array(
    "pay_memberid" => $appId,
    "pay_orderid" => $orderId,
    "pay_amount" => $price,
    "pay_applydate" => $pay_applydate,
    "pay_bankcode" => $payChannel,
    "pay_notifyurl" => $notifyUrl,
    "pay_callbackurl" => $returnUrl,
);

ksort($data);
$md5str = "";
foreach ($data as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
//echo($md5str . "key=" . $Md5key);
$sign = strtoupper(md5($md5str . "key=" . $appKey));
$data["pay_md5sign"] = $sign;
$data['pay_attach'] = "1234|456";
$data['pay_productname'] =$productName;

updateRequest($orderId, json_encode($data));

$htmls = "<form id='payForm' name='payForm' action='" . $payGateway . "' method='post'>";
foreach ($data as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";
exit(
json_encode(array("type" => "form", "data" => $htmls, "status" => "success"))
);