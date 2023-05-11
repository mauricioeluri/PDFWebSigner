# Assinador de PDFs

Assinador de documentos PDF com assinatura eletrônica.

## 1. Objetivos

Este software pode gerar coordenadas para o pyHanko ou gerar o PDF assinado.
Software desenvolvido em javascript e PHP, com o objetivo de gerar coordenadas ou assinar um documento PDF, utilizando a biblioteca Python - Pyhanko.

## 2. Forma de uso

O software funciona de forma simples. Onde, na primeira tela é possível carregar o arquivo PDF que será utilizado, assim como a assinatura. No campo manter assinatura, é possível manter a assinatura salva para não precisar carregá-la a cada uso.
Depois, basta clicar em enviar e em seguida selecionar o local onde a assinatura será salva. Também é possível ajustar o tamanho da caixa da assinatura.
Em seguida, basta selecionar se deseja apenas as coordenadas do pyHanko ou o PDF inteiro gerado com assinatura.

## 3. Configurações

Este software requer uma máquina linux para ser instalado. Podendo ser instalado na máquina virtual, ou em um container Docker já configurado.

### 3.1 Instalação Docker

Após baixar o repositório, certifique-se de ter o Docker instalado e rodando, e em seguida, baixe este respositório para a pasta desejada.

Abra o terminal (No Windows, é o Prompt de Comando), e navegue até a pasta em que a aplicação foi baixada.

Dentro do repositório, rode o seguinte comando:

    docker-compose up

Para baixar a imagem Docker, digite o comando:

    docker build -t assinador-pdf .

Para rodar o container, instalar o resto das dependências e inicializar o Docker, digite o comando:

    docker-compose up

Pronto! Para acessar a aplicação, basta acessar o localhost no seu navegador.

### 3.2 Instalação em Linux

Atualize seus repositórios através do comando:

    sudo apt-get update

Em seguida baixe o Python e o instalador de bibliotecas:
sudo apt-get install --yes python3 python3-pip

Também é necessário que o php seja instalado, junto com o servidor apache:

    sudo apt-get install --yes php php-common libapache2-mod-php

Em seguida, é preciso baixar o git e as fontes noto para a geração de assinaturas:

    sudo apt-get install --yes git fonts-noto

Agora, é necessário instalar as bibliotecas do Python no usuário do servidor Apache:

    sudo -Hu www-data pip3 install pyhanko image uharfbuzz fontTools
    
É necessário alterar as permissões do web server para que seja possível gerenciar os arquivos de assinatura e PDF através de software automatizado.

    sudo chown -R www-data:www-data /var/www/

Em seguida, entre na pasta e clone este repositório:

    cd /var/www/html
    git clone https://github.com/mauricioeluri/assinador-pdf.git

### 3.3 Configuração da Assinatura

Para a geração de PDFs assinados, é necessário configurar o arquivo:

_assinador-pdf/app/signature/pyhanko.yml_

As configurações deste arquivo, dizem respeito à formatação da assinatura e demais configurações como a senha da assinatura digital. Há uma configuração prévia que foi carregada para demonstração. Para utilizá-la, basta alterar a senha de acordo com a senha de sua assinatura digital.

Neste link é possível verificar a documentação oficial do pyHanko sobre este arquivo de configuração: [Configuration options — pyHanko 0.19.0-dev1 documentation](https://pyhanko.readthedocs.io/en/latest/cli-guide/config.html).
