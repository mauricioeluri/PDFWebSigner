<?php if(count(get_included_files()) ==1) exit("Direct access not permitted."); ?>
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/ico.png" />
    <title>Assinador de PDF</title>
    <link rel="stylesheet" href="assets/form.css" />
  </head>

  <body translate="no">
    <h1>Assinador de PDF <span>Para certificados eletrônicos</span></h1>

    <form
      method="POST"
      enctype="multipart/form-data"
    >
    <br />
      <div class="custom-file-upload">
        <label for="file">Arquivo PDF: </label>
        <input
          type="file"
          name="pdf"
          accept="application/pdf"
          required
        />
      </div>
      <p class="alerta"><?= $errors['pdf'] ?></p>
      <br />
      <div class="custom-file-upload">
        <label for="file">Assinatura eletrônica: </label>
        <input type="file" name="p12" />
      </div>
      <p class="alerta"><?= $errors['p12'] ?></p>

      <input type="submit" class="file-upload-button submit" value="Enviar" />
    </form>
    <script src="assets/tools/jquery-3.5.1.min.js"></script>
    <script src="assets/form.js"></script>
  </body>
</html>