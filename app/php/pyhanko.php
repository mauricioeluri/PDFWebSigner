<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pdf']) && isset($_POST['coordenadas']) ) {
        echo "Por favor, reinicie a página e tente novamente.";
    } else {
        $comando = 'python3 pyhanko --verbose --config ../signature/pyhanko.yml sign addsig --field Sig1 --field ' .
            $_POST['coordenadas'] . '/DLK-SIGNATURE pkcs12 --p12-setup p12dlk ../upload/' .
            $_POST['pdf'] . '.pdf ../output/' . $_POST['pdf'] . '.pdf';
        exec($comando, $output, $return_var);
        if ($return_var == 0) {
            header('Location: ../output/' . $_POST['pdf'] . 'pdf');
        } else {
            echo "Houve um erro durante a geração do seu PDF";
        }
    }
} else {
    exit('Acesso direto não permitido');
}