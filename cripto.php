<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CriptoZap - Chat</title>
</head>
<body>
    <header>
        <h1><strong><em>CriptoZap Chat</em></strong></h1>
    </header>
    <section id="body">
        <div id="caixa">
            <h3>Enviar Mensagem</h3>
            <form action="" method="post">
                <input type="text" name="mensagem" placeholder="Digite sua mensagem" required>
                <button type="submit">Enviar</button>
            </form>
        </div>

        <div id="mensagens">
            <h3>Mensagens</h3>
            <?php

            $host = 'localhost'; 
            $dbname = 'banco_php'; 
            $username = getenv('DB_USERNAME'); 
            $password_db = getenv('DB_PASSWORD'); 

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password_db);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }

            function encrypt($data, $key) {
                $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
                $encrypted = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
                return base64_encode($iv . $encrypted);
            }

            function decrypt($data, $key) {
                $data = base64_decode($data);
                $iv_length = openssl_cipher_iv_length('AES-256-CBC');
                $iv = substr($data, 0, $iv_length);
                $encrypted = substr($data, $iv_length);
                return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, $iv);
            }

            $key = 'sua-chave-secreta-aqui';

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensagem'])) {
                $mensagem = $_POST['mensagem'];
                $mensagemCriptografada = encrypt($mensagem, $key);

                try {
                    $sql = "INSERT INTO mensagensCriptografadas (mensagem_criptografada, data) VALUES (:mensagem_criptografada, NOW())";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':mensagem_criptografada', $mensagemCriptografada);
                    $stmt->execute();
                } catch (PDOException $e) {
                    die("Erro ao inserir mensagem: " . $e->getMessage());
                }
            }

            try {
                $sql = "SELECT mensagem_criptografada FROM mensagensCriptografadas ORDER BY data DESC";
                $stmt = $pdo->query($sql);
                $mensagens = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($mensagens as $msg) {
                    $mensagemCriptografadaFromDb = $msg['mensagem_criptografada'];
                    $mensagemDescriptografada = decrypt($mensagemCriptografadaFromDb, $key);
                    echo "<div class='mensagem'><strong>Criptografada:</strong> " . htmlspecialchars($mensagemCriptografadaFromDb) . "<br><strong>Descriptografada:</strong> " . htmlspecialchars($mensagemDescriptografada) . "</div>";
                }
            } catch (PDOException $e) {
                die("Erro ao buscar mensagens: " . $e->getMessage());
            }
            ?>
        </div>
    </section>
</body>
</html>
