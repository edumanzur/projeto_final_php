CriptoZap
CriptoZap é um sistema de chat simples que permite aos usuários criptografar e descriptografar suas mensagens de forma segura. O sistema utiliza PHP para o back-end e MySQL para armazenar os dados de usuários e mensagens. O CriptoZap oferece autenticação de usuários, criptografia de mensagens e uma interface intuitiva para uso.

Funcionalidades
Autenticação de Usuário: Os usuários podem registrar suas contas e fazer login com credenciais seguras.
Criptografia de Mensagens: As mensagens podem ser criptografadas usando o algoritmo AES-256-CBC.
Descriptografia de Mensagens: Os usuários podem descriptografar suas mensagens criptografadas.
Histórico de Mensagens: As mensagens criptografadas dos usuários são armazenadas no banco de dados e podem ser visualizadas a qualquer momento.
Pré-requisitos
Antes de começar, certifique-se de ter os seguintes itens instalados em seu ambiente de desenvolvimento:

PHP (versão 7.4 ou superior)
MySQL (ou MariaDB)
Servidor Apache (ou similar, como XAMPP)
Composer (opcional, para instalação de pacotes PHP)
Configuração do Banco de Dados
Crie um banco de dados MySQL chamado banco_php.
Execute o seguinte SQL para criar a tabela de usuários e de mensagens:
sql
Copiar código
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha_criptografada VARCHAR(255) NOT NULL
);

CREATE TABLE mensagensCriptografadas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mensagem_criptografada TEXT NOT NULL,
    user_id INT NOT NULL,
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id)
);
Atualize as credenciais de conexão com o banco de dados no arquivo login.php e cripto.php conforme necessário:
php
Copiar código
$host = 'localhost'; 
$dbname = 'banco_php'; 
$username = 'root'; 
$password_db = 'SUA_SENHA'; 
Instalação
Clone o repositório:
bash
Copiar código
git clone https://github.com/seu-usuario/criptozap.git
Navegue até a pasta do projeto:
bash
Copiar código
cd criptozap
Se estiver usando Composer, execute:
bash
Copiar código
composer install
Execute o projeto em seu servidor Apache local (ou similar). Acesse o aplicativo por meio do navegador, normalmente em:
arduino
Copiar código
http://localhost/criptozap/
Uso
Registro e Login
Registro: Insira seu email e senha para criar uma nova conta de usuário.
Login: Insira seu email e senha registrados para acessar a aplicação.
Criptografar e Descriptografar Mensagens
Na página principal após o login (cripto.php), você pode criptografar uma mensagem digitando-a no campo "Digite sua mensagem para criptografar".
Para descriptografar uma mensagem, insira o texto criptografado no campo "Digite a mensagem criptografada para descriptografar".
As mensagens criptografadas são armazenadas no banco de dados e exibidas na tela para referência.

Tecnologias Utilizadas
PHP: Linguagem de back-end principal.
MySQL: Banco de dados para armazenamento de usuários e mensagens.
HTML/CSS: Estrutura e design da interface do usuário.
AES-256-CBC: Algoritmo de criptografia usado para proteger as mensagens.
Segurança
As senhas dos usuários são armazenadas de forma segura usando password_hash() e password_verify().
As mensagens são criptografadas utilizando a chave secreta definida no arquivo cripto.php. Por questões de segurança, essa chave deve ser mantida em segredo e nunca exposta em repositórios públicos.
Contribuições
Contribuições são bem-vindas! Sinta-se à vontade para fazer um fork deste repositório e enviar pull requests com melhorias ou correções.

Faça um fork do projeto.
Crie uma branch para a sua feature:
bash
Copiar código
git checkout -b minha-feature
Commit suas mudanças:
bash
Copiar código
git commit -m 'Adiciona minha nova feature'
Faça um push para a branch:
bash
Copiar código
git push origin minha-feature
Abra um Pull Request.
Licença
Este projeto está licenciado sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.
