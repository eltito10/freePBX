<html>
<head>
    <title>Proceso de Actualizacion de Minutos</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="Style/style.css" rel="stylesheet" type="text/css"/>
  
<script type="text/javascript">
 function validar(){
    //Puede ser este caso tambien  --> var nombreProceso=document.myForm.proceso.value.length;
        var nombreProceso =document.forms["myForm"]["proceso"].value;
        var tipoProceso = document.forms["myForm"]["mi_combobox"].value;
        
      

 
        if (tipoProceso == "valor_0"){//document.myForm.mi_combobox.value == "valor_0"
            document.myForm.mi_combobox.focus()
            alert("Elija el tipo de Proceso");
        return false;
        }else if(nombreProceso==null || nombreProceso==""){
            alert("Ingrese un nombre de Proceso");
            return false;   
        }else{
            window.open('', 'blanco', 'top=20px,left=200px,width=550px,height=300px');
        }

        
        
        
      
 }   
   
 
    
//    
//function compruebaCheckBox(checkerbox,div){
//if(checkerbox.checked){
//document.getElementById(div).style.display="block"
//}
//else{
//document.getElementById(div).style.display="none"
//}
//}
//function abrirventana01(pag){
//open(pag,"sizewindow","width=900, height=400,scrollbars=yes,toolbar=no")
//}
</script>
    
    
</head>

<body>


      <?php require_once('includes/header.php') ?>

      <?php require_once('includes/menu.php') ?>

<div id="center">
    <h1 align="center"> Actualizar Minutos</h1>
<!--<h2>Env&iacute;o de archivos en PHP.</h2>-->
<!--return validar();-->
<div >
    <form method="POST" name="myForm"  target="blanco" action="actualizar_.php"  onsubmit="return validar();"  enctype="multipart/form-data" ><!--//window.open('', 'blanco', 'top=20px,left=200px,width=550px,height=300px')-->
      <ul>
        <div align="center">
          <table width="436" border="1">
            <tr>
                <td>
                    <div align="right">Tipo de Proceso:</div>
                </td>
                <td><select name="mi_combobox"> 
                    <option value="valor_0">-- Selecicone el tipo de Proceso --</option>
                    <option value="valor_1">Carga General de Minutos</option> 
                    <option value="valor_2">Actualizacion</option>
                </td>
            </tr>
            <tr>
                <td width="162"><div align="right">Archivo:</div></td>
                <td width="258"><input name="file1" type="file"></td>
            </tr>
            <tr>
                <td><div align="right">Nombre Proceso:</div></td>
                <td><input type="text" name="proceso" size="30" /></td>
            </tr>
            <tr>
                <td><div align="center">
                    <input type="submit" value="Enviar">
                </div></td>
                <td>&nbsp;</td>
            </tr>
          </table>
        </div>
      </ul>
</form>

       </div>
</div>    

  <?php require_once('includes/footer.php') ?>

</body>
</html>