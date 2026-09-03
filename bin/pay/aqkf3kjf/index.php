<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
include "dynamic/lib/utils.php";
include "dynamic/lib/mysql.php";



	function httpPost($url, $paramStr){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $paramStr,
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded"
		  ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
		  return $err;
		}
		return $response;
	}
	
	function paramArraySign($paramArray, $mchKey){
		
		ksort($paramArray);  //字典排序
		reset($paramArray);
	
		$md5str = "";
		foreach ($paramArray as $key => $val) {
			if( strlen($key)  && strlen($val) ){
				$md5str = $md5str . $key . "=" . $val . "&";
			}
		}
		$sign = strtoupper(md5($md5str . "key=" . $mchKey));  //签名
		
		return $sign;
		
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
$ua=$payInfo[8];
$payExtra = json_decode($payConfig[5], true);

	$amount = $price * 1 * 100; //元转换为分
    $paramArray = array(
		"mchId" => $appId, //商户ID
		"appId" => $payExtra["appId"],  //商户应用ID
		"productId" => $payChannel,  //支付产品ID
		"mchOrderNo" =>$orderId ,  // 商户订单号
		"currency" => 'cny',  //币种
		"amount" => $amount . "", // 支付金额
		"clientIp" => '210.73.10.148',   //客户端IP
		"device" => "ios10.3.1",    //客户端设备
		"returnUrl" => $returnUrl.urlencode("&") ,	 //支付结果前端跳转URL
		"notifyUrl" => $notifyUrl,	 //支付结果后台回调URL
		"subject" => 'test',	 //商品主题
		"body" => 'test',	 //商品描述信息
		"param1" => '',	 //扩展参数1
		"param2" =>  '',	 //扩展参数2
		"extra" =>  '',	 //附加参数
		"reqTime" => date("YmdHis"),	 //请求时间, 格式yyyyMMddHHmmss
		"version" => '1.0'	 //版本号, 固定参数1.0
    );
	$sign = paramArraySign($paramArray, $appKey);  //签名
	$paramArray["sign"] = $sign;

    

    

	$paramsStr = http_build_query($paramArray); //请求参数str






	$response = json_decode( httpPost($payGateway, $paramsStr),true);   


$htmls = "<form id='payForm' name='payForm' action='" . $response['payJumpUrl'] . "' method='get'>";
$htmls .= "</form>";

exit(
json_encode(array('type' => "form", "data" => $htmls, "status" => "success"))
);


?>