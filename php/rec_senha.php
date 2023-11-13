<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/estilo.css" />
    <title>Verifique seu Email</title>
</head>

<body>

</body>

</html>

<?php
session_start();

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    include_once 'conexao.php';

    // Verificar se o email existe no banco de dados
    $conn = "SELECT * FROM motorista WHERE email = '$email'";
    $result = $sql->query($conn);

    if ($result->num_rows > 0) {
        // Gerar um token único para a redefinição de senha
        $token = bin2hex(random_bytes(16));

        // Armazenar o token temporariamente na variável de sessão
        $_SESSION['reset_token'] = $token;

        require '../PHPMailer/PHPMailer.php';
        require '../PHPMailer/Exception.php';
        require '../PHPMailer/SMTP.php';

        // Configurações do servidor de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Definir o nível de depuração para exibir informações detalhadas
        $mail->Host = 'smtp.gmail.com'; // Insira o host do servidor de email.
        $mail->Port = 465; // Insira a porta do servidor de email. SSL: 465. TLS: 587
        $mail->SMTPAuth = true;
        $mail->Username = 'transfast1006@gmail.com'; // Insira o seu endereço de email
        $mail->Password = 'ithcjbaxewmmxjsq'; // Insira a senha do seu email
        $mail->SMTPSecure = 'ssl'; // Caso necessário, altere para 'tls'

        // Configurações do email
        $mail->setFrom('transfast1006@gmail.com', 'Equipe Transfast'); // Insira o remetente
        $mail->addAddress($email); // Adicionar o endereço do destinatário
        $mail->Subject = 'Redefinir senha'; // Insira o assunto do email
        $mail->Body = 'Olá! Para redefinir sua senha, clique no link a seguir: http://localhost/transfast/php/alt_senha.php'; //. urlencode($email) . '&token=' . urlencode($token); // Insira o corpo do email

        try {
            if ($mail->send()) {
                echo 'Um email foi enviado para o endereço fornecido. Por favor, verifique sua caixa de entrada.';
            } else {
                echo 'O email não foi enviado. Erro: ' . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo 'Ocorreu um erro no envio do email: ' . $e->getMessage();
        }
    } else {
        echo 'O email fornecido não existe no banco de dados.';
    }

    // Fechar a conexão com o banco de dados
    $sql->close();
}
?>