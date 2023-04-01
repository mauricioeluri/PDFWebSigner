<?php
if (! (isset($_POST['pdf']) && isset($_POST['coordenadas'])) ) {
    echo json_encode("Por favor, verifique se os dados foram enviados. Se isto não funcionar, reenvie o formulário inicial novamente.".$_FILES['coordenadas']['type'].$_FILES['pdf']);
} else {
    $comando = 'python3 pyhanko --verbose --config ../signature/pyhanko.yml sign addsig --field Sig1 --field ' .
        $_POST['coordenadas'] . '/DLK-SIGNATURE pkcs12 --p12-setup p12dlk ../upload/' .
        $_POST['pdf'] . ' ../output/' . $_POST['pdf'];
    exec($comando, $output, $return_var);
    if ($return_var == 0) {
        header('Location: ../output/' . $_POST['pdf']);
    } else {
        echo "Houve um erro durante a geração do seu PDF";
    }
}