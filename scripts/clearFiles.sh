#!/bin/bash
function clearTables() {
c="rm -f "; path="$1"; eval $c "$path" 
}
VALOR=$( clearTables "$1" )
echo "$VALOR"
exit
