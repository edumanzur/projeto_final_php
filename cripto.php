<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
function encrypt($data, $key) {
    // Gera um vetor de inicialização (IV) aleatório
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    // Criptografa os dados
    $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
    // Retorna o IV e os dados criptografados, ambos codificados em base64
    return base64_encode($iv . $encrypted);
}

// Exemplo de uso
$key = 'sua-chave-secreta-aqui'; // Deve ter 32 bytes para AES-256
$message = 'Mensagem secreta!';
$encryptedMessage = encrypt($message, $key);

echo "Mensagem Criptografada: " . $encryptedMessage;
?>
<?php
function decrypt($data, $key) {
    // Decodifica os dados de base64
    $data = base64_decode($data);
    // Extrai o IV do início dos dados decodificados
    $iv_length = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    // Descriptografa os dados
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}

// Exemplo de uso
$decryptedMessage = decrypt($encryptedMessage, $key);
echo "Mensagem Descriptografada: " . $decryptedMessage;
?>

</body>
</html>
