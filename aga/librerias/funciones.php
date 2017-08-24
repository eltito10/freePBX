
<?php
function minimo($n1,$n2)
{ if($n1<$n2) return $n1; else return $n2;
 } 

function setControlValor($control) { 
if($_POST[$control]<>'')
return $_POST[$control];
else 
return "";
}


// la función
function paginacion($total_pags,$pag,$url) {


if($total_pags>10) {
   $num_pags=10;
if($pag>=5 && $pag<=($total_pags-5)) {
$pag_ini=$pag-5;
} else if($pag<5) {
$pag_ini=0;
} else {
$pag_ini=$pag-5-(($pag+5)-$total_pags);

}
} else {
$pag_ini=0;
$num_pags=$total_pags;
}


$ult_pag= $pag_ini + $num_pags; $page_nav='';
for($i=$pag_ini;$i< $ult_pag;$i++) {
$pagina=$i+1;
if($pagina==$pag) {
$page_nav .= '<b>['.$pagina.']</b>';
} else {
$page_nav .= '<a href=javascript:Ir_a_Pag("'.$url.$pagina.'") class=paginacion>'.$pagina.'</a> ';
}
}

if($pag< $total_pags) {
$page_last = "<b><a href=javascript:Ir_a_Pag('".$url.($total_pags)."') title='Ult.Pagina' class=paginacion> >> </a></b>";
$page_next = "<a href=javascript:Ir_a_Pag('".$url.($pag+1)."') title='Pagina Siguiente' class=paginacion> > </a>";
}

if($pag>1) {
$page_first = "<b><a href=javascript:Ir_a_Pag('".$url."1') title='Prim.Pagina' class=paginacion> << </a></b>";
$page_previous ="<a href=javascript:Ir_a_Pag('".$url.($pag-1)."') title='Pagina Anterior' class=paginacion> < </a>";
}

echo "<font size=4 color=#800000> $page_first  $page_previous  $page_nav  $page_next  $page_last </font>";
}


?>