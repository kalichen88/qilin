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
$payChannel = $payConfig[7];

$data = array(
    "id" => $appId,
    "key"=>$appKey,
    "trade_no" => $orderId,
    "name" => $productName,
    "money" => $price,
    "notify_url" => $notifyUrl,
    "return_url" => $returnUrl
);



$key = $appKey;
$sign = markSign($data, $key);

$data['sign'] = $sign;
$data['sign_type'] = 'MD5';

updateRequest($orderId, json_encode($data));
$apiUrl = $payGateway . '?' . http_build_query($data);

 $ch = curl_init();    
           curl_setopt($ch, CURLOPT_URL, $apiUrl);    
            //参数为1表示传输数据，为0表示直接输出显示。  
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
            //参数为0表示不带头文件，为1表示带头文件  
           curl_setopt($ch, CURLOPT_HEADER,0);  
           $output = curl_exec($ch);   
           curl_close($ch);   
           $response=json_decode($output,true);
           $payUrl=$response['url'];

$htmls = "<form id='payForm' name='payForm' action='" . $payUrl . "' method='post'>";
$htmls .= "</form>";
exit(
json_encode(array("type" => "form", "data" => $htmls, "status" => "success"))
);



