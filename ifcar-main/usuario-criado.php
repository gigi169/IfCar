<?php
session_start();

$cadastro = $_SESSION["cadastro_sucesso"] ?? null;
unset($_SESSION["cadastro_sucesso"]);

if (!$cadastro) {
    header("Location: formusuario.php");
    exit;
}

include "header.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Conta criada - IfCar</title>
</head>
<body>
    <div class="container">
        <div class="search-box success-page">
            <div class="success-hero">
                <div class="success-icon">✓</div>
                <div>
                    <h1>Conta criada com sucesso!</h1>
                    <p>Seu cadastro no IfCar foi concluído.</p>
                </div>
            </div>

            <p class="success-message">
                Agora você já pode entrar na sua conta e utilizar as caronas.
            </p>

            <div class="section account-section">
                <h2 class="section-title">Dados cadastrados</h2>
                <div class="account-details">
                    <div class="account-detail">
                        <span>Nome</span>
                        <strong><?= htmlspecialchars($cadastro["nome"], ENT_QUOTES, "UTF-8") ?></strong>
                    </div>
                    <div class="account-detail">
                        <span>E-mail</span>
                        <strong><?= htmlspecialchars($cadastro["email"], ENT_QUOTES, "UTF-8") ?></strong>
                    </div>
                </div>
            </div>

            <div class="success-actions">
                <a class="primary-button" href="login.php">Entrar na minha conta</a>
                <a class="secondary-button" href="index.php">Voltar ao início</a>
            </div>
        </div>
    </div>
</body>
</html>
