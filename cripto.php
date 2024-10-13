<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

$host = 'localhost'; 
$dbname = 'banco_php'; 
$username = 'root'; 
$password = '04100411LuBo!'; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

function encrypt($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
    $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

$key = 'sua-chave-secreta-aqui'; 
$message = 'Mensagem secreta!';


$encryptedMessage = encrypt($message, $key);


$sql = "INSERT INTO mensagenscriptografadas (mensagem_criptografada, data) VALUES (:mensagem_criptografada, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':mensagem_criptografada', $encryptedMessage);
$stmt->execute();

echo "Mensagem Criptografada: " . $encryptedMessage;
echo "<br>ID da mensagem no MySQL: " . $pdo->lastInsertId();

function decrypt($data, $key) {
    $data = base64_decode($data);
    $iv_length = openssl_cipher_iv_length('AES-256-CBC');
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
}

$sql = "SELECT mensagem_criptografada FROM mensagenscriptografadas ORDER BY data DESC LIMIT 1";
$stmt = $pdo->query($sql);
$document = $stmt->fetch(PDO::FETCH_ASSOC);

if ($document) {
    $encryptedMessageFromDb = $document['mensagem_criptografada'];


    $decryptedMessage = decrypt($encryptedMessageFromDb, $key);

    echo "<br>Mensagem Descriptografada: " . $decryptedMessage;
} else {
    echo "<br>Nenhuma mensagem encontrada no banco de dados.";
}

?>

</body>
</html>
