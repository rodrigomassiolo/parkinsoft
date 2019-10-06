#!/bin/bash
function showIndexesFromTable() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "SHOW INDEXES FROM $1;"

}
VALOR=$( showIndexesFromTable "$1" )
echo "$VALOR"
exit
