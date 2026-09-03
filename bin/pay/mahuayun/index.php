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


function getSign($data,$Token)
         {
             $data = array_filter($data);
            if (get_magic_quotes_gpc()) {
            $data = stripslashes($data);
            }
            ksort($data);
            $str1 = '';
            foreach ($data as $k => $v) {
            $str1 .= '&' . $k . "=" . $v;
             }
            $str = $str1 . $Token;
            $str = trim($str, '&');
            $sign = md5($str);
            return $sign;
          }





$payChannel = $payConfig[7];



    $url = $payGateway;
    $data = [
        'pid'          => $appId,
        'name'         => $productName,
        'type'         => $payChannel,
        'money'        => $price,
        'out_trade_no' => $orderId,
        'notify_url'   => $notifyUrl,
        'return_url'   => $returnUrl,
    ];
    $data = array_filter($data);
    ksort($data);
    $str1 = '';
    foreach ($data as $k => $v) {
        $str1 .= '&' . $k . "=" . $v;
    }
    $sign = md5(trim($str1 . $appKey, '&'));
    $data['sign']      = $sign;
    if (strpos($ua, 'MicroMessenger')) {
        $data['is_wx_browser']      = '1'; // 不参与签名
    }else{
         $data['is_wx_browser']      = '0'; // 不参与签名
    }
    

    $headers = array('Content-Type: application/x-www-form-urlencoded');
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Post提交的数据包
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno'.curl_error($curl);//捕抓异常
    }
    curl_close($curl); // 关闭CURL会话
   
    $result = json_decode($result, true);
    if ($result['code'] != 200) {
        
        exit(json_encode(array("status" => "fail", "type" => "url", "data" => $result['msg'])));
    }
    $wxUrl = $result['data']['wxUrl']; 

 


updateRequest($orderId, json_encode($data));


$htmls = "<form id='payForm' name='payForm' action='" . $wxUrl . "' method='post'>";
$htmls .= "</form>";

exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);
