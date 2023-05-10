<?php

carregarPaginas();

function carregarPaginas() {
  if(isset($_POST['acao-assinatura'])){
    $arquivos = carregarArquivos();
    if((!strlen($arquivos['p12']['erros']) > 0) &&
       (!strlen($arquivos['pdf']['erros']) > 0)) {
      require 'php/editor.php';
      exit();
    }
  require 'php/form.php';
  exit();
  } else {
    formularioEmBranco();
  }
}

function formularioEmBranco() {
  $arquivos = array(
    'pdf'   => array(
      'erros' => ''
    ),
    'p12'   => array(
      'info'  => '',
      'erros' => ''
    )
  );
  $ass_fixa = file_exists(getcwd() . '/signature/assinatura-fixa.p12');
  if($ass_fixa) {
    $arquivos['p12']['info'] = 'assinatura-fixa';
  }
  limpaPastas();
  require 'php/form.php';
  exit();
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
  $erros = '';
  if (isset($_FILES[$extensao])) {
    if ($extensao == 'pdf') {
      if ($_FILES['pdf']['size'] <= 0) {
        return "Você não enviou o arquivo PDF.";
      }
    } else {
      if ($_FILES['p12']['size'] <= 0) {
        return FALSE;
      }
    }
    if ((strcmp($_FILES[$extensao]['type'], 'application/pdf') == 0) &&
        (strcmp($_FILES[$extensao]['type'], 'application/x-pkcs12') == 0)) {
      $erros = "Extensão não permitida. Por favor, envie um arquivo $extensao.<br />";
    }
    if ($_FILES[$extensao]['size'] > 20000000) {
      $erros .= 'O arquivo excede o limite de 20MB.<br />';
    }
    //Testando se o arquivo é válido
    if (strcmp($_FILES[$extensao]['type'], 'application/pdf') == 0) {
      $arquivo = file_get_contents($_FILES[$extensao]['tmp_name']);
      if (!preg_match("/^%PDF-/", $arquivo)) {
        $erros .= 'Arquivo PDF inválido! Revise seu arquivo e tente novamente.<br />';
      }
    }
  } 
  return $erros;
}

function verificarPdf($pdf_upload_erros) {
  if (isset($_FILES['pdf'])) {
    if ($pdf_upload_erros == "") {
      return salvarArquivo($_FILES['pdf'], 'pdf');
    }
  } return array('erros' => $pdf_upload_erros);
}

/**
 * Verifica qual ação tomar em relação à assinatura
 */
function verificarAssinatura($p12_upload_erros){
  $opcao = null;
  $ass_fixa = file_exists(getcwd().'/signature/assinatura-fixa.p12');
  $arquivo = array (
    'info' => '',
    'erros' => ''
  );
  if ($p12_upload_erros === FALSE) {
    $arquivo['info'] = '0';
    return $arquivo;
  }
  if (isset($_POST['acao-assinatura'])) {
    $opcao = $_POST['acao-assinatura'];
  }
  //Se tem erro no upload, não tem arquivo, logo, se usa a fixa.
  if ($p12_upload_erros != '') {
    if ($ass_fixa) {
      $arquivo['info'] = 'assinatura-fixa';
      if ($opcao == "excluir") {
        excluirAssinatura();
        formularioEmBranco();
      }
      //Não enviou arquivo e vai usar a fixa.
      //Cria cópia da fixa para uso temporário.
      shell_exec("cp " . getcwd() . "/signature/assinatura-fixa.p12 " . getcwd() . "/signature/assinatura.p12");
      return $arquivo;
    } else {
      //Não enviou arquivo e nem possui fixa, retorna os erros do upload.
      $arquivo['erros'] = $p12_upload_erros;
      return $arquivo;
    }
  } else {
    //Foi enviado um arquivo com sucesso
    if ($ass_fixa) {
      excluirAssinatura();
    }
    if ($opcao == 'manter') {
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
    'info'      => '',
    'filename'  => '',
    'erros'     => ''
  );
  $pasta = 'upload';
  if ($tipo == 'p12') {
    $pasta = 'signature';
    if($nome == null) {
      $nome = 'assinatura';
    }
  } else {
    $nome = substr(md5(rand().rand()), 0, 8);
  }
  $caminho = getcwd() . '/' . $pasta . '/' . $nome . '.' . $tipo;
  $sucesso = move_uploaded_file($arquivo['tmp_name'], $caminho);
  if ($sucesso) {
    if ($nome == 'assinatura-fixa') {
      //Caso o usuário salve uma assinatura fixa, o software cria uma cópia para uso na geração do pdf assinado.
      //Esta cópia é necessária, pois o arquivo de configuração do pyhanko é fixo. Ou seja,
      //cria a cópia, assina e deleta a cópia.
      shell_exec("cp " . getcwd() . "/signature/assinatura-fixa.p12 " . getcwd() . "/signature/assinatura.p12");
    }
    $status['filename'] = basename($nome);
  } else {
    $status['erros'] = 'Verifique se as permissões corretas das pastas de upload foram definidas.';
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