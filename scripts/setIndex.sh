#!/bin/bash
function setIndex() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "CREATE INDEX $1 ON $2 ($3);"
}
VALOR=$( setIndex "$1" "$2" "$3" )
echo "$VALOR"
exit
