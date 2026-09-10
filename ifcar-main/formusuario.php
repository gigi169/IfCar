<?php
$mensagensErro = [
    "nomeInvalido" => "Informe um nome usando apenas letras.",
    "telefoneInvalido" => "Informe um telefone.",
    "emailInvalido" => "Utilize seu e-mail institucional IFPR.",
    "senhasDiferentes" => "As senhas informadas não são iguais.",
    "emailDuplicado" => "Este e-mail já possui uma conta.",
];

include "header.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/style.css">

    <title>Criar conta - Carona+</title>
</head>

<body>

    <div class="container">

        <div class="search-box">

            <?php if (isset($mensagensErro[$_GET["erro"] ?? ""])): ?>
                <div class="verification">
                    <div class="verification-icon">!</div>
                    <div>
                        <strong>Não foi possível criar a conta</strong>
                        <p><?= htmlspecialchars($mensagensErro[$_GET["erro"]]) ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- TÍTULO -->
            <div class="title-area">

                <div>
                    <h1>🚗 Criar sua conta</h1>
                    <p>Cadastre-se para começar a usar o IfCar</p>
                </div>

            </div>


            <!-- FORMULÁRIO -->
            <form
                action="actionusuario.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <!-- DADOS PESSOAIS -->
                <div class="section">

                    <h2 class="section-title">
                        Dados pessoais
                    </h2>

                    <div class="locations">

                        <!-- NOME -->
                        <div>

                            <label for="Nomeusuario">
                                Nome Completo
                            </label>

                            <input
                                type="text"
                                id="Nomeusuario"
                                name="Nomeusuario"
                                placeholder="Digite seu nome completo"
                                required
                            >

                        </div>


                        <!-- EMAIL -->
                        <div>

                            <label for="Emailusuario">
                                Email
                            </label>

                            <input
                                type="email"
                                id="Emailusuario"
                                name="Emailusuario"
                                placeholder="seuemail@estudantes.ifpr.edu.br"
                                pattern="[a-zA-Z0-9._%+-]+@estudantes\.ifpr\.edu\.br$"
                                required
                            >

                        </div>


                        <!-- TELEFONE -->
                        <div>

                            <label for="Telefoneusuario">
                                Telefone
                            </label>

                            <input
                                type="tel"
                                id="Telefoneusuario"
                                name="Telefoneusuario"
                                placeholder="Digite seu telefone"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- SENHA -->
                <div class="section">

                    <h2 class="section-title">
                        Segurança
                    </h2>

                    <div class="locations">

                        <!-- SENHA -->
                        <div>

                            <label for="Senhausuario">
                                Senha
                            </label>

                            <input
                                type="password"
                                id="Senhausuario"
                                name="Senhausuario"
                                placeholder="Digite sua senha"
                                required
                            >

                        </div>


                        <!-- CONFIRMAR SENHA -->
                        <div>

                            <label for="Confirmarsenhausuario">
                                Confirme a Senha
                            </label>

                            <input
                                type="password"
                                id="Confirmarsenhausuario"
                                name="Confirmarsenhausuario"
                                placeholder="Confirme sua senha"
                                required
                            >

                        </div>

                    </div>

                </div>


                <!-- BOTÃO -->
                <button
                    type="submit"
                    class="search-button"
                >
                    Cadastrar
                </button>

            </form>


            <!-- LOGIN -->
            <div class="section">

                <p>
                    Já possui uma conta?
                    <a href="login.php">
                        Entrar
                    </a>
                </p>

            </div>

        </div>

    </div>

</body>
</html>