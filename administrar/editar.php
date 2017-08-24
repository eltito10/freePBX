<?php
  require_once 'functions/minutos.php';
  require_once 'util/conexion.fn.php';

  
  
     $codigo =(int) $_GET['codigo'];
  

     
     
  //   echo $codigo;

   $anexo = obtener($codigo);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
        <script type="text/javascript">
<!--
     var ventana = window.self; 
     ventana.opener = window.self; 
    // setTimeout("window.close()", 3000);
//-->
</script>
      
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="Style/style.css" rel="stylesheet" type="text/css"/>
    


  
  
  </head>
  <body>

     <?php require_once('includes/header.php') ?>

      <?php require_once('includes/menu.php') ?>
      
      <div id="center">

          <form name="editar" action="actualizar.php" method="post" enctype="multipart/form-data">
              <fieldset>
                <legend></legend>

                <div align="center">
  <!--                 <input type="hidden" name="codigo" value="<?php // echo $usuario['codigo']?>"/>-->
                  
  <table width="224" border="1">
    <tr>
      <td colspan="2"><div align="center">Actualizar Minutos</div></td>
    </tr>
    <tr>
      <td width="115">Anexo</td>
      <td width="104"><input type="text" size="4" name="anexo" disabled="false"  value="<?php echo $anexo['anexo'];?>"/></td>
    </tr>
    <tr>
        <td>Saldo Asignado</td>
        <td><input type="text" size="4" maxlength="3" name="celular" value="<?php echo ROUND($anexo['celular']/60); ?>"/> </td>
    </tr>
    <tr>
      <td>Saldo Usado:</td>
      <td><input type="text" size="4"  maxlength="3" name="celularused" value="<?php echo ROUND($anexo['celularused']/60); ?>"/></td>
    </tr>
    <tr>
      <td>Saldo Restante:</td>
      <td><input type="text" size="4" maxlength="3"  name="celularremain" value="<?php echo ROUND($anexo['celularremain']/60);?>"/></td>
    </tr>
   
      
      
      <tr>
      <td><input type="submit" value="Actualizar"/></td>
      <td><input type="submit" value="Cancelar"/></td>
      </tr>
  </table>
                </div>
                
              </fieldset>
          </form>

      </div>

       <?php require_once('includes/footer.php') ?>

  </body>
</html>
