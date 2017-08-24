<html>
<SCRIPT language="JavaScript">
function OnSubmitForm()
{
  if(document.pressed == 'Reporte')
  {
   document.myform.action ="genrepo.php";
  }
  else
  if(document.pressed == 'Detener')
  {
    document.myform.action ="cancela.html";
  }
  else
  if(document.pressed == 'Continuar')
  {
    document.myform.action ="lista.php";
  }
  return true;
}
</SCRIPT>

<head>
    <title>Autodialer</title>
</head>
<body>
<form name="myform" enctype="multipart/form-data" onSubmit="return OnSubmitForm();">
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
<p align="center">
<img src="logo_3c.jpg"><br>
<b>AUTODIALER</b>
<br><br>
Elija el archivo a subir: <input name="archivo" type="file" /><br />
<br>
<small><font color="333333">Formato: <i>IdDeudor, Numero_telefonico (opcional)</i></font></small>
</p>
<div align="center"><hr><br>
Elija el tipo de telefono a usar:
<br>
<input type="radio" name="PHONE" value="Casa" checked> Casa<br>
<input type="radio" name="PHONE" value="Celular"> Celular<br>
<input type="radio" name="PHONE" value="Trabajo"> Trabajo<br>
<br><hr><br>
<input type="checkbox" name="IVR" value="1"> Enviar a IVR<br>
<br><hr>
Seleccione los datos adicionales a incluir:
<br><br>
<input type="checkbox" name="DEBT" value="1"> Deuda Total<br>
<small><font color="333333">Se reproducira despues de <i>mensaje1</i></font></small><br><br>
<input type="checkbox" name="DSCT" value="1"> Dscto Total<br>
<small><font color="333333">Se reproducira despues de <i>mensaje2</i></font></small><br><br>
</div><br>
<div align="center">
<INPUT TYPE="submit" name="reporte" onClick="document.pressed=this.value" VALUE="Reporte">
<INPUT TYPE="submit" name="detener" onClick="document.pressed=this.value" VALUE="Detener">
<INPUT TYPE="submit" name="enviar" onClick="document.pressed=this.value" VALUE="Continuar">
</div>
</form>
</body>
</html>

