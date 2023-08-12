#!/bin/bash
./run_demo_browser.sh &> /dev/null &
sudo docker run -it -p 127.0.0.1:80:80 --name=pdfwebsigner-$RANDOM -v $(readlink -f app):/pdfwebsigner/shared -e DISPLAY=unix$DISPLAY sf23/pdfwebsigner:latest 
