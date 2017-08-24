<?php
require_once 'functions/minutos.php';
require_once 'util/conexion.fn.php';

?>
<html>
<head>
	<title>Listado de Minutos a celular</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="Style/style.css" rel="stylesheet" type="text/css"/>
<!--  <style>
			.centrado{ width: 700px; border: 1px solid silver; margin: 10px auto 10px auto; padding:0; }
			.header{ background: #ded4de; }
			h1{ text-align: center; margin-top: 0; padding-top: 10px;}
			.header p{ text-align: center; }
			h2{ margin: 0; padding: 5px 0 0 0; }
			.contenido{ padding: 10px 15px 10px 30px; }
			.contenido p{margin: 0; padding: 5px 0 0 0;}
	</style>-->
<script type="text/javascript">
 function validar(){
    //Puede ser este caso tambien  --> var nombreProceso=document.myForm.proceso.value.length;
//        var nombreProceso =document.forms["myForm"]["proceso"].value;
//        var tipoProceso = document.forms["myForm"]["mi_combobox"].value;
//        
//      
//
// 
//        if (tipoProceso == "valor_0"){//document.myForm.mi_combobox.value == "valor_0"
//            document.myForm.mi_combobox.focus()
//            alert("Elija el tipo de Proceso");
//        return false;
//        }else if(nombreProceso==null || nombreProceso==""){
//            alert("Ingrese un nombre de Proceso");
//            return false;   
//        }else{
            window.open('', 'blanco', 'top=20px,left=200px,width=550px,height=300px');
//       } 
       return false;  

        
        
        
      
 }   
   

</script>


</head>


<body>


      <?php require_once('includes/header.php') ?>

      <?php require_once('includes/menu.php') ?>

<div id="center">
    
    
    <div align="center" >
        
        <?php
         //conecto con la base de datos 
$conn = conexion();
//Limito la busqueda 
$TAMANO_PAGINA = 15; 
$criterio = "";
$hecho=true;

$txt_criterio= isset($_GET['criterio']) ? $_GET['criterio'] : null ; 

if (!empty($_GET['criterio'])){  
    $txt_criterio =split(",",$txt_criterio);
    $contar=count($txt_criterio);
    $ultimo= end($txt_criterio);
    $contarU=count($ultimo);
   // echo"contar".$contar."<br>"."ultimo :".$contarU."<br>";

    for( $i=0;$i<$contar;$i++){

            $criterio = $criterio.$txt_criterio[$i]."','";
    }

    $criterio="where anexo in ('".substr($criterio, 0, strlen($criterio)-3)."')";
    $hecho=false;
}

$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : null ; 

if (!$pagina) { 
    $inicio = 0; 
    $pagina=1; 
} 
else { 
    $inicio = ($pagina - 1) * $TAMANO_PAGINA; 
}






//miro a ver el número total de campos que hay en la tabla con esa búsqueda 
$ssql = "SELECT * FROM `usage` ".$criterio ;
//echo "consulta :".$ssql."<br>";
$rs = @mysql_query($ssql,$conn); 
$num_total_registros = @mysql_num_rows($rs); 
//calculo el total de páginas 
$total_paginas = ceil($num_total_registros / $TAMANO_PAGINA); 

 


//****************************************************************************\\
//=============================DETALLE DE MINUTOS=============================\\
//****************************************************************************\\
//$ssql = "SELECT * FROM celular.usage where celular>0 ";
//echo "resultado sin saldo 1:".$ssql."<br>";
//$rs = @mysql_query($ssql,$conn);
//echo "resultado sin saldo 2:".$rs."<br>";
//$AsignConSaldo = @mysql_num_rows($rs);
$ssql = "SELECT * FROM `usage` ";
$rs = @mysql_query($ssql,$conn); 
$num_total_anexos = @mysql_num_rows($rs);     

    



$sql = "SELECT ROUND(SUM(celular)/60) AS sumaMinutos, ROUND(SUM(celular)/60)*0.31 AS minutosSoles,COUNT(anexo) AS AnexosConSaldo FROM `usage` WHERE celular>0 ";
$rs1 = mysql_query($sql);
while ($fila = @mysql_fetch_array($rs1)){ 
//     echo $fila->campo01."<br>";
              $Anexos_Con_Saldo= $fila['AnexosConSaldo'];
              $Total_Minu_Asigna = $fila['sumaMinutos'];
              $Minu_Soles= $fila['minutosSoles'];
              
              
//              $Anexos_Con_Saldo= $fila->AnexosConSaldo;
//              $Total_Minu_Asigna = $fila->sumaMinutos;
//              $Minu_Soles= $fila->minutosSoles;
}

?>
        
         <div align="left" width="60%">
          <table width="332" border="1">
            <tr>
              <td width="231" align="right">Numero Total de Anexos :</td>
              <td width="85"  align="right"><?php echo $num_total_anexos; ?></td>
            </tr>
            <tr>
              <td align="right">Numero de anexos con Saldo :</td>
<!--             <td align="right"> <a href=""><?php //echo $Anexos_Con_Saldo; ?></a></td>-->
              <td align="right"> <?php echo $Anexos_Con_Saldo; ?></td>
            </tr>
            <tr>
              <td align="right">Total de minutos asignados :</td>
              <td align="right"><?php echo $Total_Minu_Asigna; ?></td>
            </tr>
            <tr>
              <td align="right">Minutos asignados en soles :</td>
              <td align="right"><?php echo $Minu_Soles; ?></td>
            </tr>
          </table>
      </div>
       
<?php


//Datos de la Paginacion
echo "Anexos Encontrados: " . $num_total_registros . "<br>"; 
echo "Se muestran páginas de " . $TAMANO_PAGINA . " registros cada una<br>"; 
echo "Mostrando la página " . $pagina . " de " . $total_paginas . "<p>"; 



//construyo la sentencia SQL 

if($hecho==false){
    $txt_criterio = $_GET['criterio'];
    
    $lista=mostrarLista($criterio);
     echo "crt1:".$criterio;
}else{
    $txt_criterio="";
   // $criterio="where anexo like '%" . $txt_criterio . "%' ";
   // echo "crt2:".$criterio;
    $lista=mostrarLista($criterio);
   
}
    
 


?>
            <form action="index.php" method="GET" >
                
            
            <table  border="1"  width="21%">
                <tr>
                   
                    <th>Anexo</th>     
                    <td>
                        <input type="text" name="criterio">
                    </td>
                    <td>
                       <input type="submit" value="Buscar"/>
                    </td>

                </tr>
            </table>
      </form>  
<table border="1" width="61%">
    <thead>
       
                  <tr>
                      <th>Anexo</th>
                      <th>Saldo Asignado</th>
                      <th>Saldo Usado</th>
                      <th>Saldo Restante</th>
                      <th>Estado</th>
                  </tr>
    </thead>
        <tbody>
<?php        
foreach ($lista as $anexos ){
 
    //if($fila->celular >0){
   ?>      
    
    
 
     <tr bgcolor="orange">
        <td><?php echo $anexos['anexo']; ?></td>
        <td>  <?php echo $anexos['celular']; ?></td>
        <td>  <?php echo $anexos['celularused']; ?></td>
        <td>  <?php echo $anexos['celularremain']; ?></td>
        <td><a href="editar.php?codigo=<?php echo $anexos['anexo']?>">Editar</a></td>
     </tr>
             
   
 <?php  //}else{?>
<!--     <tr>
        <td>  <?php //echo $fila->anexo ?></td> 
        <td>  <?php //echo $fila->celular ?></td>
        <td>  <?php// echo $fila->celularused ?></td>
        <td>  <?php// echo $fila->celularremain ?></td>
        <td><a></a></td>
     
     </tr>-->
     
 <?php    
 //}
 
 
 } ?>
 </tbody>
      </table> 
</div>
        
<div  width="40%" >
            
        
  <div align="center">
    <?php 

if ($total_paginas > 1){ 
    

if($num_total_registros>$TAMANO_PAGINA){
    //Ahora, vamos a generar la paginación en php, y crear botones por cada página, para que el usuario navegue para ver todas las entradas anteriores.
if(($pagina - 1) > 0) {
//echo "<span class='pactiva'><a href='index.php?pagina=".($pagina-1)."'>&laquo; Anterior</a></span> ";
echo "<span class='pactiva'><a href='index.php?pagina=".($pagina-1)."&criterio=" .$txt_criterio."'>&laquo; Anterior</a></span> ";
}


for ($i=1; $i<=$total_paginas; $i++){ 
        
        if ($pagina == $i){
        echo "<span class='pnumero'>".$pagina."</span> "; 
        }else{
      
            
            //echo "<span class='pactiva'><a href='index.php?pagina=".$i."'>".$i."</a></span>"; 
            echo "<span class='pactiva'><a href='index.php?pagina=".$i."&criterio=" .$txt_criterio."'>".$i."</a></span>"; 
            
       
        }
}


if(($pagina + 1)<=$total_paginas) {
echo " <span  class='pactiva'><a href='index.php?pagina=".($pagina+1)."&criterio=" .$txt_criterio."'>Siguiente &raquo;</a></span>";
//echo " <span  class='pactiva'><a href='index.php?pagina=".($pagina+1)."'>Siguiente &raquo;</a></span>";
}



}

    
}


mysql_close($conn); 
              
        
              ?>
    
  </div>
</div>     
    
</div>
           
    
</div>    

  <?php require_once('includes/footer.php') ?>

</body>
