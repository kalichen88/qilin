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




function convertUrlQuery($query) { 
    $queryParts = explode('&', $query); $params = array(); foreach ($queryParts as $param) { $item = explode('=', $param); $params[$item[0]] = $item[1]; } return $params; } 
    function getUrlQuery($array_query) { $tmp = array(); foreach($array_query as $k=>$param) { $tmp[] = $k.'='.$param; } $params = implode('&',$tmp); return $params; 
        
    } 

function get_cur($url, $data="", $type="GET", $header="")
{
    $HTTP_REFERER='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
    curl_setopt($ch, CURLOPT_REFERER, $HTTP_REFERER);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    if (!empty($data)) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    if (!empty($header)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $temp = curl_exec($ch);
    curl_close($ch);
    return $temp;
}

function getSign(array $data, $appSecret)
{
    ksort($data);
    $need = [];
    foreach ($data as $key => $value) {
        if (! $value || $key == 'sign') {
            continue;
        }
        $need[] = "{$key}={$value}";
    }
    $string = implode('&', $need).$appSecret;

    return strtoupper(md5($string));
}


$data = [];
$data['mchid'] 			= $appId;//商户id
$data['out_trade_no'] 	=$orderId;//订单号
$data['total_fee'] 		= $price*100;//金额 分单位
$data['callback_url']	= $returnUrl;//支付成功同步回调页面
$data['notify_url'] 	= $notifyUrl;//异步回调地址
$data['error_url'] 		= $returnUrl;//支付取消同步回调页面

    $sign = getSign($data, $appKey);

	$data['sign'] = $sign;
	$url = $payGateway;

	$result = get_cur($url, $data, 'POST');
    

    $result = json_decode($result, true);

    $payUrl = $result['data']['payUrl'];

    

 $u=parse_url($payUrl);
    $webUrl="http://". $u['host'].$u['path'];
   
    $params=   convertUrlQuery($u['query']);


$htmls = "<form id='payForm' name='payForm' action='" . $webUrl . "' method='get'>";
foreach ($params as $key => $val) {
    $htmls .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
}
$htmls .= "</form>";


 exit(json_encode(array("type" => "form", "data" => $htmls, "status" => "success")));
?>