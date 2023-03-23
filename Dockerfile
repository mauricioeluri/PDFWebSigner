FROM php:8.1-apache-bullseye
ADD ./app /var/www/html
EXPOSE 80


# UPDATE PACKAGE INFORMATION
RUN apt-get update


# INSTALL PACKAGES
RUN apt-get install --yes \
  sudo \
  python3 \
  python3-pip

# UPGRADE PIP
#RUN python3 -m pip install \
 # --upgrade pip


# iNSTALL PYHANKO
#RUN pip3 install pyhanko
#RUN pip3 install image
#RUN pip3 install uharfbuzz
#RUN pip3 install fontTools


# chown -R www-data:www-data /var/www
# sudo -H -u www-data pip3 install pip-tools

#working
#sudo -H -u www-data pip3 install pyhanko
#sudo -H -u www-data pip3 install image
#sudo -H -u www-data pip3 install uharfbuzz 
#sudo -H -u www-data pip3 install fontTools