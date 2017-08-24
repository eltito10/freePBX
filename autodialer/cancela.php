<?php
  $conta = 0;
  $dir = '/var/www/html/autodialer/origen/';
  foreach(glob($dir.'*.*') as $v){
  unlink($v);
  $conta++;
  }
  echo "<p align='center'>";
  echo "<br>";
  echo $conta.' mensajes borrados';
  echo chr(10);
  echo "<br></p>";
?>

<html>
<head>
    <title>Autodialer</title>
</head>
<body>
<form action="index.html" method="POST">
<p align="center">
<br>
<input type="submit" value="Inicio" />
</p>
</form>
</body>
</html>

