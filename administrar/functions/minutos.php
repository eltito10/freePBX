<?php
require_once 'util/conexion.fn.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function listar(){
    $minutos = array();
    $query = "SELECT anexo,ROUND(celular/60) as celular,ROUND(celularused/60) as celularused ,ROUND(celularremain/60)as celularremain  FROM `usage` ORDER BY  anexo";
    //$query = "SELECT anexo,celular,celularused,celularremain FROM celular.usage where celular!=0";
    $con = conexion();
    $rs = @mysql_query($query, $con)
            or die("Error en consulta: " . mysql_error($con));

    while($fila = mysql_fetch_array($rs)){
        $minutos[] = $fila;
    }

    return $minutos;
}

function actualizar($anex){
    $con = conexion();

    $anexo = mysql_real_escape_string($anex['anexo']);
    $celular = mysql_real_escape_string($anex['celular']);
    $celularUsed = mysql_real_escape_string($anex['celularUsed']);
    $celularRemain = mysql_real_escape_string($anex['celularRemain']);
//    $resumen = mysql_real_escape_string($anexo['resumen']);

    $query = "UPDATE `usage`
              SET celular = $celular , celularused = $celularUsed ,celularremain = $celularRemain 
              WHERE anexo = $anexo";
    
    

    @mysql_query($query, $con)
            or die('Error en consulta: '.  mysql_error($con));

}

function obtener($codigo){
    $con = conexion();

   // $codigo = mysql_real_escape_string($codigo);

    $query = "SELECT anexo,celular,celularused,celularremain 
              FROM `usage`
              WHERE anexo = '$codigo'";

    $rs = @mysql_query($query, $con)
            or die('Error en consulta: '.  mysql_error($con));

    if($fila = mysql_fetch_array($rs)){
        return $fila;
    }else{
        return false;
    }

}
function ingresar($nombre){
    
    
    $con = conexion();
    
    $sql = "INSERT INTO logprocesos  (FechaProceso, NombreProceso)
            VALUES(NOW(),'$nombre')";
        
    
    @mysql_query($sql,$con)
              or die('Error en consulta: '.  mysql_error($con));
    
    
    
}

function mostrarLista($criterio){

    $conn=  conexion();
    
    
    

global $inicio,$TAMANO_PAGINA;

$minutos = array();


$ssql = "SELECT anexo,ROUND(celular/60) as celular,ROUND(celularused/60) as celularused ,ROUND(celularremain/60)as celularremain FROM `usage`  " .$criterio. "ORDER BY  anexo"." limit " . $inicio . "," . $TAMANO_PAGINA; 
$rs = @mysql_query($ssql); 
       // or die("Error en consulta: " . mysql_error($conn));





       
while ($fila = @mysql_fetch_array($rs)){ 
             $minutos[] = $fila;
}

 return $minutos;

}





?>
