<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";


   function curl_($sUrl, $aHeader, $aData) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $sUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );// 不可去掉 否则拉起慢
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aData));
    $sResult = curl_exec($ch);
    
    if ($sError = curl_error($ch)) {
        die($sError);
    }
    curl_close($ch);
    return $sResult;
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


$ua = $payInfo[8];


$parameter = array(
        "pid" => $appId,//商户ID
        "type" => "html",//支付方式 , json 
        "out_trade_no" => $orderId,//订单号
        "notify_url" => $notifyUrl,//异步地址
        "return_url" => $returnUrl, //同步地址
        "name" => $productName, //商品名
        "money" =>$price, //金额
    );
    ksort($parameter); 
    reset($parameter); 
    $fieldString = [];
    foreach ($parameter as $key => $value) {
        if(!empty($value)){
           $fieldString[] = $key . "=" . $value . "";
        }
    }
    $fieldString = implode('&', $fieldString);
    $parameter['sign'] = md5($fieldString.$appKey);
    
    $header =  array('KTYPE:naizhao', 'User-Agent:' . $ua);  
    //请求头Ktype User-Agent必须带 不支持from表单提交 User-Agent 用于识别客户浏览器UA
    $html =  curl_($payGateway,$header,$parameter);
    

    

    $formUrl = "/view/pay/customPage";

     updateRequest($orderId, urlencode( $html));

        $data = array( "orderId" => $orderId);
        
        $htmls = "<form id='payForm' name='payForm' action='" . $formUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));

