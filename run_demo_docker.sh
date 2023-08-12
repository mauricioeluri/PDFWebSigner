#!/bin/bash
DIR=$(readlink -f app)
sudo docker image pull sf23/pdfwebsigner:latest
sudo docker run -it --name=pdfwebsigner-$RANDOM -p 127.0.0.1:80:80 -v $DIR:/var/www/html -e DISPLAY=unix$DISPLAY sf23/pdfwebsigner:latest 
