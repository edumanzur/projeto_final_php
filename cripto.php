<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Geração de um par de chaves
$chave = openssl_pkey_new([
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
]);

// Verifica se a chave foi gerada com sucesso
if ($chave === false) {
    die('Erro ao gerar chave: ' . openssl_error_string());
}

// Extraindo a chave privada
if (!openssl_pkey_export($chave, $chave_privada)) {
    die('Erro ao exportar chave privada: ' . openssl_error_string());
}

// Extraindo a chave pública
$chave_publica = openssl_pkey_get_details($chave)["key"];

// Mensagem original
$menssagem = "Lute contra a tecnocracia";

// Encriptação
if (!openssl_public_encrypt($menssagem, $texto_encriptado, $chave_publica)) {
    die('Erro ao encriptar a mensagem: ' . openssl_error_string());
}

// Exibe o texto encriptado em formato Base64
echo "Texto encriptado: " . base64_encode($texto_encriptado) . "\n";

// Descriptografia
if (!openssl_private_decrypt($texto_encriptado, $menssagem_decriptada, $chave_privada)) {
    die('Erro ao descriptografar a mensagem: ' . openssl_error_string());
}

// Mostra a mensagem original
echo "Mensagem decriptada: " . $menssagem_decriptada . "\n";
?>

</body>
</html>
