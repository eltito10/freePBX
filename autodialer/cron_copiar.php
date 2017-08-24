#!/usr/bin/php -q
<?
$db = 'asterisk';
$dbuser = 'asteriskuser';
$dbpass = 'amp109';
$dbhost = 'localhost';
$link = mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db("$db", $link);
$contenido = mysql_query("select value from globals where variable = 'AD_CHANNELS'", $link);
$row = mysql_fetch_row($contenido);
//var_dump($row);
$channels = $row[0];
//
system("/var/www/html/autodialer/cron_copiar2.sh $channels");
//
mysql_close($link);
?>

