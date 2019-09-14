#!/bin/bash
function clearTables() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from table CHROMA where ejerciciopaciente_id = '$1'"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from table ENERGY where ejerciciopaciente_id = '$1'"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from table AUDSPEC where ejerciciopaciente_id = '$1'"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from table PROSODY where ejerciciopaciente_id = '$1'"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from table EGEMAPS where ejerciciopaciente_id = '$1'"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from table pacienteEjercicio where id = '$1'"
rm -f "'$2'*"
}
VALOR=$( clearTables "$1" "$2" )
echo "$VALOR"
exit
