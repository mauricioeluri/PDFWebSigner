<?php

if (   !(isset($_FILES['pdf']) &&
        isset($_FILES['p12']) &&
        isset($_FILES['senha-p12']) &&
        isset($_FILES['coordenadas']))) {
    return "Por favor, verifique se a senha foi inserida. Se isto não funcionar, reenvie o formulário inicial novamente.";
}

$comando = 'pyhanko sign addsig --field Sig1 --field ' . 
$_FILES['coordenadas'] . '/DLK-SIGNATURE --style-name dlk-unihacker pkcs12 ' . 
$_FILES['pdf'] . ' output.pdf ' .
$_FILES['p12'];

return shell_exec($comando);
