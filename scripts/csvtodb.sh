#!/bin/bash
function csvtobd() {

sudo mysql -u root -D 'parkinsoft' -e "LOAD DATA LOCAL INFILE '$1' INTO TABLE ENERGY FIELDS TERMINATED BY ';' LINES TERMINATED BY '\\n' IGNORE 1 ROWS (frameIndex, frameTime, pcm_LOGenergy) SET id = NULL, user_id = $2, created=NOW();";

VALOR=$( csvtobd $1 $2)
echo "$VALOR"
exit
