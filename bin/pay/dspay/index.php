<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";


 function send_post($url, $post_data) {
 
  $postdata = http_build_query($post_data);
  $options = array(
    'http' => array(
      'method' => 'POST',
      'header' => 'Content-type:application/x-www-form-urlencoded',
      'content' => $postdata,
      'timeout' => 15 * 60 // 超时时间（单位:s）
    )
  );
  $context = stream_context_create($options);
  $result = file_get_contents($url, false, $context);
 
  return $result;
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
$pay_applydate = date("Y-m-d H:i:s");  //订单时间
$payChannel = $payConfig[7];
 //支付宝扫码  //商户后台通道费率页 获取银行编码







$native = array(
    "pay_memberid" => $appId,
    "pay_orderid" => $orderId,
    "pay_amount" => $price,
    "pay_applydate" => $pay_applydate,
    "pay_bankcode" => $payChannel,
    "pay_notifyurl" => $notifyUrl,
    "pay_callbackurl" => $returnUrl,
);
ksort($native);
$md5str = "";
foreach ($native as $key => $val) {
    $md5str = $md5str . $key . "=" . $val . "&";
}
//echo($md5str . "key=" . $Md5key);
$sign = strtoupper(md5($md5str . "key=" . $appKey));
$native["pay_md5sign"] = $sign;
$native['pay_attach'] = "127.0.0.1";
$native['pay_productname'] =$productName;


updateRequest($orderId, json_encode($native));

$re  = send_post($payGateway, $native);


$re = json_decode($re, true);

$payLink=$re['pay_link'];


$formUrl = "/view/pay/qrcode";
        $data = array("result" => json_encode(array("result"=>array("payInfo"=>$payLink))), "price" => $re['money'], "orderId" => $orderId,"type"=>"wechat");
        $htmls = "<form id='payForm' name='payForm' action='" . $formUrl . "' method='post'>";
        foreach ($data as $key => $val) {
            $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
        $htmls .= "</form>";
        exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));