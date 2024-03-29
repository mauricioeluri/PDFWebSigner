<?php if(count(get_included_files()) == 1)exit('Acesso direto não permitido')?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/ico.png">
    <title>Assinador de PDF</title>
    <link rel="stylesheet" href="assets/form.css">
  </head>
  <body>
    <h1>Assinador de PDF <span>Para certificados eletrônicos</span></h1>
    <form method="POST" id="form" enctype="multipart/form-data">
      <br>
      <div class="custom-file-upload">
        <label for="pdf">Arquivo PDF: </label>
        <input type="file" name="pdf" id="pdf" accept="application/pdf">
      </div>
      <p class="alerta"><?=$arquivos['pdf']['erros']?></p>
      <?php if($arquivos['p12']['info'] == "sem-config") { ?>
        <p class="alerta">
          Arquivo de configuração do pyhanko não encontrado.<br>
          Para utilizar assinatura eletrônica, verifique as instruções no
          <a href="https://github.com/mauricioeluri/assinador-pdf" class="simple-link">
            repositório deste software
          </a>.<br>
      <?php } else { ?>
      <br>
      <div class="custom-file-upload">
        <label for="p12">
          (Opcional)
          <?=($arquivos['p12']['info'] == "assinatura-fixa") ? " Alterar" : ""?>
          Assinatura Eletrônica:
        </label>
        <input type="file" name="p12" id="p12" accept="application/x-pkcs12">
      </div>
      <p class="alerta"><?=$arquivos['p12']['erros']?></p>
      <label class="container" for="manter-assinatura">
        Manter assinatura salva
        <input type="checkbox" id="manter-assinatura">
        <span class="checkmark"></span>
      </label>
      <input type="hidden" value="0" name="acao-assinatura" id="acao-assinatura">
      <?php if($arquivos['p12']['info'] == "assinatura-fixa") { ?>
      <button type="button" class="file-upload-button submit btn-alerta" id="btn-excluir" onclick="excluir()">Excluir assinatura salva</button>
      <br><br><br><br>
      <?php } } ?>
      <input type="submit" class="file-upload-button submit" value="Enviar">
    </form>
    <script src="assets/tools/jquery-3.5.1.min.js"></script>
    <script src="assets/form.js"></script>
  </body>
</html>