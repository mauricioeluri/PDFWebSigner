#!/bin/bash
DIR=$(readlink -f shared)
sudo docker image pull sf23/pdfwebsigner:latest
sudo docker run -it --name=pdfwebsigner-$RANDOM -v $DIR:/pdfwebsigner/shared -e DISPLAY=unix$DISPLAY sf23/pdfwebsigner:latest 
