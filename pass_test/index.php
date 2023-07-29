<?php
session_start();
ini_set('display_errors','off');
include "ua.php";

if (!$_SESSION["uid"]){
    $_SESSION["uid"] = uniqid();
    $_SESSION["send"] = 0;
    $_SESSION["time"] = time();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .box{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        p{
            color: #6676FF;
            font-weight: bold;
        }
        a{
            text-decoration: none;
            background-color: #cce5ff;
        }
    </style>
    <title>首页</title>
</head>
<body>
<div class="box">
    <p>这是一个收集用户名和密码并测试字典命中率的系统。快来试试吧！--By 清晨</p>
    <p>再日常渗透中，你会遇到很多系统的密码，比如用户名可能是test也可能是admin。</p>
    <p>密码可能是Qingchen@2023这种，名称+特殊字符+年份这种这种密码</p>
    <p>也可能是1qaz@WSX这种，复杂的常见规律密码。</p>
    <p>每个人都遇到过属于自己的组合密码方式，您觉得有什么密码组合方式可以录入提交：</p>
    <p><a href="input.php">录入用户名和密码</a></p>
    <p>系统已经存了一些大佬录入的密码，您可以尝试使用您的字典跑一下看看能跑出来几个？</p>
    <p><a class="a2" href="login.php">测试字典命中率</a></p>
</div>
</body>
</html>