#!/bin/bash
function csvToDBEnergy() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "LOAD DATA LOCAL INFILE '$1' INTO TABLE ENERGY FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 ROWS (frameIndex, frameTime, pcm_LOGenergy) SET id = NULL, user_id = $2, ejerciciopaciente_id = $3, created=NOW();"

}
VALOR=$( csvToDBEnergy "$1" "$2" "$3" )
echo "$VALOR"
exit
