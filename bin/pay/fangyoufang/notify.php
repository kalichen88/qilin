<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/sign.php";
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";


$args = $argv;
$execFile = $args[0];
$orderId = $args[1];
$payInfo = findOrder($orderId);
$params = json_decode($payInfo[2], true);
$payConfig = findPayInfo($payInfo[5]);
$notifyInfo = findNotify($orderId);
/*商户key*/
$appKey = $payConfig[3];
/*请求的参数*/
$requestParams = json_decode($payInfo[4], true);
/*回调的参数*/
$notifyParams = json_decode($notifyInfo[2], true);

$out_trade_no = $notifyParams['out_trade_no'];//提交的订单号
$trade_no =  $notifyParams['trade_no'];//平台订单号


$sign = md5(substr(md5($out_trade_no.$trade_no.$appKey),10));//$key是你的秘钥

if($sign ==$notifyParams['newsign']){
       echo "1";
} else {
    $filename = 'log.txt';
    $word = "签名验证失败 订单号:" . $orderId;
    $fh = fopen($filename, "a");
    fwrite($fh, $word);
    fclose($fh);
    echo "0";
};
