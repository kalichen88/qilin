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

$ua = $payInfo[8];


//进行sgin签名验证
$sign = md5($appId.$orderId.'budpay'.'1'.($price).$appKey);

$data = array (
		'mid' => $appId, //商户ID，后台提取
		'payId' => $orderId, //商户订单号
		'type' => 1, //微信支付
		'price' => $price, //金额
		'sign' =>  $sign, //sgin
		'param' => 'budpay', //微信支付
		'isHtml' => 0, //0是返回json格式
		'notifyUrl' => $notifyUrl, //异步跳转 
		'returnUrl' => $returnUrl,//同步跳转
);



updateRequest($orderId, json_encode($data));

$payUrl = "http://$payGateway/createOrder"; //请求订单地址
$ret = curl($payUrl, json_encode($data));


$jsonResponse = json_decode($ret, true);
if ($jsonResponse['code'] == 1) {
    $formUrl = "/view/pay/qrcode";
        $data = array("result" => json_encode(array("result"=>array("payInfo"=>$jsonResponse['data']['payUrl']))), "price" => $jsonResponse['data']['reallyPrice'], "orderId" => $orderId,"type"=>"wechat");
        $htmls = "<form id='payForm' name='payForm' action='" . $formUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));
}
else {
    exit(json_encode(array("status" => "fail", "type" => "url", "data" => $jsonResponse['message'])));
}

