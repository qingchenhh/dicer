import os
import time
import argparse

dic_list = []
timestr = time.strftime("%m-%d-%H%M%S", time.localtime())
passwd_name = "password_" + timestr + ".txt"
user_name = "user_" + timestr + ".txt"

def args():
    parser = argparse.ArgumentParser()
    parser.add_argument('-n','--name',dest="name",required=True, type=str,help="输入单位或者系统名 (e.g. -n \"qing+chen,qc,qqqccc\")")
    parser.add_argument('-t', '--type', dest="type", required=False, default='base',type=str,
                        help="输入生成的字典类型，可输入的类型有： base（默认）、web、rdp、mysql、mssql、ftp、ssh、tomcat")
    parser.add_argument('-m', '--mode', dest="mode", required=False, default='webadmin', type=str,
                        help="admin、webadmin（默认）、noadd")

    return parser.parse_args()

def get_admin():
    now_year = time.strftime('%Y', time.localtime())
    last_year = str(int(time.strftime('%Y',time.localtime()))-1)
    temp_list = ['','@','#']
    str_list = [now_year,last_year,'123','123456']
    end_list = ['','!']
    base_list = ['admin','test']
    for i in base_list:
        for j in str_list:
            for k in temp_list:
                for l in end_list:
                    dic_list.append(i + k + j + l)
                    dic_list.append(i.capitalize() + k + j + l)

# 和日期拼接
def time_dic(name_list,and_strs=['@','.','_','','#']):
    now_year = time.strftime('%Y',time.localtime())
    last_year = str(int(time.strftime('%Y',time.localtime()))-1)
    llast_year = str(int(time.strftime('%Y', time.localtime())) - 2)
    lllast_year = str(int(time.strftime('%Y', time.localtime())) - 3)

    year_list = [now_year,last_year,llast_year,lllast_year]
    temp_list = ['','!','$','.','@','#','_']
    for and_str in and_strs:
        for name in name_list:
            for i in year_list:
                for j in temp_list:
                    # 判断连接符和最后的结尾符是否一直，一致则把连接符改为空。
                    if and_str == j:
                        str1 = name + i + j
                    else:
                        str1 = name + and_str + i + j
                    # 去重
                    if str1 not in dic_list:
                        dic_list.append(str1)


# 拼接base字典
def and_dic(name_list,and_strs=['@','.','_','','#']):
    temp_list = ['', '!', '$', '.', '@','#']
    for end_str in temp_list:
        for and_str in and_strs:
            for name in name_list:
                with open(r'dic/base_passwd.txt', mode='r', encoding='utf-8') as f:
                    for i in f:
                        i = i.replace('\n', '')
                        # 判断连接符是否存在结尾字符中
                        if (i.find(and_str) != -1) and (and_str != '.'):
                            str1 = name + i + end_str
                        else:
                            str1 = name + and_str + i + end_str
                        # 去重
                        if str1 not in dic_list:
                            dic_list.append(str1)

# 处理传入的name
def get_names(names):
    names1 = names.split(',')
    names = []
    for i in names1:
        names2 = i.split('+')
        # 判断是否是+号拼接。
        if len(names2)>1:
            name1 = ""
            name2 = ""
            for j in names2:
                name1 += j
                name2 += j.capitalize()
            names.append(name1)
            names.append(name1.capitalize())
            names.append(name2)
            names.append(name1.upper())
        else:
            names.append(names2[0])
            names.append(names2[0].capitalize())
            names.append(names2[0].upper())
    return names

# 把字典写入文件
def wirte_dicfile(mode):
    with open(passwd_name,mode='w',encoding='utf-8') as f:
        if mode != "noadd":
            pass_path = "dic/" + mode + "_password.txt"
            if not os.path.exists(pass_path):
                print("[-] 没有找到" + pass_path + "文件！")
                return False
            with open(pass_path,mode='r',encoding='utf-8') as f1:
                for j in f1:
                    # 去重
                    if j.replace('\n','') not in dic_list:
                        f.write(j.replace('\n','')+'\n')
        for i in dic_list:
            f.write(i + '\n')


    print("\n[+] 生成的密码文件为：",passwd_name)

def gen_user(names,ut):
    filename = ut + "_user.txt"
    if not os.path.exists("dic/" + filename):
        print("[-] 没有找到"+filename+"文件！")
        return False
    user_list = []
    names1 = names.split(',')
    for name in names1:
        temp = name.replace('+','')
        user_list.append(temp)
        # user_list.append(temp.capitalize())
        # user_list.append(temp.upper())
        # user_list.append(temp + "admin")
        user_list.append(temp + "_admin")
        # user_list.append(temp.capitalize() + "admin")
        # user_list.append(temp + "Admin")
        # user_list.append(temp.capitalize() + "Admin")
        # user_list.append(temp + "_admin")
        # user_list.append(temp.capitalize() + "_admin")
    with open(user_name,mode='w',encoding='utf-8') as f:
        for i in user_list:
            f.write(i + '\n')
        with open('dic/'+filename,mode='r',encoding='utf-8') as f1:
            for j in f1:
                # 去重
                if j.replace('\n','') not in user_list:
                    f.write(j)
    print("\n[+] 生成的用户名文件为：",user_name)

def run(args):
    if not os.path.isdir('dic'):
        print("[-] 没有找到dic目录！")
        exit(-1)
    elif not os.path.exists('dic/base_passwd.txt'):
        print("[-] 没有找到base_passwd.txt文件！")
        exit(-1)
    names = get_names(args.name)
    gen_user(args.name,args.type)
    get_admin()
    time_dic(names)
    and_dic(names)
    wirte_dicfile(args.mode)

if __name__ == '__main__':
    args = args()
    run(args)
