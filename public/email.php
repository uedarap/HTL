<?php
    header('Content-Type: application/json');

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $mensagem = $_POST['message'] ?? '';

        $destinatario = "seuemail@exemplo.com"; // Insira o email de destino aqui
        $assunto = "Nova mensagem do formulário de contato";
        
        $corpoEmail = "Nome: $nome\n";
        $corpoEmail .= "Email: $email\n";
        $corpoEmail .= "Mensagem:\n$mensagem\n";

        $headers = "From: $email" . "\r\n" .
                "Reply-To: $email" . "\r\n" .
                "X-Mailer: PHP/" . phpversion();

        if (mail($destinatario, $assunto, $corpoEmail, $headers)) {
            echo json_encode(["success" => true, "message" => "Email enviado com sucesso!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erro ao enviar o email."]);
        }
    }
?>
