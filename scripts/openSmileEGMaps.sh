#!/bin/bash
function openSmileEGMaps() {
(cd /home/rodrigomassiolo/opensmile-2.3.0/bin/linux_x64_standalone_libstdc6 && ./SMILExtract -C /home/rodrigomassiolo/opensmile-2.3.0/config/gemaps/eGeMAPSv01a.conf -I "$1" -csvoutput "$2" && chmod 777 "$2")
}
VALOR=$( openSmileEGMaps "$1" "$2" )
echo "$VALOR"
exit
