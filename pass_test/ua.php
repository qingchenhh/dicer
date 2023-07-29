<?php
$a = array("Mozilla","Firefox","AppleWebKit","Chrome","Safari");
$na = array("Googlebot","Baiduspider","spider","360Spider","bingbot","YandexBot");

if (isset($_SERVER['HTTP_USER_AGENT'])){
    $ua = $_SERVER['HTTP_USER_AGENT'];
    // echo $ua;
    if(preg_match("/(".implode('|',$a).")/i",$ua)){
        if(preg_match("/(".implode('|',$na).")/i",$ua)){
            header("Location:https://www.baidu.com/");
            exit();
        }
    }else{
        header("Location:https://www.baidu.com/");
        exit();
    }
}else{
    header("Location:https://www.baidu.com/");
    exit();
}