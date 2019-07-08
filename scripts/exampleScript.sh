#!/bin/bash
function retorna_texto() {
if [ "$1" == ""]; 
then
	ls
else
	ls "$1"
fi
}
VALOR=$( retorna_texto $1)
echo "$VALOR"
exit
