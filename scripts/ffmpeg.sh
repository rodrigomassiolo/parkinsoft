#!/bin/bash
<<<<<<< HEAD
function ffmpegf() {
ffmpeg -i "$1" "$2"
}
VALOR=$( ffmpegf "$1" "$2" )
=======
function ffmpeg() {
ffmpeg -i "$1" "$2"
}
VALOR=$( ffmpeg "$1" "$2" )
>>>>>>> 731dd5c199070c80eff5631a48f3a9592fbc46d2
echo "$VALOR"
exit
