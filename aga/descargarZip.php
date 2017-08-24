<?php

  //require_once 'config.ini.php';
  //require_once './librerias/conectar.php';
  //require_once './librerias/varios.php';
//echo "<h1>Esto es una prueba</h1>";
//phpinfo();


  $files = array('sunat.png','candado.png','descargarZip.php');
  $zipname = 'file.zip';
  $zip = new ZipArchive();
  $zip->open($zipname, ZipArchive::CREATE);
  foreach ($files as $file) {
    $zip->addFile($file);
  }
  $zip->close();

  header('Content-Type: application/zip');
  header('Content-disposition: attachment; filename=file.zip');
  header('Content-Length: '.filesize($zipname));
  readfile($zipname);

?>