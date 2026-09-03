<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";

/** 
 * Returns the url query as associative array 
 * 
 * @param    string    query 
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
$productName = $payConfig[6];
$notifyUrl = $params['notifyUrl'];
$returnUrl = $params['returnUrl'];
$price = $params['price'];

$ua = $payInfo[8];
$payType = "wap";
if (strpos($ua, 'MicroMessenger')) {
    //微信内支付
    $payType = "qrcode";
}
$data = array(
    'mchId' => $appId, //商户ID，后台提取
    'billNo' => $orderId, //商户订单号
    'totalAmount' => $price * 100, //金额
    'billDesc' => $productName, //商品名称
    'way' => $payType, //支付模式 二维码qrcode h5 wap
    'payment' => 'wechat', //微信支付
    'notifyUrl' => $notifyUrl, //回调地址
    'returnUrl' => $returnUrl, //同步跳转
);

$payurl = $payGateway;
$Md5key = $appKey; //签名密钥，后台提取
$data['sign'] = markSign($data, $Md5key);

updateRequest($orderId, json_encode($data));




$payUrl = "http://$payurl/game/unifiedorder"; //请求订单地址
$ret = curl($payUrl, json_encode($data));
$jsonResponse = json_decode($ret, true);



if ($jsonResponse['code'] == 0) {
    $formUrl = "";
    if (strpos($ua, 'MicroMessenger')) {
        $formUrl = "/view/pay/qrcode";
        $data = array("result" => $ret, "price" => $price, "orderId" => $orderId,"type"=>"wechat");
        $htmls = "<form id='payForm' name='payForm' action='" . $formUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));
    } else {
         $formUrl = "/view/pay/h5";

     

        $data = array("result" => $ret, "price" => $price, "orderId" => $orderId);
       
        $htmls = "<form id='payForm' name='payForm' action='" . $formUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));
    }
} else {
    exit(json_encode(array("status" => "fail", "type" => "url", "data" => $jsonResponse['message'])));
}
