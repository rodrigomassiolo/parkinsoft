#!/bin/bash
function clearTables() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from CHROMA where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from ENERGY where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from AUDSPEC where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from PROSODY where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from EGEMAPS where ejerciciopaciente_id = $1"
mysql -u higia -p'Server123' -D 'parkinsoft' -e "delete from pacienteEjercicio where id = $1"
c="rm -f"; path="$2"; a=".*"; echo "$c" "$path""$a"; eval $c $path$a
}
VALOR=$( clearTables "$1" "$2" )
echo "$VALOR"
exit