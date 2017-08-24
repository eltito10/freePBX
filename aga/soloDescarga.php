<?php
  session_start();
  require_once 'config.ini.php';
  require_once './librerias/conectar.php';
  require_once './librerias/varios.php';
  require './librerias/funciones.php';
  $link=conectarse($base);
  $where = urldecode($_GET['where']);
 // echo $where;
  $qry = "SELECT  left( calldate, 10 ) AS fchCreacion, clid, calldate, src AS anexo, dst AS telefono, uniqueid, negocio, deudor, disposition AS contestado, gstcodigo, gstcontacto, idempresa FROM cdr WHERE $where ";
 // echo $qry;

  $result = mysql_query($qry);
  $data = array();
  while($item = mysql_fetch_array($result)) {
    $deudor = $negocio = "";
    $unique = $item['uniqueid'];
    $fecha =  $item['calldate'];
    $deudor = $item['deudor'];
    $negocio  = $item['negocio'];
    $gstcodigo =$item['gstcodigo'];
    $gstcontacto =$item['gstcontacto'];
    $idempresa =$item['idempresa'];

    $data[] = array($unique,$fecha,$deudor,$negocio,$gstcodigo,$gstcontacto,$idempresa);      
  }

  //print_r($data);
  $_SESSION['data'] = $data;
  mysql_data_seek($result,0);

  header('Location: generaZip.php');

?>