<?php
ini_set('display_errors','off');

include "ua.php";

$hostname = 'localhost'; // MySQL主机名
$database = 'pass'; // 数据库名称
$username = 'qingchen'; // 用户名
$password = 'T##$sT0201'; // 密码

try {
    $db = "mysql:host=$hostname;dbname=$database";
    $pdo = new PDO($db, $username, $password);

} catch (PDOException $exception) {

    die('连接数据库时发生错误：'.$exception->getMessage());

}