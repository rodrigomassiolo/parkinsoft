#!/bin/bash
function openSmileChroma() {
(cd /home/rodrigomassiolo/opensmile-2.3.0/bin/linux_x64_standalone_libstdc6 && ./SMILExtract -C /home/rodrigomassiolo/opensmile-2.3.0/config/chroma_fft.conf -I "$1" -O "$2" && chmod 777 "$2")
}
VALOR=$( openSmileChroma "$1" "$2" )
echo "$VALOR"
exit
