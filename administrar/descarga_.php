<?php 
require_once 'util/conexion.fn.php';



    $fchNombre = Date("Ymd"); 
    $link = conexion();

       $qryGst = "SELECT anexo,celular,celularused,celularremain FROM `usage`"; 
       $rst = mysql_query($qryGst,$link);
      //$nroReg = mysql_num_rows($rst);
      //echo "QUERY $qryGst"; 
      //$nombreArchivo = "./reportes/".$usuario."rptFinanciero".$fecha."_".$horaImpresion.".xyz";
      $nombre ="CASTILLEJO".$fchNombre.".xyz";
      $nombreArchivo = "reportes/".$nombre;
      $f = fopen($nombreArchivo,"w");
//  $nombreArchivo = "C:/wamp/www/Minutos/reportes/CASTILLEJO".$fchNombre.".xyz";
      
    //  header('Content-disposition: attachment; $nombreArchivo');
      
     
      while($reg = mysql_fetch_array($rst)) {
                
                $anexo= $reg ['anexo'];
                $celular=$reg ['celular'];
                $celularused=$reg ['celularused'];
                $celularremain = $reg['celularremain'];
                


                $linea = $anexo.",".$celular.",".$celularused.",".$celularremain."\r\n";
                //$linea = $anexo."\t".$celular."\t".$celularused."\t".$celularremain."\t"."\r\n";
                fwrite($f,$linea);
      }


    mysql_free_result($rst);
    fclose($f);



    header ("Content-Disposition: attachment; filename=".$nombre.";" ); 
    header ("Content-Type: application/force-download"); 
    readfile($nombreArchivo); 
    //echo "<a class = 'menu'  href='readfile('$nombreArchivo)'>Descargar</a>   ";

    exit; 

?> 
