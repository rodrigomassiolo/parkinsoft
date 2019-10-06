#!/bin/bash
function showTables() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "SHOW TABLES;"

}
VALOR=$( showTables )
echo "$VALOR"
exit
