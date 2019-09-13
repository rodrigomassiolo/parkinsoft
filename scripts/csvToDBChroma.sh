#!/bin/bash
function csvToDBChroma() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "LOAD DATA LOCAL INFILE '$1' INTO TABLE CHROMA FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 ROWS (frame, DO, DO_SOST, RE, RE_SOST, MI, FA, FA_SOST, SOL, SOL_SOST, LA, LA_SOST, SI) SET id = NULL, user_id = $2, ejerciciopaciente_id = $3, created=NOW();"

}
VALOR=$( csvToDBChroma "$1" "$2" "$3" )
echo "$VALOR"
exit
