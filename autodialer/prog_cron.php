#!/usr/bin/php -q
<?
$output = shell_exec('crontab -l');
file_put_contents('/tmp/crontab2.txt', '* * * * *  /var/www/html/autodialer/cron_copiar.php >> /dev/null 2>&1'.PHP_EOL);
echo exec('crontab /tmp/crontab2.txt');
?>

