<?php
session_start();
ini_set('display_errors','off');

include "ua.php";

if (!$_SESSION['uid']){
    header("Location:index.php");
}

include "config.php";

$sql = "select date_time from mz";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$s = $stmt->fetchAll();
if ($s){
    foreach ($s as $k=>$v){
        if(time() - (int)$v['date_time'] >= 604800){
            $sql1 = "delete from mz where date_time=:date_time";
            $stmt1 = $pdo->prepare($sql1);
            $stmt1->execute(['date_time'=>$v['date_time']]);
        }
    }
}
?>