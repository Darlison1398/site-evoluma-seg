<?php


// error_reporting(E_ALL);
// ini_set('display_error', 1);

include_once(__DIR__ . '/../../core.php');
include_once(__DIR__ . '/../../db-adm.php');



$schema = file_get_contents(__DIR__ . '/../../../schema.js');

$schema = preg_replace("/^export\s+default\n+/", "", $schema, 1);


$schema = json_decode($schema, true);


Header('Access-Control-Allow-Origin: *');
Header('Content-Type: application/json');
Header('Access-Control-Allow-Method: POST');

$json = ['ok' => false, 'data' => [], 'err' => 'Ops, algo deu errado, tente atualizar a página.', 'total' => 0];

if (!logado(1)) {
    $json['err'] = "Não autenticado ou não possui a permissão necessária. Por favor, fale com o administrador.";
    echo json_encode($json);
    exit(1);
}



// Verifica se a extensão ZipArchive está disponível
if (!extension_loaded('zip')) {
    $response = array(
        'error' => 'A extensão ZipArchive não está habilitada no seu servidor.'
    );
    echo json_encode($response);
} else {
    // Caminho da pasta que você deseja compactar
    $folderPath = '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads';

    // Nome do arquivo ZIP a ser gerado
    $zipFileName = 'backup-uploads-' . date('Y-m-d h_i_s') . '.zip';

    // Tenta criar um novo objeto ZipArchive
    try {
        $zip = new ZipArchive();

        // Abre o arquivo ZIP para escrita
        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            // Recursivamente adiciona arquivos e pastas à compactação
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folderPath));
            foreach ($files as $file) {
                if (!$file->isDir()) {
                    // Caminho real do arquivo
                    $filePath = $file->getRealPath();

                    // Caminho relativo dentro do arquivo ZIP
                    $relativePath = substr($filePath, strlen($folderPath) - 2);

                    // Adiciona o arquivo ao ZIP
                    $zip->addFile($filePath, $relativePath);
                }
            }

            // Fecha o arquivo ZIP
            $zip->close();

            // Define os cabeçalhos para o download
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
            header('Content-Length: ' . filesize($zipFileName));

            // Lê e envia o arquivo ZIP ao cliente
            readfile($zipFileName);

            // Exclui o arquivo ZIP temporário após o download
            unlink($zipFileName);
        } else {
            $response = array(
                'error' => 'Erro ao criar o arquivo ZIP.'
            );
            echo json_encode($response);
        }
    } catch (Exception $e) {
        $response = array(
            'error' => 'Erro ao criar o arquivo ZIP: ' . $e->getMessage()
        );
        echo json_encode($response);
    }
}
?>