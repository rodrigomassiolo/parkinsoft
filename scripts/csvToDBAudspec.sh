#!/bin/bash
function csvToDBAudspec() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "LOAD DATA LOCAL INFILE '$1' INTO TABLE AUDSPEC FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 ROWS (frameTime, audSpec_0, audSpec_1, audSpec_2, audSpec_3, audSpec_4, audSpec_5, audSpec_6, audSpec_7, audSpec_8, audSpec_9, audSpec_10, audSpec_11, audSpec_12, audSpec_13, audSpec_14, audSpec_15, audSpec_16, audSpec_17, audSpec_18, audSpec_19, audSpec_20, audSpec_21, audSpec_22, audSpec_23, audSpec_24, audSpec_25, audSpec_de_0, audSpec_de_1, audSpec_de_2, audSpec_de_3, audSpec_de_4, audSpec_de_5, audSpec_de_6, audSpec_de_7, audSpec_de_8, audSpec_de_9, audSpec_de_10, audSpec_de_11, audSpec_de_12, audSpec_de_13, audSpec_de_14, audSpec_de_15, audSpec_de_16, audSpec_de_17, audSpec_de_18, audSpec_de_19, audSpec_de_20, audSpec_de_21, audSpec_de_22, audSpec_de_23, audSpec_de_24, audSpec_de_25, audSpec_de_de_0, audSpec_de_de_1, audSpec_de_de_2, audSpec_de_de_3, audSpec_de_de_4, audSpec_de_de_5, audSpec_de_de_6, audSpec_de_de_7, audSpec_de_de_8, audSpec_de_de_9, audSpec_de_de_10, audSpec_de_de_11, audSpec_de_de_12, audSpec_de_de_13, audSpec_de_de_14, audSpec_de_de_15, audSpec_de_de_16, audSpec_de_de_17, audSpec_de_de_18, audSpec_de_de_19, audSpec_de_de_20, audSpec_de_de_21, audSpec_de_de_22, audSpec_de_de_23, audSpec_de_de_24, audSpec_de_de_25) SET id = NULL, user_id = $2, created=NOW();"

}
VALOR=$( csvToDBAudspec "$1" "$2" )
echo "$VALOR"
exit
