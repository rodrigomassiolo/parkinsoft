#!/bin/bash
function setIndex() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "ALTER TABLE $1 ADD INDEX $2;"

}
VALOR=$( setIndex "$1" "$2" )
echo "$VALOR"
exit
