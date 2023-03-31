<?php

if (isset($_FILES['pdf']) || isset($_FILES['p12'])) {
  $status['pdf'] = upload_file('pdf');
  $status['p12'] = upload_file('p12');

  //Se o envio das duas variáveis for um sucesso
  if (!empty($status['pdf']['filename']) &&
      !empty($status['p12']['filename'])) {
    require 'php/editor.php';
  } else {
    require 'php/form.php';
  }
} else {
  $status['pdf']['info'] = "";
  $status['pdf']['errors'] = "";
  $status['p12']['info'] = "";
  $status['p12']['errors'] = "";
  require 'php/form.php';
}

function upload_file($fileType = ''){
  $uploadDirectory = getcwd().'/upload/';
  $fileName =  substr(md5(rand().rand()), 0, 8).'e.'.$fileType;
  $uploadPath = $uploadDirectory . basename($fileName);
  $status = [];
  $status['errors'] = '';
  //Verifica se o arquivo foi enviado
  if ($_FILES[$fileType]['size'] > 0) {
    //Verifica se o formato do arquivo está correto
    if(strcmp($fileType, 'pdf') == 0){
      if (strcmp($_FILES[$fileType]['type'], "application/pdf") !== 0) {
        $status['errors'] = "Extensão não permitida. Por favor, envie um arquivo $fileType.<br />";
      }
    }
    if (strcmp($fileType, 'p12') == 0){
      if (strcmp($_FILES[$fileType]['type'], "application/x-pkcs12") !== 0) {
        $status['errors'] = 'Extensão não permitida. Por favor, envie um arquivo '.$fileType.'<br />'.var_dump($_FILES);
      }
    }

  //Tamanho máximo - 20mb
  if ($_FILES[$fileType]['size'] > 20000000) {
    $status['errors'] .= "O arquivo excede o limite de 20MB.<br />";
  }
  
  //Se não tiver erros, faz o upload
  if (empty($errors)) {
    $didUpload = move_uploaded_file($_FILES[$fileType]['tmp_name'], $uploadPath);
    
    if ($didUpload) {
      $status['info'] = "<span style='color:#28a745'>O arquivo <b>" . $fileType . "</b> foi enviado.</span>";
      $status['filename'] = basename($fileName);
    } else {
      $status['errors'] .= "Verifique se existe um diretório chamado /upload/ e se as permissões corretas foram definidas.";     
    }
  }
} else {
  $status['info'] = "Você não enviou o arquivo <b>$fileType</b>.";
}
return $status;
}