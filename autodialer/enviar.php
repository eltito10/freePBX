<?php
/*
Genera archivos call con datos de archivo csv 
*/
$link = mysql_connect(localhost,asteriskuser,amp109);
mysql_select_db("asterisk", $link);
$result = mysql_query("select value from globals where variable = 'AD_TRUNK'", $link);
$row = mysql_fetch_row($result);
$trunk = $row[0];
$result2 = mysql_query("select value from globals where variable = 'AD_AGENTS'", $link);
$row = mysql_fetch_row($result2);
$agents = $row[0];

    //borra archivos de envio anterior
    $dir = '/var/spool/asterisk/outgoing_done/';
    foreach(glob($dir.'*.*') as $v){
    unlink($v);
    }
// borra cron de envio anterior
echo exec('crontab -r');

// programa cron de nuevo envio
$calendar = $_POST['calen'];
$hour=substr($calendar, -8, 2);
$min=substr($calendar, -5, 2);
$fecha=explode("-", $calendar);
$dia=$fecha[0];
$mes=$fecha[1];
$output = shell_exec('crontab -l');
file_put_contents('/tmp/crontab.txt', $output.$min.' '.$hour.' '.$dia.' '.$mes.' *  /usr/bin/php /var/www/html/autodialer/prog_cron.php'.PHP_EOL);
echo exec('crontab /tmp/crontab.txt');
//
    $cont = 1;
    $handle = fopen("temporal.csv",'r');
    if ($handle)
    {
        while (($data = fgetcsv($handle, 5000, ",")) !== FALSE)
        {
	    if($data[4] == "1")
	    {
            $generado = fopen("origen/arch".strval($cont).".call",'w');
            fwrite($generado, 'Channel: '.$trunk.'/'.$data[3].chr(10).
	    'MaxRetries: 1'.chr(10).
            'RetryTime: 60'.chr(10).
            'Set: DEST='.$data[3].'&'.$data[2].'&'.$data[1].chr(10).
            'Context: autodial1'.chr(10).
            'Extension: s'.chr(10).
            'Priority: 1'.chr(10).
            'Archive: Yes').chr(10);
            fclose($generado);
	    $cont++;
	    }
	    else
	    {
		if($data[5] != "")
		{
	    	$generado = fopen("origen/arch".strval($cont).".call",'w');
            	fwrite($generado, 'Channel: '.$trunk.'/'.$data[3].chr(10).
            	'MaxRetries: 1'.chr(10).
            	'RetryTime: 60'.chr(10).
            	'Set: DEST='.$data[3].'&'.$data[5].'&'.$data[6].chr(10).
            	'Context: autodial2'.chr(10).
            	'Extension: s'.chr(10).
            	'Priority: 1'.chr(10).
            	'Archive: Yes').chr(10);
            	fclose($generado);
            	$cont++;
	    	}
		else
		{
                $generado = fopen("origen/arch".strval($cont).".call",'w');
                fwrite($generado, 'Channel: '.$trunk.'/'.$data[3].chr(10).
                'MaxRetries: 1'.chr(10).
                'RetryTime: 60'.chr(10).
                'Set: DEST='.$data[3].chr(10).
                'Context: autodial3'.chr(10).
                'Extension: s'.chr(10).
                'Priority: 1'.chr(10).
                'Archive: Yes').chr(10);
                fclose($generado);
                $cont++;
		}
	    }
        }
    echo "<div align='center'>";
    echo $cont - 1;
    echo " mensajes enviados.";
    echo "</div>";
    }
?>

<html>
<SCRIPT language="JavaScript">
function OnSubmitForm()
{
  if(document.pressed == 'Volver')
  {
   document.myform.action ="index.html";
  }
  else
  if(document.pressed == 'Reporte')
  {
    document.myform.action ="genrepo.php";
  }
  return true;
}
</SCRIPT>
<head>
    <title>Autodialer</title>
</head>
<body>
<FORM name="myform" onSubmit="return OnSubmitForm();">
<p align="center">
<INPUT TYPE="SUBMIT" name="Volver" onClick="document.pressed=this.value" VALUE="Volver">
<INPUT TYPE="SUBMIT" name="Reporte" onClick="document.pressed=this.value" VALUE="Reporte">
</p>
</FORM>

</body>
</html>
