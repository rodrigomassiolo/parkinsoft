#!/bin/bash
function ffmpeg() {
ffmpeg -i $1 $2 >/dev/null 2>&1
}
VALOR=$( ffmpeg $1 $2)
echo "$VALOR"
exit