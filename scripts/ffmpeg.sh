#!/bin/bash
function ffmpegf() {
ffmpeg -i "$1" "$2" && chmod 777 "$2"
}
VALOR=$( ffmpegf "$1" "$2" )
echo "$VALOR"
exit
