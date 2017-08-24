<?php
 session_start();
/**
 * @file
 * plays recording file
 */
 

  $zipname = 'audiosZip.zip';
  $zip = new ZipArchive();
  //$zip->open($zipname, ZipArchive::CREATE);
  $zip->open($zipname, ZipArchive::OVERWRITE);
 
  $uniques = $_SESSION['data'];
  foreach ($uniques as $item) {
    $unique = $item['0'];
    $fecha =  $item['1'];
    $deudor =  $item['2'];
    $negocio = $item['3'];
    $gstcodigo = $item['4'];
    $gstcontacto = $item['5'];
    $idempresa = $item['6'];

    $dia = substr($fecha, 0, 10);
    $horas = substr($fecha, 11, 19);
    $hora = str_replace(':', '', $horas);
    //echo $unique." ".$fecha." ".$dia." ".$hora."<br>";
    //$cmd = 'find /var/spool/asterisk/monitor/'.$dia.'/ -name *-'.$hora.'-';
    $cmd = 'find /var/spool/asterisk/monitor/'.$dia.'/ -name *-';    
    $path = exec($cmd.$unique.'.gsm');
    $name = basename($path);
    //$name = $negocio.'_'.$deudor.'_'.$gstcodigo.'_'.$gstcontacto.'_'.$name;
    $name = $idempresa.'_'.$deudor.'_'.$gstcodigo.'_'.$gstcontacto.'_'.$name;
    
    // See if the file exists
    if (is_file($path)) {
      //echo $path." ".$name."<br>";
      $zip->addFile($path,$name); 
    } else
      echo "No lo encontró";
  }
  $zip->close();
  header('Content-Type: application/zip');
  header('Content-disposition: attachment; filename='.$zipname);
  //header('Content-Length: 99999999');
  $tam = 1.2*filesize($zipname);
  header('Content-Length: '.$tam);
  readfile($zipname);

?>