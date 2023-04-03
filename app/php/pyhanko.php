<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pdf']) && isset($_POST['coordenadas']) ) {
        $comando = 'python3 pyhanko --verbose --config ../signature/pyhanko.yml sign addsig --field Sig1 --field ' .
            $_POST['coordenadas'] . '/DLK-SIGNATURE pkcs12 --p12-setup p12dlk ../upload/' .
            $_POST['pdf'] . '.pdf ../output/' . $_POST['pdf'] . '.pdf';
        exec($comando, $output, $return_var);
        if ($return_var == 0) {
            limpaPastas();
           header('Location: ../output/' . $_POST['pdf'] . '.pdf');
        } else {
            echo "Houve um erro durante a geração do seu PDF.<br />
            Por favor, verifique se o seu arquivo de configuração do pyhanko está configurado corretamente.";
        }
    } else {
        echo "Por favor, reinicie a página e tente novamente.";
    }
} else {
    exit('Acesso direto não permitido');
}


/**
 * Por motivos de segurança, as pastas são limpas a cada vez que o formulário é aberto.
 * Só ficam os arquivos directory.txt e a assinatura fixa.
 * Na pasta signature são permitidos outros arquivos, tendo em vista que podem fazer parte da assinatura.
*/
function limpaPastas() {
    shell_exec("find " . getcwd() . "/../signature/*.p12 -type f -not -name 'assinatura-fixa.p12' -delete");
    shell_exec("find " . getcwd() . "/../upload/ -type f -not -name 'directory.txt' -delete");
}