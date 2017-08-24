#!/bin/bash
#
#Lista los archivos, copia los cinco primeros y los borra
#

#Directorios de origen y destino, estos deben ser modificados
#segun sea el directorio
dir_origen="/var/www/html/autodialer/origen"
dir_destino="/var/spool/asterisk/outgoing"

#Se mueve al directorio de origen
cd $dir_origen

#Se listan los archivos .call presentes
lista_archivos="`ls -tr *.call`"

if [ -n "$lista_archivos" ]; then
  cont=0
  for arch in $lista_archivos;
   do
     mv $arch $dir_destino
     let cont=cont+1
     if [ $cont -eq $1 ]; then
        break
     fi
   done
else
 crontab -r
fi
