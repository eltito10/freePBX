<?php

function conexion(){

    $con = @mysql_connect('127.0.0.1', 'root', '')
            or die("Error en la consulta: ". mysql_error());

    @mysql_select_db('celular', $con)
            or die("Error en la seleccion: ".mysql_error());

    return $con;

}

?>
