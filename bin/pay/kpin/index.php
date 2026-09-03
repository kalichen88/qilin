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


  $data = array(
            "api_id" => $appId, //商户号
            'record' => $orderId,
            'money' => sprintf("%.2f", $price),
            'notify_url' => $notifyUrl,
            'refer' => $returnUrl,
            'mid' => '',
        );

        $datas = [
            'api_id' => $appId, //商户ID
            'record' => $orderId, //附加参数
            'money' => sprintf("%.2f", $price) //金额
        ];
        ksort($datas);
        $str1 = '';
        foreach ($datas as $k => $v) { //组装参数
            $str1 .= '&' . $k . "=" . $v;
        }

        $data['sign'] = md5(trim($str1) . $appKey);
updateRequest($orderId, json_encode($data));
$htmls = "<form id='payForm' name='payForm' action='" . $payGateway . "' method='post'>";
foreach ($data as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";
exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);
