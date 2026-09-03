<?php
$rootPath = dirname(dirname(dirname(dirname(__FILE__))));
ini_set("include_path", $rootPath);
$config = require("config/autoload/databases.php");
$dataConfig = $config['default'];
$conn = mysqli_connect(
    $dataConfig['host'],
    $dataConfig['username'],
    $dataConfig['password'],
    $dataConfig['database'],
    $dataConfig['port']
);

 if (!$conn) { echo("连接失败: " . mysqli_connect_errno());exit(); }

function findPayInfo($model)
{
    global $conn;
    $sql = "SELECT * FROM video_pay where model =" . "'" . $model . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    return $row;
}

/*data string*/
function updateRequest($orderId, $data)
{
    
    global $conn;
    $sql = "UPDATE  video_pay_request SET  requestParams =" . "'" . $data . "'" . "WHERE orderId =" . '"' . $orderId . '"';
   
    $result = mysqli_query($conn, $sql);
    return true;
}

function findNotify($orderId)
{
    global $conn;
    $sql = "SELECT * FROM video_notify where orderId =" . "'" . $orderId . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    return $row;
}

function findOrder($orderId)
{
    global $conn;
    $sql = "SELECT * FROM video_pay_request where orderId =" . "'" . $orderId . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    return $row;
}


function findOrderInfo($orderId){
    global $conn;
    $sql = "SELECT * FROM video_order where orderId =" . "'" . $orderId . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_row($result);
    return $row;
}





