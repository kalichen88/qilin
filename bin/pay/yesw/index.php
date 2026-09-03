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


function getSign($data,$Token)
         {
             $data = array_filter($data);
            if (get_magic_quotes_gpc()) {
            $data = stripslashes($data);
            }
            ksort($data);
            $str1 = '';
            foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
             }
            $str = $str1 . $Token;
            $str = trim($str, '&');
            $sign = md5($str);
            return $sign;
          }





$payChannel = $payConfig[7];

        $data = [
            'id' => $appId,    //商户ID
            'trade_no' => $orderId,    //订单号
            'name' => $productName,    //商品名称
            'money' => $price,  //商品金额
            'type' => $payChannel,    //支付渠道
            'notify_url' => $notifyUrl,    //支付结果接收地址
            'sync_notify_url' => $returnUrl,  //同步通知地址
            'mchid' => '',    //指定商户号
        ];
        $sign = getSign($data,$appKey);  //签名数据 $Token=对接Token
        $data['sign'] = $sign;
        $data['sign_type'] = 'MD5';

       




updateRequest($orderId, json_encode($data));


$htmls = "<form id='payForm' name='payForm' action='" . $payGateway . "' method='get'>";
foreach ($data as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";

exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);
