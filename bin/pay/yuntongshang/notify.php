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
$appId = $payConfig[2];

/*请求的参数*/
$requestParams = json_decode($payInfo[4], true);
/*回调的参数*/
$notifyParams = json_decode($notifyInfo[2], true);




ksort($notifyParams);
if( $notifyParams['app_id']==$appId){
     echo "1";
    exit();
}

else{
    echo "0";
    exit();
}








