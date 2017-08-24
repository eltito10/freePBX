<?php
    $cont = 1;
    $handle = fopen("/var/www/html/autodialer/temporal.csv",'r');
    if ($handle) //si lo abrio con exito
    {
	echo "<p align='center'>";
	echo "<b>Reporte de envios Autodialer</b>";
	echo "<br><br>";
	echo "<table border='1'>";
	echo "<tr><td>#</td><td>IdDeudor</td><td align='center'>Negocio</td><td>Telefono</td>";
	echo "<td align='center'>Status</td><td align='center'>Fecha Hora</td></tr>";

	//$reporte = fopen("/var/www/autodialer/reporte_".date('d-m-Y').".csv",'w');
	$reporte = fopen("/var/www/html/autodialer/reporte.csv",'w');
        while (($data = fgetcsv($handle, 4096, ",")) !== FALSE)
        {
	$enviado = fopen("/var/spool/asterisk/outgoing_done/arch".strval($cont).".call",'r');
	if ($enviado) {
    		while (($buffer = fgets($enviado, 4096)) !== false) {

                        if (preg_match("/StartRetry/", $buffer)){
                        $stamp = substr($buffer, -12, 10);
			$fecha = date("Y-m-d H:i:s", $stamp);
                        }
        		if (preg_match("/Status/", $buffer)){
			$status = substr($buffer, 8, 16);
				if (preg_match("/Completed/", $status)) $bgcol = "#00ff00";
				else $bgcol = "#ff0000";
				echo "<tr><td>";
              			echo $data[0];
              			echo "</td><td>";
              			echo $data[1];
              			echo "</td><td>";
              			echo $data[2];
              			echo "</td><td>";
              			echo $data[3];
              			echo "</td><td bgcolor=$bgcol>";
				echo $status;
				echo "</td><td>";
                                echo $fecha;
				echo "</td></tr>";
				fwrite($reporte,$data[0].','.$data[1].','.$data[2].','.$data[3].','.$status.','.$fecha);
			}
		}
	}
	else {
	echo "<tr><td>";
        echo $data[0];
        echo "</td><td>";
        echo $data[1];
        echo "</td><td>";
        echo $data[2];
        echo "</td><td>";
        echo $data[3];
        echo "</td><td bgcolor=#ffff00>";
        echo "Pending";
	echo "</td><td>";
	echo "&nbsp;";
        echo "</td></tr>";
	fwrite($reporte,$data[0].','.$data[1].','.$data[2].','.$data[3].',Pending'.chr(10));
	}
	fclose($enviado);
        $cont++;
	}
	echo "</table>";
	fclose($reporte);
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
  if(document.pressed == 'Descargar')
  {
    document.myform.action ="reporte.csv";
  }
  else
  if(document.pressed == 'Actualizar')
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
<INPUT TYPE="SUBMIT" name="Operation" onClick="document.pressed=this.value" VALUE="Volver">
<INPUT TYPE="SUBMIT" name="Operation" onClick="document.pressed=this.value" VALUE="Descargar">
<INPUT TYPE="SUBMIT" name="Operation" onClick="document.pressed=this.value" VALUE="Actualizar">
</p>
</FORM>
</body>
</html>

