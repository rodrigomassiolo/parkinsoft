#!/bin/bash
function openSmileEnergy() {
(cd /home/rodrigomassiolo/opensmile-2.3.0/bin/linux_x64_standalone_libstdc6 && ./SMILExtract -C /home/rodrigomassiolo/opensmile-2.3.0/config/demo/demo1_energy.conf -I $1 -O $2)
}
VALOR=$( openSmileEnergy $1 $2)
echo "$VALOR"
exit