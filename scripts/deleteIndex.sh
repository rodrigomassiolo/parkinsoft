#!/bin/bash
function deleteIndex() {
mysql -u higia -p'Server123' -D 'parkinsoft' -e "DROP INDEX $1 ON TABLE $2;"

}
VALOR=$( deleteIndex "$1" "$2" )
echo "$VALOR"
exit
