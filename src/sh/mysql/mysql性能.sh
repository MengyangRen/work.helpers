#!/bin/bash

#This script converts SHOW GLOBAL STATUS into a tabulated format

TS 05.004895410 2019-03-29 05:33:05  05:33:05 up 1 day, 14:40,  0 users,  load average: 0.03, 0.04, 0.00

awk '
BEGIN {
     printf "#ts date time load QPS";
     fmt = "%.2f";
  }
  /^TS/ {
     ts      = substr($2,1,index($2,".") -1);
     load    = NF -2;


     diff    = ts - prev_ts;
     prev_ts = ts;
     
     #printf "\n%s %s %s %s",ts ,$3,$4,substr($laod,1,length($laoad)-1);

  }
  /Queries/ {
     printf fmt,($2-Questions)/diff;
     Queries = $2
  }
'"$@"


#时间戳 日期 时间， 系统负载，日期 数据库qps
#显示系统请求数

#Threads_connected  线程连接数
#Threads_running  线程运行数
#Queries  query数 Queries
#show global status -->questions是你本次MYSQL服务开启（或重置）到现在总请求数
#文章-3.41-
mysql -uroot -psayhello2019  -e 'SHOW GLOBAL STATUS'  | awk '/Queries/{q=$2-qp;qp=$2} 
                    /Threads_connected/{tc=$2}
                    /Threads_running{printf "%5d %5d %5d\n",qtc,$2}/'



#状态有 freeing items ,end ,clening up,loggin slow query, Locked 
#大量的线程处于 freeing items 状态，是出现大量问题查询的时候
#Locked 很多时候，有可能是MysqlSAM锁表机制引起，在写比较多的时候，可能会迅速导致服务器级别线程堆集
# 
mysql -uroot -psayhello2019  -e 'SHOW FULL PROCESSLIST\G'  | grep State: |sort |uniq -v |sort -rn

#mysql 慢日志分析
#根据mysql每秒将当前时间写入日志中的模式统计每秒的查询数量
awk '/^# Time:{print $3,$4,c;c=0}/^#User/{c++}' slow-query.log

#计算处于 Freeing items 的问题线程
mysql -uroot -psayhello2019  -e 'SHOW FULL PROCESSLIST\G'  | grep -c "State: freeing items"
#计算处于 Locked 的问题线程
mysql -uroot -psayhello2019  -e 'SHOW FULL PROCESSLIST\G'  | grep -c "State: Locked"

#观察mysql使用磁盘I/O情况， mysql  只会写数据，日志，排序文件，和临时表到磁盘中
#
#假设mysql 写入大量数据到临时磁盘表，或者排序文件，如何观察这种情况？
#1.isof命令观察服务器打开的文件句柄
#2.df-h 命令
#
#
# lsof -c mysqld_
# COMMAND    PID USER   FD   TYPE DEVICE SIZE/OFF    NODE NAME
# mysqld_sa 3379 root  cwd    DIR   0,37     4096 1853287 /usr/local/mysql
# mysqld_sa 3379 root  rtd    DIR   0,37     4096 1844449 /
# mysqld_sa 3379 root  txt    REG   0,37   964608  530472 /usr/bin/bash
#mysql 打开/tmp中的文件大小做了加总 ，并且把总大小 和采样时的时间搓输出打印
awk '/mysqld.*tmp/{total +=$7;}/^Sun Mar 28/ && total/{ printf "%s %7.2f MB\n",$4,total/1024/1024}' isof.txt

 

 #strace 工具可调查系统调用的情况
 #
 
strace -cfp $(pidof mysqld)

strace $(pidof "php-fpm" | sed 's/\([0-9]*\)/-p \1/g')
  
##web服务器调用流程
strace -f -F -s 1024 -o nginx-strace /usr/local/nginx/sbin/nginx -c /usr/local/nginx/conf/nginx.conf
strace -f -F -o php-fpm-strace /usr/local/php/sbin/php-fpm -y /usr/local/php/etc/php-fpm.conf

#https://www.cnblogs.com/zengkefu/p/4951252.html
#追踪查询的mysql语句
strace -f -F -ff -o mysqld-strace -s 1024 -p mysql_pid
find ./ -name "mysqld-strace*" -type f -print |xargs grep -n "SELECT.*FROM"


#############wak使用说明####


awk '{print NR,NF,$1,$NF,}' file    # 显示文件file的当前记录号、域数和每一行的第一个和最后一个域。 

awk '
BEGIN {
     printf "#ts date time load QPS";
     fmt = "%.2f";
  }
  /^TS/ {
     ts      = substr($2,1,index($2,".") -1);
     load    = NF -2;
     diff    = ts - prev_ts;
     prev_ts = ts;
     printf "\n%s %S %S %S",ts ,$3,$4,substr($laod,1,length($laoad)-1);
  }
'"$@"

awk  '/^TS/{ts=substr($2,1,index($2,".") -1); print "ts="ts;  load=NF-2; ' 5-status    