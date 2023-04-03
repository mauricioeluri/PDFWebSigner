FROM php:8.1-apache-bullseye
ADD ./app /var/www/html
EXPOSE 80

# Atualizando pacotes
RUN apt-get update

# Instalando dependências
RUN apt-get install --yes \
  sudo \
  python3 \
  python3-pip \
  fonts-noto

# Definindo permissões da pasta para o php.
# Serve para gerenciar os arquivos diretamente
# pela aplicação.
RUN chown -R www-data:www-data /var/www

# Instalando bibliotecas do pyhanko pelo
# usuário www-data, para que o pyhanko possa
# ser executado diretamente pelo php.
RUN sudo -Hu www-data pip3 install pyhanko
RUN sudo -Hu www-data pip3 install image
RUN sudo -Hu www-data pip3 install uharfbuzz 
RUN sudo -Hu www-data pip3 install fontTools