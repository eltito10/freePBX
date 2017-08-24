<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="Style/style.css" rel="stylesheet" type="text/css"/>

  </head>
<body>
<?php require_once('includes/header.php') ?>

<?php require_once('includes/menu.php') ?>

      <div id="center">

        <div align="center">
          <form action="actualizar.php" method="post">

            <table border="1" width="352" height="98" cellpadding= "0">
            <tr>
              <td>
                <p align="center"><b>
                <font face="Arial" size="3" color="#FFFFFF">
                <a> PROCESO DE DESCARGA DE MINUTOS</a></br>
                </font></b></p>
                <p align="center"><b><font face="Arial" size="2" ><a href='descarga_.php'>Descargar Aqui!</a>  
                </font>
                </b></p></td>
              </tr>
            <tr>
              
            <td  height="19" align="center"> <!--  <div align="center">-->
                <input  type="submit" value="Siguiente" name="btnEnviar" onclick="return confirm('Asegúrese de haber descargado el archivo!')">       
              
            </td>     
                  
            </tr>
            
          </table>
              </form>     
        </div>
      </div>
<?php require_once('includes/footer.php') ?>

  </body>
</html>
