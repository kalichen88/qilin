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
function markSign($paydata, $signkey)
{
    ksort($paydata);
    $str = '';
    foreach ($paydata as $k => $v) {
        if ($k != "sign" && $v != "") {
            $str .= $k . "=" . $v . "&";
        }
    }
 
    return strtoupper(md5($str . "cert=" . $signkey));
}
$data = array(
    "key" => $appId,
    "fee" => $price * 100,
    "body" => $productName,
    "order" => $orderId,
    "randStr" => "randStr",
    "notify" => $returnUrl,
    "notice_url" => $notifyUrl
);

$Md5key = $appKey; //签名密钥，后台提取
$data['sign'] = markSign($data, $Md5key);

$dataStr= http_build_query($data);
$apiUrl=$payGateway."?".$dataStr;
$htmls = "<form id='payForm' name='payForm' action='" .$payGateway . "' method='get'>";
foreach ($data as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";
exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);



