#!/bin/bash
function showColumnsFromTable() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "SHOW COLUMNS FROM $1;"

}
VALOR=$( showColumnsFromTable "$1" )
echo "$VALOR"
exit
