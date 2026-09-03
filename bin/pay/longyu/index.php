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

$apiUrl='http://'.$payGateway.'/api/do_pay';

function mp_pay($id, $key, $type, $trade_no, $name, $money, $notify_url, $return_url, $mchid = '')
{
    global $apiUrl;
    
    
    $data = [
        'id'           => $id,
        'out_trade_no' => $trade_no,
        'name'         => $name,
        'type'         => $type,
        'money'        => $money,
        'mchid'        => $mchid,
        'notify_url'   => $notify_url,
        'return_url'   => $return_url,
    ];
    $data = array_filter($data);
    ksort($data);
    $str1 = '';
    foreach ($data as $k => $v) {
        $str1 .= '&' . $k . "=" . $v;
    }

    $sign = md5(trim($str1 . $key, '&'));

    $data['sign']      = $sign;
    $data['sign_type'] = 'MD5';
   
    $htmls = "<form id='payForm' name='payForm' action='" . $apiUrl . "' method='post'>";
    foreach ($data as $key => $val) {
        $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
    }
    $htmls .= "</form>";
    return $htmls;
}




exit(
json_encode(array('type' => "form", "data" => mp_pay($appId,$appKey,$payChannel,$orderId,$productName,$price,$notifyUrl,$returnUrl,""), "status" => "success"))
);
