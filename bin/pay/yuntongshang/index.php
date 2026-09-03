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


function getHttpContent($url, $method = 'GET', $postData = array())
{
    $data = '';
    $header = array();
    if (!empty($url)) {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //30秒超时
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            //curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
            if (strstr($url, 'https://')) {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            }

            if (strtoupper($method) == 'POST') {
                $curlPost = is_array($postData) ? http_build_query($postData) : $postData;
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
            }
            $data = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            $data = '';
        }
    }
    return $data;
}


$data = array(
    "app_id" => $appId, //商户号
    "goods_title" => $productName,
    "goods_desc" => "tes",
    "order_id" => $orderId,
    "amount" => $price,
    "type" => $payChannel,
    "method" => "wap",
    "notify_url" => $notifyUrl
);

ksort($data);
$str1 = '';
foreach ($data as $k => $v) { //组装参数
    $str1 .= '&' . $k . "=" . $v;
}
$str1 = $str1 . "&secret={$appKey}";

$data['ip'] = "112.50.113.20";

$data['sign'] = strtoupper(md5(ltrim($str1, "&")));

$data['return_url'] = $returnUrl;

updateRequest($orderId, json_encode($data));
$res = getHttpContent($payGateway, "POST", $data);

$res = json_decode($res, true);


$ua = $payInfo[8];


if ($res['code'] != "000001") {
    exit(json_encode(array("status" => "fail", "type" => "url", "data" => $res['data']['error_info'])));
} else {
    $info = json_decode($res['data']['pay_info'], true);
    $payUrl = $info['pay_url'];

    if (strpos($ua, 'MicroMessenger')) {
    //微信内支付
   $htmls = "<form id='payForm' name='payForm' action='" . $payUrl . "' method='post'>";
    $htmls .= "</form>";
    exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));
}else{
      $formUrl = "/view/pay/qrcode";
        $data = array("result" => json_encode(array("result" => array("payInfo" => $payUrl))), "price" => $price, "orderId" => $orderId,"type"=>"zfb");
        $htmls = "<form id='payForm' name='payForm' action='" . $formUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));
}
    

    

}





