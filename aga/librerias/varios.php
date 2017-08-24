<?php


function codificarPass($usuario,$pass)	//nombre de la base de datos que se pasa como parámetro
{
   //Aqui debe ir el codigo de codificacion
   return $pass;
}

function ObtenerOpciones($tabla,$campo,$link = null){
  //$qry = "SHOW COLUMNS FROM ".$Tabla." LIKE '".$Campo."'";
  $qry = "SHOW COLUMNS FROM $tabla LIKE '$campo'";
  if ($link == null)
    $query = mysql_query($qry);
  else 
    $query = mysql_query($qry,$link);
  // Creamos un Array con el resultado de la consulta
  $result = mysql_fetch_array($query);
  $result = explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$result[1]));
	//echo $result;
  return $result;
}


function difDias($date1,$date2){
  if (empty($date1) or ($date1 == '0000-00-00')) {$date1 = Date("Y-m-d");}
  if (empty($date2) or ($date2 == '0000-00-00')) {$date2 = Date("Y-m-d");}
  $segs = strtotime($date1)-strtotime($date2);
  $dDias = intval($segs/86400);
  return $dDias;
}

function enMinSeg($segs){
  $min = intval($segs/60);
  $seg = $segs % 60; 
  return $min.':'.$seg;
}

function enHraMinSeg($segs){
  $hra = intval($segs/3600);
  $res = $segs % 3600;
  $min = intval($res/60);
  $seg = $res % 60; 
  return $hra.':'.$min.':'.$seg;
}

function tiempoTransMinutos($hora1,$hora2){
  $separar[1]=explode(':',$hora1);
  $separar[2]=explode(':',$hora2);
  $minTranscurridos[1] = ($separar[1][0]*60)+$separar[1][1];
  $minTranscurridos[2] = ($separar[2][0]*60)+$separar[2][1];
  $minTranscurridos = $minTranscurridos[2]-$minTranscurridos[1];
  return $minTranscurridos;
} 


?>
