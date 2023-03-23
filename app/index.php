<?php

if (isset($_FILES['pdf'])) {
  $status['pdf'] = upload_file();
  require 'php/editor.php';
} else {
  $status['pdf']['info'] = "";
  $status['pdf']['errors'] = "";
  require 'php/form.php';
}

function upload_file(){
  $uploadDirectory = getcwd().'/upload/';
  $fileName =  substr(md5(rand().rand()), 0, 8).'.pdf';
  $uploadPath = $uploadDirectory . basename($fileName);
  $status = [];
  
  //Verifica se o arquivo foi enviado
  if ($_FILES['pdf']['size'] > 0) {
    //Verifica se o formato do arquivo está correto
    if (strcmp($_FILES['pdf']['type'], "application/pdf") !== 0) {
      $status['errors'] = "Extensão não permitida. Por favor, envie um arquivo <b>pdf</b>.<br />";
    }
    //Tamanho máximo - 20mb
    if ($_FILES['pdf']['size'] > 20000000) {
      $status['errors'] .= "O arquivo excede o limite de 20MB.<br />";
    }
    //Se não tiver erros, faz o upload
    if (empty($errors)) {
      $didUpload = move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadPath);
      if ($didUpload) {
        $status['info'] = "<span style='color:#28a745'>O arquivo foi enviado.</span>";
        $status['filename'] = basename($fileName);
      } else {
        $status['errors'] .= "Verifique se existe um diretório chamado /upload/ e se as permissões corretas foram definidas.";     
      }
    }
  } else {
    $status['info'] = "Você não enviou o arquivo.";
  }
  return $status;
}