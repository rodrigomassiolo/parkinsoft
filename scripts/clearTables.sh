#!/bin/bash
function clearTables() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from CHROMA where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from ENERGY where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from AUDSPEC where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from PROSODY where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from EGEMAPS where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from pacienteEjercicio where id = $1"
echo "$2*" 1>&3
rm -f "$2*"
}
VALOR=$( clearTables "$1" "$2" )
echo "$VALOR"
exit
