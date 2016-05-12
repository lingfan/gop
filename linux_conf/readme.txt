建立日志目录：
mkdir /data/log

启动rsync日志服务器:
/usr/bin/rsync --daemon --config=/etc/rsyncd/rsyncd.conf

crontab定时任务：
*/1 * * * * /usr/bin/php /data/www/pm/run/cron_parse_log.php > /tmp/log &