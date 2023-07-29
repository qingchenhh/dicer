<?php
session_start();
ini_set('display_errors','off');

include "ua.php";

if (!$_SESSION['uid']){
    header("Location:index.php");
}

include "config.php";

if (isset($_POST['user']) and $_POST['user'] !=="" ){
    $pass = isset($_POST['pass']) ? trim($_POST['pass']) : "";
    $user = trim($_POST['user']);
    if (strlen($_POST['user'])>20){
        echo "大哥！！！你的用户名是不是长了点！";
    }elseif (strlen($pass)>20){
        echo "大哥！！！这种长度的密码就别写了。猜不到的！";
    }else{
        if (((time()-$_SESSION['time']<300) and ($_SESSION['send']<10)) or ($_SESSION['send']===0)){
            if (strstr($_POST['user'],"'")){
                echo "大哥！！！你家的用户名有单引号吗？";
            }elseif (strstr($_POST['user'],'"')){
                echo "大哥！！！你家的用户名有双引号吗？";
            }elseif (strstr($_POST['pass'],'"') or strstr($_POST['pass'],"'")){
                echo "我觉得日常生活中的密码应该很少很少有引号，因此该条数据将不会插入！";
            }else{
                $_SESSION['send']++;
                $sql = "select user,pass from data where user=:user and pass=:pass";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['user' => $user,'pass' => $pass]);
                $result = $stmt->fetchAll();
                if ($result){
                    echo "该条数据已存在！";
                }else{
                    try{
                        $sql1 = "INSERT INTO data (user,pass) VALUES (?, ?)";
                        $stmt1 = $pdo->prepare($sql1);
                        $stmt1->execute([$user, $pass]);
                        echo "插入用户名：",htmlspecialchars($user),"密码：",htmlspecialchars($pass),"感谢大佬的提交！";
                    }catch (PDOException $exception) {
                        echo '啊！出错啦！';
                    }
                }
            }
        }elseif (time()-$_SESSION['time']>300){
            $_SESSION['time'] = time();
            $_SESSION['send'] = 1;
            if (strstr($_POST['user'],"'")){
                echo "大哥！！！你家的用户名有单引号吗？";
            }elseif (strstr($_POST['user'],'"')){
                echo "大哥！！！你家的用户名有双引号吗？";
            }elseif (strstr($_POST['pass'],'"') or strstr($_POST['pass'],"'")){
                echo "我觉得日常生活中的密码应该很少很少有引号，因此该条数据将不会插入！";
            }else{
                $_SESSION['send']++;
                $sql = "select user,pass from data where user=:user and pass=:pass";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['user' => $user,'pass' => $pass]);
                $result = $stmt->fetchAll();
                if ($result){
                    echo "该条数据已存在！";
                }else{
                    try{
                        $sql1 = "INSERT INTO data (user,pass) VALUES (?, ?)";
                        $stmt1 = $pdo->prepare($sql1);
                        $stmt1->execute([$user, $pass]);
                        echo "插入用户名：",htmlspecialchars($_POST['user']),"密码：",htmlspecialchars($pass),"感谢大佬的提交！";
                    }catch (PDOException $exception) {
                        echo '啊！出错啦！';
                    }

                }
            }
        }else{
            echo "大哥！！！你提交的数据太快了！";
        }
    }
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
        body{
            background-color: #e2e3e5;
        }
        .box{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        p{
            color: #9A0000;
            font-weight: bold;
        }
        a{
            text-decoration: none;
            background-color: #cce5ff;
        }
    </style>
    <title>input</title>
</head>
<body>
<div class="box">
    <p>假设这是一个单位的系统，该单位为帝亚迪科技有限公司，系统名字叫做资产管理系统。</p>
    <p>现在假设你是管理员，你会设置什么用户名？和什么样的密码？（大佬请多提交几个！）</p>
    <form action="" method="post">
        用户:<input type="text" name="user"><br />
        密码:<input type="password" name="pass"><br />
        <input type="submit" value="录入">
    </form>
    <p><a class="a2" href="login.php">测试字典命中率</a></p>
</div>
</body>
</html>