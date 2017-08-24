<?php
$db = 'sgc';
$dbuser = 'asterisk';
$dbpass = '4st3r1sk';
$dbhost = '192.168.1.6';
$link = mysql_connect($dbhost,$dbuser,$dbpass);
mysql_select_db("$db", $link);
$cont = 1;
if(isset($_FILES['archivo']['tmp_name']))
{
    echo "<p align='center'>Archivo cargado satisfactoriamente!<br><br>";
    echo "<table border='1'>";
    echo "<tr><td>#</td><td>IdDeudor</td><td>Negocio</td><td>Telefono</td>";
    echo "<td>IVR</td><td>Deuda</td><td>Dcto</td></tr>";
    
    //abro el archivo subido en modo solo lectura
    $handle = fopen($_FILES['archivo']['tmp_name'],'r');
    $phone = $_POST['PHONE'];
    if ($handle) //si lo abrio con exito
    {
	$temporal = fopen("temporal.csv",'w');
        while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) //recorro el archivo
        {
	$result1 = mysql_query("select NvoTelefono from gestion where IdDeudor = '$data[0]' and IdNegocio = '$data[1]' and NvoTelubicacion = '$phone' limit 1", $link);
	  if($_POST["IVR"] != "1")
	  {
	   if($data[2] == "")	
	   {
	      while ($telefono = mysql_fetch_array($result1))
	      {
	      echo "<tr><td>";
	      echo $cont;
	      echo "</td><td>";
              echo $data[0];
              echo "</td><td>";
              echo $data[1];
              echo "</td><td>";
              echo $telefono[0];
              echo "</td><td>";
              echo "0";
              echo "</td><td>";
	      fwrite($temporal,$cont.','.$data[0].','.$data[1].','.$telefono[0].',0');
		  if($_POST["DEBT"] == '1')
		  {
        	  $result2 = mysql_query("select TotMonto from deudor where IdDeudor = '$data[0]' and Negocio = '$data[1]'", $link);
        	  $deuda = mysql_fetch_array($result2);
        	  echo $deuda[0];
		  echo "</td><td>";
		  fwrite($temporal,','.$deuda[0]);
			if($_POST["DSCT"] == '1')
                	{
	                $result3 = mysql_query("select TotDsctoCancela from deudor where IdDeudor = '$data[0]' and Negocio = '$data[1]'", $link);
	                $dscto = mysql_fetch_array($result3);
        	        echo $dscto[0];
                	echo "</td></tr>";
			fwrite($temporal,','.$dscto[0]);
			}
			else
			{
			echo "&nbsp;</td></tr>";
			}
		  }
		  else
		  {
		  echo "&nbsp;</td><td>";
		  echo "&nbsp;</td></tr>";
		  }
	       $cont++;
	       fwrite($temporal,chr(10));
	       }
	   }
	   else
	   {
           echo "<tr><td>";
           echo $cont;
           echo "</td><td>";
           echo $data[0];
           echo "</td><td>";
           echo $data[1];
           echo "</td><td>";
           echo $data[2];
           echo "</td><td>";
           echo "0";
           echo "</td><td>";
           fwrite($temporal,$cont.','.$data[0].','.$data[1].','.$data[2].',0');
                  if($_POST["DEBT"] == '1')
                  {
                  $result2 = mysql_query("select TotMonto from deudor where IdDeudor = '$data[0]' and Negocio = '$data[1]'", $link);
                  $deuda = mysql_fetch_array($result2);
                  echo $deuda[0];
                  echo "</td><td>";
                  fwrite($temporal,','.$deuda[0]);
                        if($_POST["DSCT"] == '1')
                        {
                        $result3 = mysql_query("select TotDsctoCancela from deudor where IdDeudor = '$data[0]' and Negocio = '$data[1]'", $link);
                        $dscto = mysql_fetch_array($result3);
                        echo $dscto[0];
                        echo "</td></tr>";
                        fwrite($temporal,','.$dscto[0]);
                        }
                        else
                        {
                        echo "&nbsp;</td></tr>";
		  	}
		  }
		  else
                  {
                  echo "&nbsp;</td><td>";
                  echo "&nbsp;</td></tr>";
                  }
	   $cont++;
	   fwrite($temporal,chr(10));
	   }
	  }
	  else
	  {
           echo "<tr><td>";
           echo $cont;
           echo "</td><td>";
           echo $data[0];
           echo "</td><td>";
           echo $data[1];
           echo "</td><td>";
           echo $data[2];
           echo "</td><td>";
           echo "1";
           echo "</td><td>";
	   echo "&nbsp;";
           echo "</td><td>";
           echo "&nbsp;";
	   echo "</tr>";
           fwrite($temporal,$cont.','.$data[0].','.$data[1].','.$data[2].',1');
           $cont++;
           fwrite($temporal,chr(10));
	  }
        }
	fclose($temporal);
    }
    echo "</table>";
    echo "</p>";

$channels = $_POST['CHANNELS'];
$agents = $_POST['AGENTS'];
$trunk = $_POST['TRUNK'];
$link2 = mysql_connect('localhost','asteriskuser','amp109');
mysql_select_db("asterisk", $link2);
$result1 = mysql_query("update globals set value = '$channels' where variable = 'AD_CHANNELS'", $link2);
$result2 = mysql_query("update globals set value = '$agents' where variable = 'AD_AGENTS'", $link2);
$result3 = mysql_query("update globals set value = '$trunk' where variable = 'AD_TRUNK'", $link2);
mysql_close($link2);
}
?>

<html>
<head>
<title>Autodialer</title>
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
    document.myform.action ="temporal.csv";
  }
  else
  if(document.pressed == 'Enviar')
  {
    document.myform.action ="enviar.php";
  }
  return true;
}
</SCRIPT>
<script src="datetimepicker.js"></script>
</head>
<body>
<form name="myform" enctype="multipart/form-data" method="POST" onSubmit="return OnSubmitForm();">
<p align="center">
<i>Seleccione la fecha y hora para envio:</i><br><br>
<input id="calen" name="calen" type="text" size="25"><a href="javascript:NewCal('calen','ddMMyyyy',true,24)"><img src="cal.gif" width="16" height="16" border="0" alt="Elija una fecha"></a>
<br><br>
<INPUT TYPE="SUBMIT" name="Operation" onClick="document.pressed=this.value" VALUE="Volver">
<INPUT TYPE="SUBMIT" name="Operation" onClick="document.pressed=this.value" VALUE="Descargar">
<INPUT TYPE="SUBMIT" name="Operation" onClick="document.pressed=this.value" VALUE="Enviar">
</p>
</FORM>
</body>
</html>

