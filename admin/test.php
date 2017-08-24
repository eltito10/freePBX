<?php

/**
 * @file
 * plays recording file
 */

  $unique = '2012-07-18_15:10:40';
  $dia = substr($unique, 0, 10);
  $horas = substr($unique, 11, 19);
  $hora = str_replace(':', '', $horas);		
  $cmd = 'find /var/spool/asterisk/monitor/'.$dia.'/ -name *-'.$hora.'*';
  echo $cmd;
?>

