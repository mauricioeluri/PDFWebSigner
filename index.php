<?php

  if (isset($_FILES['pdf']) || isset($_FILES['p12'])) {
    $errors['pdf'] = upload_file('pdf');
    $errors['p12'] = upload_file('p12');
  }
  require 'form.php';

  function upload_file($fileType = ''){
    $uploadDirectory = getcwd().'/upload/';
    $fileName =  substr(md5(rand().rand()), 0, 8).'e.'.$fileType;
    $uploadPath = $uploadDirectory . basename($fileName);
    $errors = [];
  
    // Teste se o tipo dos arquivos está correto
    if (isset($_FILES[$fileType])) {
      if(strcmp($fileType, 'pdf') == 0){
        if (strcmp($_FILES[$fileType]['type'], "application/pdf") !== 0) {
          $errors[$fileType] .= "Extensão não permitida. Por favor, envie um arquivo $fileType.<br />";
        }
      }
      if (strcmp($fileType, 'p12') == 0){
        if (strcmp($_FILES[$fileType]['type'], "application/x-pkcs12") !== 0) {
          $errors[$fileType] .= "Extensão não permitida. Por favor, envie um arquivo $fileType.<br />";
        }
      }

    //Tamanho máximo - 20mb
    if ($_FILES[$fileType]['size'] > 20000000) {
      $errors[$fileType] .= "O arquivo excede o limite de 20MB.<br />";
    }
    
    //Se não tiver erros, faz o upload
    if (empty($errors)) {
      $didUpload = move_uploaded_file($_FILES[$fileType]['tmp_name'], $uploadPath);
      
      if ($didUpload) {
          $errors[$fileType] .= "O arquivo <b>" . basename($fileName) . "</b> foi enviado";
      } else {
        $errors[$fileType] .= "Houve um erro no envio do arquivo.<br />";
        $errors[$fileType] .= "Verifique se existe um diretório chamado /upload/ e se as permissões corretas foram definidas.";     
      }
    }
  } else {
    $errors[$fileType] .= "Você não enviou o arquivo $fileType";
  }

  return $errors[$fileType];
}