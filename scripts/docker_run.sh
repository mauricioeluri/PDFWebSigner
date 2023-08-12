#!/bin/bash
sudo docker run -it --name=pdfwebsigner-$RANDOM -e DISPLAY=unix$DISPLAY sf23/pdfwebsigner:latest $*
