<?php
require_once 'util/conexion.fn.php';
require_once 'functions/minutos.php';





	# parametros
	$error 			= true;
	$directorio		= "C:/wamp/www/Minutos/cargas/";
//        $directorio		= "http://www.xxxx.yyy/ficheros/"
	
	# metadatos del fichero
	$nombre_archivo = $_FILES['file1']['name'];
	$tipo_archivo   = $_FILES['file1']['type'];
	$tamano_archivo = $_FILES['file1']['size'];
	$nombre_temp    = $_FILES['file1']['tmp_name'];
       # otros datos del formulario
        
        
        $tipoProceso = $_POST['mi_combobox'];
        $nombre	= $_POST['proceso'];
	         
        //var_dump($tipoproceso);
          
       
	//$email			= $_POST['email'];
	/*Codigo Valida el formato y el tamaño del archivo
         * 
         * if (strpos($tipo_archivo, "gif") || strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "png") && ($tamano_archivo < 1500000)){
         * 
         * 
         */
   
    
        //if ( strpos($tipo_archivo,"vnd.ms-excel") && ($tamano_archivo < 2500000) ){
	if (  ($tamano_archivo < 150000)){
               
            if (is_uploaded_file($nombre_temp)) {
                   
                  /* Este codigo comentado reemplaza todo lo que esta debajo de el..
                   * copy($nombre_temp, $directorio.$_FILES['file1']['name']);
                    * $error = false;
                  */   
                 //
                
                    $img = $directorio.$_FILES['file1']['name'];
                    $t=0;
                    
                    while(file_exists($img)){
                        $img = $directorio.$_FILES['file1']['name'];
                        $img=substr($img,0,strpos($img,"."))."_$t".strstr($img,".");
                        $t++;
                      
                    }
                                        
                   /* Este codigo tambien se puede utilizar en vez del copy.
                    * move_uploaded_file($_FILES['file1']['tmp_name'], $img);
                    */
                  // copy($nombre_temp, $img );
                    move_uploaded_file($nombre_temp, $img);
             
                    ingresar($nombre);
                    
                    if($tipoProceso=='valor_1'){
              
                    $con = conexion();
                    $sql = 'TRUNCATE TABLE `carga`';
                    $result = mysql_query($sql,$con);
                    echo $img;
                    $sql= "LOAD DATA LOCAL INFILE '$img' INTO TABLE `carga` FIELDS ESCAPED BY '/' TERMINATED BY ',' ENCLOSED BY '' LINES TERMINATED BY '\r\n'";
                    $result = mysql_query($sql,$con);
                    
                    $sql= "delete FROM carga WHERE campo01=''";
                    $result = mysql_query($sql,$con);
                   
                    $sql= "UPDATE `usage` SET celular='0', celularused='0', celularremain='0'";
                    $result = mysql_query($sql,$con);
                   
                    $sql= "UPDATE carga,`usage` SET  celular=(campo02*60), celularremain='1' WHERE anexo=campo01";
                    $result = mysql_query($sql,$con);
                    
                   
                    
                  // $nroRegsActualizados = mysql_affected_rows();
                 
//                   if(!($resultContador = mysql_query($sql)))
//                     echo "<script>alert(".mysql_error().");</script>" ;
//                  
                
                

                   if(!($result = mysql_query($sql))){
                      echo "<script>alert(".mysql_error().");</script>" ;
                     }
                     
                     
                     
                     
                     
                 //     $contar="SELECT * FROM carga";
                   //   $contar2="SELECT * FROM carga where campo01=''";
                     //  $resultContador2 = mysql_query($contar2,$con);
                  //  $resultContador = mysql_query($contar,$con);
               //     echo "\<ul>\n<li>\n<strong>Se han Cargado: ".mysql_num_rows($resultContador)." registros</i>.\n";
                  //  echo "\<ul>\n<li>\n<strong>Filas vacias: ".mysql_num_rows($resultContador2)." Filas vacias</i>.\n";
                        
                 
                $error = false;  
                
             }else if($tipoProceso=='valor_2'){
                   $con = conexion();
                    $sql = 'TRUNCATE TABLE `carga`';
                    $result = mysql_query($sql,$con);
                    echo $img;
                    $sql= "LOAD DATA LOCAL INFILE '$img' INTO TABLE `carga` FIELDS ESCAPED BY '/' TERMINATED BY ',' ENCLOSED BY '' LINES TERMINATED BY '\r\n'";
                    $result = mysql_query($sql,$con);
                    
                    $sql= "delete FROM carga WHERE campo01=''";
                    $result = mysql_query($sql,$con);
                    
                    
                        
                        
                        
             }
                    
                    
            
                  
         
            }else{
                    echo "Ocurrió algún error al subir el fichero. No pudo guardarse.";
                    //echo $_FILES['file1']['type'];
                    printf("<p style=\"color: red\">Se ha producido un error al intentar subir el archivo.</p>");
            }
	}
        else
        {
               // echo "Ocurrio algun error al subir el fichero. No pudo guardarse";
		printf("<p style=\"color: red\">El archivo seleccionado no es un archivo CSV o excede 1.5mb de peso.</p>");
        }	
	
	# pintamos el resultado
	if (!$error){
            
		printf("\nEnhorabuena, se ha subido correctamente el fichero <i>".$nombre_temp."</i>.\n");
                printf("\nEnhorabuena, su arhivo <i>".$nombre_archivo."se ha cargado</i>.\n");
		printf("\<ul>\n<li>\n<strong>Nombre Proceso: ".$nombre."</li>\n");
		//printf("\<ul>\n<li>\n<strong>E-mail: ".$email."</li>\n</ul>\n");
              //  printf("<p><a href=\"index.php\">Volver</a></p>");
	}else{
		
//printf("<p>Seleccione un archivo</p>");
//printf("<p><a href=\"index.php\">Volver</a></p>");
	}
        
   
//	header("Location: index.php");

?>
<html>
  <head>
  
  <script type="text/javascript">
<!--
     var ventana = window.self; 
     ventana.opener = window.self; 
    // setTimeout("window.close()", 3000);
//-->
</script>

  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta name="generator" content="PSPad editor, www.pspad.com">
  <title></title>
  </head>
  <body>
      <?php 
    //  echo "Numero de registros :".$nroRegsActualizados;
      
      ?>
      

  </body>
</html>
<!--     <input type="button" onclick="window.close()" value="Cerrar!" />-->
