#!/bin/bash
function ffmpeg() {
ffmpeg -i $1 $2
}
VALOR=$( ffmpeg $1 $2)
echo "$VALOR"
exit