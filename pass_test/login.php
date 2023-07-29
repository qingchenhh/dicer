<?php
session_start();
ini_set('display_errors','off');

include "ua.php";

if (!$_SESSION['uid']){
    header("Location:index.php");
}

include "config.php";

if (isset($_POST['reset']) && $_POST['reset']==="重新开始"){
    $sql_del = "delete from mz where uid=:uid";
    $stmt_del = $pdo->prepare($sql_del);
    $stmt_del->execute(['uid'=>$_SESSION["uid"]]);
}

$sql = "select count(user) from data";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$count = $stmt->fetchAll();
$count = (int)$count[0][0];


if (isset($_POST['user'])){
    $pass = isset($_POST['pass']) ? $_POST['pass'] : "";
    $_SESSION['send']++;
    $sql1 = "select user,pass from data where user=:user and pass=:pass";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute(['user' => $_POST['user'],'pass' => $pass]);
    $result1 = $stmt1->fetchAll();
    if ($result1){
        echo "大哥厉害，命中一条密码！<br />";
        $_SESSION['mz'] = round($_SESSION['count']/$count,2);
        $sql2 = "select user,pass from mz where uid=:uid and user=:user and pass=:pass";
        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute(['uid' => $_SESSION["uid"],'user' => $_POST['user'],'pass' => $pass]);
        $result2 = $stmt2->fetchAll();
//        var_dump(!$result2);
        if (!$result2){
            try{
                $sql3 = "INSERT INTO mz (uid,user,pass,date_time) VALUES (?, ?, ?, ?)";
                $stmt3 = $pdo->prepare($sql3);
                $stmt3->execute([$_SESSION["uid"],$_POST['user'],$pass,time()]);
            }catch (PDOException $exception) {
                echo '啊！出错啦！',$exception->getMessage();
            }
        }
    }else{
        echo "这次没有猜对，继续加油哦！";
    }
}

$sql4 = "select user,pass from mz where uid=:uid";
$stmt4 = $pdo->prepare($sql4);
$stmt4->execute(['uid' => $_SESSION["uid"]]);
$result4 = $stmt4->fetchAll();
$count_mz = count($result4);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body{
            background-color: #9acfea;
        }
        .box{
            margin: 0 auto;
            text-align: center;
        }
        p{
            color: #fff3cd;
            font-weight: bold;
        }
        .manualItem {
            text-align: left;
            max-height:0;
            overflow:hidden;
            transition:max-height .3s;
        }
        :checked ~ .manualItem {
            max-height:666px;
        }
        input[type="checkbox"] {
            position:fixed;
            clip:rect(0 0 0 0);
        }
        :checked ~ .check-in {
            display:none;
        }
        :checked ~ .check-out {
            display:inline-block;
        }
        .check-out {
            display:none;
        }
        .check-in,.check-out {
            color: #34538b;
            cursor:pointer;
        }
        table{
            width: 50%;
            border-collapse: collapse;
            font-size: 100%;
        }
        table caption{
            font-size: 150%;
            font-weight: bold;
        }
        th,td{
            border: 1px solid #5a5a5a;
            text-align: center;
            padding: 4px 0;
        }
        table thead tr{
            background-color: #999999;
            color: #fcaf3e;
        }
        table tbody tr:nth-child(odd){
            background-color: #cee3f1;
        }
        table tbody tr:hover{
            background-color: #ffeeba;
        }
        table tfoot tr td{
            text-align: right;
            padding-right: 20px;
        }
        .shi{
            color: red;
        }
    </style>
    <title>login</title>
</head>
<body>
    <div class="box">
        <p>假设这是一个单位的系统，该单位为帝亚迪科技有限公司，系统名字叫做资产管理系统。</p>
        <p>现在系统存在一些用户名和对应的密码，您可以在这里测试一下您的字典命中率。</p>
        <p>还望大佬们手下留情，速率调低一些，vps撑不住。</p>
        <p>(命中次数会叠加，如果您优化了您的字典想重新测试，需要点"重新开始按钮"重置您的命中次数。)</p>
        <p>当前命中率：<?php echo round($count_mz/$count,2)*100,"%"; echo "(",$count_mz,"/",$count,")";?></p>
        <form action="" method="post">
            用户:<input type="text" name="user"><br />
            密码:<input type="password" name="pass"><br />
            <input type="submit" value="登录">
            <input type="submit" name='reset', value="重新开始">
        </form>
    </div>
<!--    <div class="manualContent">-->
<!--        <input id="check" type="checkbox">-->
<!--        <div class="manualItem">-->
            <table>
                <caption>命中详情</caption>
                <thead>
                <th>USER</th>
                <th>PASSWORD</th>
                <th>是否命中</th>
                </thead>
                <tbody>
                    <?php
                        $user_arr = Array();
                        $pass_arr = Array();
                        if ($result4){
                            foreach ($result4 as $k=>$v){
                                $user_arr[] = $v['user'];
                                $pass_arr[] = $v['pass'];
                                echo "<tr>";
                                echo "<td>",htmlspecialchars($v['user']),"</td>";
                                echo "<td>",htmlspecialchars($v['pass']),"</td>";
                                echo '<td class="shi">是</td>';
                                echo "</tr>";
                            }
                        }
                        if (isset($_POST['show']) and $_POST['show']==="diclist"){
                            $sql5 = "select user,pass from data";
                            $stmt5 = $pdo->prepare($sql5);
                            $stmt5->execute();
                            $result5 = $stmt5->fetchAll();
                            if ($result5){
                                foreach ($result5 as $k=>$v){
                                    $flag = false;
                                    for($i = 0;$i<count($user_arr);$i++){
                                        if($v['user'] === $user_arr[$i] and $v['pass'] === $pass_arr[$i]){
                                            $flag = true;
                                            break;
                                        }
                                    }
                                    if (!$flag){
                                        echo "<tr>";
                                        echo "<td>",htmlspecialchars($v['user']),"</td>";
                                        echo "<td>",htmlspecialchars($v['pass']),"</td>";
                                        echo '<td>否</td>';
                                        echo "</tr>";
                                    }
                                }
                            }
                        }
                    ?>
                </tbody>
            </table>
<!--        </div>-->
<!--        <label for="check" class="check-in"><span><< 展开 >></span></label>-->
<!--        <label for="check" class="check-out"><span><< 收起 >></span></label>-->
<!--    </div>-->
</body>
</html>