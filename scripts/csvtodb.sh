#!/bin/bash
sudo mysql -u root -D 'parkinsoft' -e "LOAD DATA LOCAL INFILE '/home/rodrigomassiolo/energy.csv' INTO TABLE ENERGY FIELDS TERMINATED BY ';' LINES TERMINATED BY '\n' IGNORE 1 ROWS (frameIndex, frameTime, pcm_LOGenergy) SET id = NULL, user_id = 1, created=NOW();";
exit