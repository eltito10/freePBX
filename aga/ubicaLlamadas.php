<?php
  session_start();
  $usuario =  'prueba';  // $_SESSION["usuario"];
  if ($usuario <> ""){
    $nivelUsuario =  $_SESSION["nivelUsuario"];
    $negocio = $_SESSION["negocio"];
    $negocioUsuario=$negocio;
?>
<html>
  <head>
    <link rel =stylesheet href="librerias/estilos.css" type ="text/css">
    <link rel =stylesheet href="librerias/calendar-win2k-cold-1.css" type ="text/css">

  <script language="JavaScript" type="text/javascript" src="librerias/calendar.js"></script>
  <script language="JavaScript" type="text/javascript" src="librerias/calendar-setup_modif.js" ></script>
  <script language="JavaScript" type="text/javascript" src="librerias/calendar-es.js"></script>

  <script language="JavaScript" type="text/javascript" src="librerias/Validaciones.js">  </script>
  <script>
  function Ir_a_Pag(pag){
   document.forms[0].action=pag;
   document.forms[0].submit();
  }
  function Clear(){
    document.forms[0].reset();  // para los Selects
    var max_i=document.forms[0].length;
    // alert("Numcontrols: "+max_i);
    for (var i=1; i<=max_i; i++)  {
      var control=document.forms[0].elements[i-1];
      if (control.type=='text')
        control.value='';
      // if (control.type='select')
    }
  }
    </script>

  </head>
  <body >

<?php
  require_once 'config.ini.php';
  require_once './librerias/conectar.php';
  require_once './librerias/varios.php';
  require './librerias/funciones.php';

  $fecha=Date("Y-m-d");
  $hora = time();
  $horaImpresion = date("H_i_s",$hora);
  $horasistema =  date("H:i:s",$hora);

  $link=conectarse($base);
  $condicion = ' having 3 = 3';
  $orden = '';
  $where = '';
	// el ultimo termino incluye a todos los tipos de Jefatura q' puedan haber..
  if($nivelUsuario<>'Coordinador Call' and $nivelUsuario!='Coordinador Pull' and $nivelUsuario!='Asignador' and $nivelUsuario!='Administrador' and $nivelUsuario!='Gerencia' and stristr($nivelUsuario,"Jefatura")==false) {
   	$verVariosNegocios=false;
  } else {
    $verVariosNegocios=true;  
  }

  if(isset($_POST['btnEnviar']) or $_GET["pagina"]){
    if($_POST['cmbOrden']!= '-'){                           //ESTA PARTE DEL CODIGO SE UTILIZA
      $orden = " ORDER BY `". $_POST['cmbOrden'] ."` ASC";  //SI ELIGE UN CAMPO PARA ORDENAR
    }
   foreach ($_POST as $key => $valor) {
     if ($key != 'btnEnviar'  and  $key != 'cmbOrden' and $valor != '' and  $key != 'cmbImprimir'  ){  //ARMAR EL CRITERIO DE CONDICION ELIMINADO EL
       //$condicion = $condicion . " AND " .$key. " like  '".$valor."'";   //ENVIAR Y EL ORDENAMIENTO
       if(stristr($key,"fch") or stristr($key,"fecha")) {
         $valor=str_replace("y","and gestion.$key",$valor);
         //echo "FCH -".$valor;
       } else if ($key == 'anexo')
         $key = 'src';
        else if ($key == 'telefono')    //fchCreacion
         $key = 'dst';
        else if ($key == 'contestado')    //fchCreacion
         $key = 'disposition'; 

       if ($key == 'fchCreacion'){
         $key = 'calldate';
         $auxValor = substr($valor, -11,10);
         $valor = "LIKE '$auxValor%' ";
       }
       $where = $where ." AND $key $valor";
    
     }
   };
  } else {      //ESTA PARTE ES SI DESEA ALGUNA CONDICION PREDEFINIDA. DE NO SER ASI COLOQUE
 								// ESTAS DOS LINEAS COMO COMENTARIOS
  			  // LA CONDICION PREDEFINIDA AQUI SERÍA EL NEGOCIO X DEFECTO AL ENTRAR LA 1ERA VEZ AL REPORTE...
		//  $condicion = $condicion . " AND Negocio"."='".$negocio."'";
		$where = $where ;
   } ;


  $qry = "SELECT  SQL_CALC_FOUND_ROWS  left( calldate, 10 ) AS fchCreacion, clid, calldate, src AS anexo, dst AS telefono, uniqueid, negocio, deudor, disposition AS contestado FROM cdr WHERE 1 ";

  $qry = $qry.$where.$condicion; //SE AÑADEN TODOS LOS DEMAS CRITERIOS CON CLAUSULA WHERE(x motivos de velocidad) Y LUEGO CON HAVING
  // $qry = $qry.$condicion  ; //SE AÑADEN LOS CRITERIOS TODOS CON CLAUSULA HAVING
  $qry = $qry.$orden;   //AÑADE ORDENAMIENTO. PUEDE ELIMINAR EL COMBO Y AÑADIR PROPIO ORDEN P.EJ. "ORDER BY `deudor`.`RznSocial` ASC";

  // PAGINACION
  $nroReg_por_pag=100;
	$pag = $_GET["pagina"];
	if (!$pag) { $inicio = 0; $pag=1;
  } else {
    $inicio =($pag - 1) * $nroReg_por_pag;
  }
   // Conteo de total de regs.
  //$result = mysql_query($qry);
   if(mysql_error()){
     echo mysql_error();
     $pagReporte = $_SERVER['PHP_SELF'];
     echo "<script>alert('Algun criterio de la busqueda es incorrecto, favor revisar la consulta');location.href='$pagReporte';</script>";
     exit();
   }
   //echo $qry."</br>";
   if (!isset($_POST['cmbImprimir']) or $_POST['cmbImprimir'] == "No") {
     $qry = $qry. " LIMIT $inicio,$nroReg_por_pag";
   }
   $result = mysql_query($qry);
   
   $qryTotal = "SELECT FOUND_ROWS()";
   $resultTotal = mysql_query($qryTotal); 
   $aux= mysql_fetch_row($resultTotal); // mysql_num_rows($resultTotal);
   $nroRegs = $aux[0]; 
   //calculo el total de páginas
   $total_paginas = ceil($nroRegs / $nroReg_por_pag);
   

?>
  <table border="0" width="899" height="30" cellpadding= "0">
    <tr  class='menu'>
      <td width="690" height="20" ><b><font face="Arial" size="2" color="#FFFFFF">REPORTE AUDIOS - USUARIO : <?php echo $usuario  ?></font></b></td>
      <td width="100" height="20" ><b><font face="Arial" size="2" color="#FFFFFF"></font></b>
      <td width="90" height="20" ></b></td>
    </tr>
  </table>
  <form method="POST" action='<?php echo $_SERVER['PHP_SELF'] ?>'><p>&nbsp;Ordenar por<select  size='1' name="cmbOrden" style="position: relative;  width: 80;">
      <option value=  "-">-</option>
      <?php
      for ($i = 0; $i < mysql_num_fields($result); $i++) {
          print "<option value= '".mysql_field_name($result, $i)."'>".mysql_field_name($result, $i)."</option>";
      }
      ?>
    </select>&nbsp; Imprimir<select  size='1' name="cmbImprimir" style="position: relative;  width: 80">
      <option value=  "No">No</option>
      <option value=  "impCSV">Imprimir en CSV</option>
      <option value=  "impExcel">Imprimir en Excel</option>
      <option value=  "descargar">Descargar Audios</option>


    </select>
    <input type="submit" value="Enviar" name="btnEnviar">
    <input type="button" value="Reset" name="btnRestablecer" onclick='Clear()'> </p>

<p>
<?php
  if(!isset($_POST['cmbImprimir']) or $_POST['cmbImprimir'] == "No"){
    paginacion($total_paginas,$pag,$_SERVER["PHP_SELF"].'?pagina=');
    $nroReg_mostrar=minimo($nroRegs-($pag-1)*$nroReg_por_pag,$nroReg_por_pag);
  } ?>
  </p>
<p><font color="#800000" size="2"><b>Nro. de Regs.: <?php echo $nroRegs; ?></b><br>
     </b>Mostrando del registro <?php echo $inicio + 1;?> al <?php echo $inicio + $nroReg_mostrar;?></font></p>
<?php

  $data = array();
  while($item = mysql_fetch_array($result)) {
    $deudor = $negocio = "";
    $unique = $item['uniqueid'];
    $fecha =  $item['calldate'];
    $deudor = $item['deudor'];
    $negocio =$item['negocio'];
    $data[] = array($unique,$fecha,$deudor,$negocio);      
  }
  //print_r($data);
  $_SESSION['data'] = $data;
  mysql_data_seek($result,0);

  echo "<table  align=center style=\"border:2px outset black\">";
  echo"<tr><td colspan=".mysql_num_fields($result) .">Reporte emitido el $fecha a las $horasistema </td></tr>";
  //echo "<th></th>";

  for ($i = 0; $i < mysql_num_fields($result); $i++) {
   if(mysql_field_name($result, $i)=='IdNegocio')
    if(isset($_POST['btnEnviar']) or $_GET["pagina"])
       $valorCampo=setControlValor('IdNegocio');
    else
       $valorCampo="='$negocio'";
   else if(mysql_field_name($result, $i)=='GstFchRealiz')
     if(isset($_POST['btnEnviar']) or $_GET["pagina"])
       $valorCampo= setControlValor('GstFchRealiz');
     else
       $valorCampo="= '$fecha' ";    
       
   else
    $valorCampo=setControlValor(mysql_field_name($result, $i));

    if(!$verVariosNegocios and mysql_field_name($result, $i)=='IdNegocio') $readonly='readonly';
    else $readonly='';

 $campo= mysql_field_name($result, $i);
   if($campo=='GstCodigo' or $campo=='Situacion' or $campo=="GstTipoCompromiso")
    {print "<th>";
     MostrarCombo($campo);}
    else
    print "<th><input type = 'text' size = '11' name = '".mysql_field_name($result, $i)."' id = '".mysql_field_name($result, $i)."' value=\"".$valorCampo."\" $readonly ></th>";
  }
  echo "<tr>";
  //echo "<th>Nr.</th>";
  for ($i = 0; $i < mysql_num_fields($result); $i++) {
    print "<th>";
    //Condicional para poner Color en Campos de Fecha Creacion y Fecha Realizada...
    if(mysql_field_name($result, $i)=='FchCreacion' or mysql_field_name($result, $i)=='GstFchRealiz') print "<font color=#0000FF>";
    print mysql_field_name($result, $i); 
    if(mysql_field_name($result, $i)=='FchCreacion' or mysql_field_name($result, $i)=='GstFchRealiz') print "</font>";
    print "</th>";
  }
  echo "</tr>";

  if (!isset($_POST['cmbImprimir']) or $_POST['cmbImprimir'] == "No") {
   $i = 0;
  while ($registro = mysql_fetch_row($result)) {
    //$i++;
    echo "<tr>";
    //echo "<td>".$i."</td>" ;
    foreach($registro  as $clave) {
        echo "<td bgcolor='#BBBBBB'style='border:2px groove black' align='center'   >",$clave,"</td>";
    }
  }
}
  if($_POST['cmbImprimir']=='impCSV'){
	  $nombreArchivo = "reportes/".$usuario."rptGstVisitas".$fecha."_".$horaImpresion.".xyz";
    $f = fopen($nombreArchivo,"w");
    $sep = ",";
    $linea = "Reporte Audios. Solicitado por : ".$usuario.". Fecha: ".$fecha.". Hora : ".$horasistema."\n";
    fwrite($f,$linea);
    $linea = mysql_field_name($result,0);
	  for ($i = 1; $i < mysql_num_fields($result); $i++)
      $linea = $linea.$sep.mysql_field_name($result, $i);
  	$linea.="\n";
	  fwrite($f,$linea); 
  	while ($registro = mysql_fetch_row($result)) {
      $linea=implode($registro,$sep)."\n";
      // el elemento 5 de la query es la operacion.
      /*   $linea = $registro[0];
        for ($i = 1; $i < count($registro); $i++)
        if($i!=5)
        $linea = $linea.$sep.$registro[$i];
        else
        $linea = $linea.$sep."'".$registro[$i];
         // echo $linea; 
    	$linea.="\n";  */
      fwrite($f,$linea);
    }

	 fclose($f);

  echo "<a class = 'menu'  href='$nombreArchivo'>Descargar</a>   ";

   } else if ($_POST['cmbImprimir']=='descargar'){
      header('Location: generaZip.php');


   }


  echo "</tr></table>";
  
  mysql_close();
}
?>
<p><?php   if(!isset($_POST['cmbImprimir']) or $_POST['cmbImprimir'] == "No")
            { paginacion($total_paginas,$pag,$_SERVER["PHP_SELF"].'?pagina=');
        	   } ?></p>
 </form>

   <?php
   echo '<script type="text/javascript">';
   for ($i = 0; $i < mysql_num_fields($result); $i++) {
     if(stristr(mysql_field_name($result, $i),"fch"))
     {    $cmpFecha=mysql_field_name($result, $i);
        print  "Calendar.setup({inputField : '$cmpFecha',ifFormat :'%Y-%m-%d',button :'$cmpFecha'});";
      }
  }
   echo'</script> ';
  ?>

 </body>