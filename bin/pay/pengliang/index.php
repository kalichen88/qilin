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
             "mid" => $appId, 					//商户ID
            "payId" => $orderId, 				//商户订单号
            "param" => $productName, 		//自定义参数，可以传入 用户名称,商品名称,订单标题 等根据自己需求传入,将会原样返回到同步和异步通知接口
            "type" => 1, 	//微信支付传入1 支付宝支付传入2
            "price" =>$price,		//订单金额
         //   "sign" => $sign, 				//签名，计算方式为 md5(mid+payId+param+type+price+商户密钥)
            "notifyUrl" => $notifyUrl, 		//传入则设置该订单的异步通知接口为该参数，不传或传空则使用后台设置的接口
            "returnUrl" => $returnUrl, 		//传入则设置该订单的同步跳转接口为该参数，不传或传空则使用后台设置的接口
            "isHtml" => 1, 					//传入1则跳转到支付页面，不传或“0”返回创建结果的json数据,建议填 1
        );
        
//加密参数获取签名,签名顺序以及计算方式为 md5(mid+payId+param+type+price+商户密钥)
$sign = md5($appId.$data['payId'].$data['param'].$data['type'].$data['price'].$appKey);
$data['sign']=$sign;
updateRequest($orderId, json_encode($data));
$htmls = "<form id='payForm' name='payForm' action='" . $payGateway . "' method='post'>";
foreach ($data as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";

exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);




