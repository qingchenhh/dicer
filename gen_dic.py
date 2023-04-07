import os
import time
import argparse

dic_list = []

def args():
    parser = argparse.ArgumentParser()
    parser.add_argument('-n','--name',dest="name",required=True, type=str,help="Please input name (e.g. -n \"qingchen,qc,qqqccc,qingccc\")")

    return parser.parse_args()

def time_dic(names,and_str='@'):
    now_year = time.strftime('%Y',time.localtime())
    last_year = str(int(time.strftime('%Y',time.localtime()))-1)
    llast_year = str(int(time.strftime('%Y', time.localtime())) - 2)

    year_list = [now_year,last_year,llast_year]
    temp_list = ['','!','$']
    name_list = names.split(',')
    for name in name_list:
        for i in year_list:
            for j in temp_list:
                dic_list.append(name + i + j)
                dic_list.append(name + and_str + i + j)
                dic_list.append(name.capitalize() + i + j)
                dic_list.append(name.capitalize() + and_str + i + j)
                dic_list.append(name.upper() + i + j)
                dic_list.append(name.upper() + and_str + i + j)

def and_dic(names,and_str='@'):
    name_list = names.split(',')
    for name in name_list:
        with open(r'dic/base_passwd.txt', mode='r', encoding='utf-8') as f:
            for i in f:
                i = i.replace('\n','')
                dic_list.append(name + i)
                dic_list.append(name + and_str + i)
                dic_list.append(name.capitalize() + i)
                dic_list.append(name.capitalize() + and_str + i)
                dic_list.append(name.upper() + i)
                dic_list.append(name.upper() + and_str + i)

def wirte_dicfile():
    with open(r'dic/generate_dic.txt',mode='w',encoding='utf-8') as f:
        for i in dic_list:
            f.write(i + '\n')
        with open('dic/password.txt',mode='r',encoding='utf-8') as f1:
            for j in f1:
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
    time_dic(args.name)
    and_dic(args.name)
    wirte_dicfile()

    print("\n[+] 字典已经生成在当前目录下的dic目录下的generate_dic.txt文件中。")

if __name__ == '__main__':
    args = args()
    run()
