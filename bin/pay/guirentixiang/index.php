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
#支付渠道
$payType=$payConfig[7];
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
$data = array(
    "merchant_order_sn"=>$orderId,
    "uid" => $appId,
    "total" => $price,
    "type" => $payType,
    "version" => "1.0",
    "url_return" => $returnUrl,
    "url_notify" => $notifyUrl
);

$Md5key = $appKey; //签名密钥，后台提取
$data['sign'] = markSign($data, $Md5key);

$dataStr= http_build_query($data);
$apiUrl=$payGateway."/api/order?".$dataStr;

 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $output = json_decode($output,true);
      
      $sign=$output['debug'];
      
$data['sign']=$sign;
$dataStr= http_build_query($data);
$apiUrl=$payGateway."/api/order?".$dataStr;
 $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
       
       
        $output = json_decode($output,true);
        
        
$htmls = "<form id='payForm' name='payForm' action='" .$output['data']['payinfo'] . "' method='get'>";
$htmls .= "</form>";
exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);



