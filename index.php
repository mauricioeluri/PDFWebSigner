<?php

    $uploadDirectory = getcwd().'/upload/';
    $errors = [];
    $pdfName =  substr(md5(rand().rand()), 0, 8).'.pdf';

    
    $uploadPath = $uploadDirectory . basename($pdfName); 
    if (isset($_FILES['pdf'])) {
      if (strcmp($_FILES['pdf']['type'], "application/pdf") !== 0) {
        $errors['pdf'] .= "Extensão não permitida. Por favor, envie um arquivo pdf.<br />";
      } if ($fileSize > 20000000) {
        $errors['pdf'] .= "O arquivo excede o limite de 20MB.<br />";
      } if (empty($errors)) {
        $didUpload = move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadPath);
       
        if ($didUpload) {
           $errors['pdf'] .= "O arquivo <b>" . basename($pdfName) . "</b> foi enviado";
        } else {
          $errors['pdf'] .= "Houve um erro no envio do arquivo.<br />";
          $errors['pdf'] .= "Verifique se existe um diretório chamado /upload/ e se as permissões corretas foram definidas.";     
        }
      }
    }
    require 'form.php';
