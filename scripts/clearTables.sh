#!/bin/bash
function clearTables() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "truncate table CHROMA"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "truncate table ENERGY"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "truncate table AUDSPEC"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "truncate table PROSODY"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "truncate table EGEMAPS"

}
VALOR=$( clearTables "$1" "$2" )
echo "$VALOR"
exit
