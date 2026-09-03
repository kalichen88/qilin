<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";

/**
 * Returns the url query as associative array
 *
 * @param string    query
 * @return    array    params
 */
function convertUrlQuery($query)
{
    $queryParts = explode('&', $query);

    $params = array();
    foreach ($queryParts as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }

    return $params;
}

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
$payExtra = json_decode($payConfig[5], true);
$productName = $payConfig[6];
$payType = $payConfig[7];
$notifyUrl = $params['notifyUrl'];
$returnUrl = $params['returnUrl'];
$price = $params['price'];


$orderInfo=findOrderInfo($orderId);

$ip=$orderInfo[12];
$ua = $payInfo[8];
if (strpos($ua, 'MicroMessenger')) {
   $data = array(
    'appid' => $payExtra['appId'],
    'mch_id' => $appId, //商户ID，后台提取
    'out_trade_no' => $orderId, //商户订单号
    'nonce_str' => '5K8264ILTKCH16CQ2502SI8ZNMTM67VS',
    'total_fee' => $price * 100, //金额
    'spbill_create_ip' => $ip,
    'body' => $productName, //商品名称
    'trade_type' => "JSAPI", //支付模式 二维码qrcode h5 wap
    'payment' => 'wechat', //微信支付
    'notify_url' => $notifyUrl, //回调地址
    'sign_type' => 'MD5',
    'openid'=>""
);


$payurl = $payGateway;
$Md5key = $appKey; //签名密钥，后台提取
updateRequest($orderId, json_encode($data));
        $formUrl = "/view/pay/wxjsapi";
        $data = array("orderId" => $orderId);
        $htmls = "<form id='payForm' name='payForm' action='" . $formUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));
}
else{
    exit(json_encode(array("status" => "fail", "type" => "url", "data" => "请在微信内打开")));
}


