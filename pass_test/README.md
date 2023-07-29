# 工具介绍

就是感觉一个人收集字典规律太少，多交几个朋友一起收集搞得衍生项目，大家输入自己遇到的密码规则进去，然后还可以用自己的字典跑一下看看自己的字典命中率怎么样。

# 工具的使用

工具采用php+mysql的架构。

第一步自己百度装一个lnmp啥的环境。

第二步构建数据库。

```
# 先连上mysql创建一个数据库。
create database pass;
# 再创建两个表。
create table data(
    id INT NOT NULL AUTO_INCREMENT,
    user VARCHAR(256) NOT NULL,
    pass VARCHAR(256) NOT NULL,
    PRIMARY KEY ( id )
);

create table mz(
     uid VARCHAR(256) NOT NULL,
     user VARCHAR(256) NOT NULL,
     pass VARCHAR(256) NOT NULL,
     date_time VARCHAR(256) NOT NULL
);
# 创建一个专门的mysql用户，尽量不要使用root。
create user 'qingchen'@'localhost' identified by "T##$sT0201";
# 分配权限，权限就控的死一点。
grant select,insert,delete,update on pass.* to 'qingchen'@'localhost';
```

第三步构建修改config.php配置文件中连接数据的信息。

```
$hostname = 'localhost'; // MySQL主机名
$database = 'pass'; // 数据库名称
$username = 'qingchen'; // 用户名
$password = 'T##$sT0201'; // 密码
```

第四步就是浏览器访问你搭建起来的站点就可以了。