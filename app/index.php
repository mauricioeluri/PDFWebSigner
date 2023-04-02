<?php

carregarPaginas();

function carregarPaginas() {
  if(isset($_POST['acao-assinatura'])){
    $arquivos = carregarArquivos();
    if(!isset($arquivos['p12']['erros']) && !isset($arquivos['pdf']['erros'])) {
      require 'php/editor.php';
      exit();
    }
  } else {
    formularioEmBranco();
  }
}

function formularioEmBranco() {
  $arquivos = array(
    "pdf"   => array(
      "erros"  => ""
    ),
    "p12"   => array(
      "info"    => "",
      "erros"  => "")
  );
  $ass_fixa = file_exists(getcwd().'/signature/assinatura-fixa.p12');
  if($ass_fixa) {
    $arquivos['p12']['info'] = "assinatura-fixa";
  }
  limpaPastas();
  require 'php/form.php';
}

function carregarArquivos() {
  $p12_upload_erros = validarArquivo('p12');
  $arquivos['p12']  = verificarAssinatura($p12_upload_erros);
  $pdf_upload_erros = validarArquivo('pdf');
  $arquivos['pdf']  = verificarPdf($pdf_upload_erros);
  return $arquivos;
}

/**
 * Verifica se os arquivos foram enviados corretamente
 */
function validarArquivo($extensao) {
  $erros = null;
  if (isset($_FILES[$extensao])) {
    
    if ($_FILES[$extensao]['size'] > 0) {
      if ((strcmp($_FILES[$extensao]['type'], "application/pdf") == 0) &&
          (strcmp($_FILES[$extensao]['type'], "application/x-pkcs12") == 0)) {
        $erros = "Extensão não permitida. Por favor, envie um arquivo $extensao.<br />";
      }
      if ($_FILES[$extensao]['size'] > 20000000) {
        $erros .= "O arquivo excede o limite de 20MB.<br />";
      }
    } else {
      $erros = "Você não enviou o arquivo $extensao.";
    }
  }
  return $erros;
}

function verificarPdf($pdf_upload_erros) {
  if (isset($_FILES['pdf'])) {
    if ($pdf_upload_erros == null) {
      return salvarArquivo($_FILES['pdf'], 'pdf');
    }
  } return array("erros" => $pdf_upload_erros);
}

/**
 * Verifica qual ação tomar em relação à assinatura
 */
function verificarAssinatura($p12_upload_erros){
  $opcao = null;
  $arquivo = array (
    "info" => "",
    "erros" => null
  );
  if (isset($_POST['acao-assinatura'])) {
    $opcao = $_POST['acao-assinatura'];
  }
  $ass_fixa = file_exists(getcwd().'/signature/assinatura-fixa.p12');
  //Se tem erro no upload, não tem arquivo, logo, se usa a fixa.
  if ($p12_upload_erros != null) {
    if ($ass_fixa) {
      $arquivo['info'] = "assinatura-fixa";
      if ($opcao == "excluir") {
        excluirAssinatura();
        formularioEmBranco();
      }
    } else {
      //Não enviou arquivo e nem possui fixa, retorna os erros do upload.
      $arquivo["erros"] = $p12_upload_erros;
      return $arquivo;
    }
  } else {
    //Foi enviado um arquivo com sucesso
    if ($ass_fixa) {
      excluirAssinatura();
    }
    if ($opcao == "manter") {
      return salvarArquivo($_FILES['p12'], 'p12', 'assinatura-fixa');
    }
    return salvarArquivo($_FILES['p12'], 'p12');
  }
}

function excluirAssinatura(){
  if(file_exists(getcwd().'/signature/assinatura-fixa.p12')){
    unlink(getcwd().'/signature/assinatura-fixa.p12');
  }
}

function salvarArquivo($arquivo, $tipo, $nome = null){
  $status = array(
    "info"      => "",
    "filename"  => "",
    "erros"     => null
  );
  $pasta = "upload";
  if ($tipo == "p12") {
    $pasta = "signature";
  }
  if($nome == null) {
    $nome = substr(md5(rand().rand()), 0, 8);
  }
  $caminho = getcwd() . '/' . $pasta . '/' . $nome . '.' . $tipo;
  $sucesso = move_uploaded_file($arquivo['tmp_name'], $caminho);
  if ($sucesso) {
    $status['filename'] = basename($nome);
  } else {
    $status['erros'] = "Verifique se as permissões corretas das pastas de upload foram definidas.";     
  }
  return $status;
}

/**
 * Por motivos de segurança, as pastas são limpas a cada vez que o formulário é aberto.
 * Só ficam os arquivos directory.txt e a assinatura fixa.
 * Na pasta signature são permitidos outros arquivos, tendo em vista que podem fazer parte da assinatura.
*/
function limpaPastas() {
  shell_exec("find " . getcwd() . "/signature/*.p12 -type f -not -name 'assinatura-fixa.p12' -delete");
  shell_exec("find " . getcwd() . "/upload/ -type f -not -name 'directory.txt' -delete");
  shell_exec("find " . getcwd() . "/output/ -type f -not -name 'directory.txt' -delete");
}