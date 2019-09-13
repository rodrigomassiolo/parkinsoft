#!/bin/bash
function csvToDBProsodyAcf() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "LOAD DATA LOCAL INFILE '$1' INTO TABLE PROSODY FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 ROWS (frameTime, voiceProb_sma, F0_sma, pcm_loudness_sma) SET id = NULL, user_id = $2, ejerciciopaciente_id = $3, created=NOW();"

}
VALOR=$( csvToDBProsodyAcf "$1" "$2" "$3" )
echo "$VALOR"
exit
