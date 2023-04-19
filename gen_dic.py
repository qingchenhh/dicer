import os
import time
import argparse

dic_list = []

def args():
    parser = argparse.ArgumentParser()
    parser.add_argument('-n','--name',dest="name",required=True, type=str,help="Please input name (e.g. -n \"qingchen,qc,qqqccc,qingccc\")")

    return parser.parse_args()

# 和日期拼接
def time_dic(name_list,and_strs=['@','.','_','']):
    now_year = time.strftime('%Y',time.localtime())
    last_year = str(int(time.strftime('%Y',time.localtime()))-1)
    llast_year = str(int(time.strftime('%Y', time.localtime())) - 2)
    lllast_year = str(int(time.strftime('%Y', time.localtime())) - 3)

    year_list = [now_year,last_year,llast_year,lllast_year]
    temp_list = ['','!','$','.','@']
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


# 拼接bash字典
def and_dic(name_list,and_strs=['@','.','_','']):
    for and_str in and_strs:
        for name in name_list:
            with open(r'dic/base_passwd.txt', mode='r', encoding='utf-8') as f:
                for i in f:
                    i = i.replace('\n','')
                    # 判断连接符是否存在结尾字符中
                    if (i.find(and_str) != -1) and (and_str != '.'):
                        str1 = name + i
                    else:
                        str1 = name + and_str + i
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
def wirte_dicfile():
    with open(r'dic/generate_dic.txt',mode='w',encoding='utf-8') as f:
        for i in dic_list:
            f.write(i + '\n')
        with open('dic/password.txt',mode='r',encoding='utf-8') as f1:
            for j in f1:
                # 去重
                if j.replace('\n','') not in dic_list:
                    f.write(j)

def run():
    if not os.path.isdir('dic'):
        print("没有找到dic目录！")
        exit(-1)
    elif not os.path.exists('dic/base_passwd.txt'):
        print("没有找到base_passwd.txt文件！")
        exit(-1)
    elif not os.path.exists('dic/password.txt'):
        print("没有找到password.txt文件！")
        exit(-1)
    names = get_names(args.name)
    time_dic(names)
    and_dic(names)
    wirte_dicfile()

    print("\n[+] 字典已经生成在当前目录下的dic目录下的generate_dic.txt文件中。")

if __name__ == '__main__':
    args = args()
    run()
