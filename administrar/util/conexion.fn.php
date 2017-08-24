<?php

function conexion(){

    $con = @mysql_connect('localhost', 'asterisk', '4st3r1sk')
            or die("Error en la consulta: ". mysql_error());

    @mysql_select_db('astquota', $con)
            or die("Error en la seleccion: ".mysql_error());

    return $con;

}

?>
