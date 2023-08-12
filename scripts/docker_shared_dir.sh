#!/bin/bash
[ $1 ] && [ -d $1 ] || {
	echo "Usage: $0 <code_directory>"
	echo " example: $0 ."
	exit
}
sudo docker run -it --name=pdfwebsigner-$RANDOM -v $(readlink -f $1):/pdfwebsigner/shared -e DISPLAY=unix$DISPLAY sf23/pdfwebsigner:latest
