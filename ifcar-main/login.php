<?php
if (isset($_GET['erroLogin'])) {

    $erroLogin = $_GET['erroLogin'];

    if ($erroLogin == 'dadosInvalidos') {
        echo "<div class='verification'>";
        echo "<div class='verification-icon'>⚠️</div>";
        echo "<div>";
        echo "<strong>Erro no login</strong>";
        echo "<p>EMAIL ou SENHA inválidos!</p>";
        echo "</div>";
        echo "</div>";
    }
}
?>

<?php include "header.php"; ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/style.css">

    <title>Entrar - IfCar</title>
</head>

<body>

    <div class="container">

        <div class="search-box">

            <!-- TÍTULO -->
            <div class="title-area">

                <div>
                    <h1>Bem-vindo de volta</h1>
                    <p>Conecte-se a sua conta</p>
                </div>

            </div>


            <!-- FORMULÁRIO -->
            <form action="actionlogin.php" method="POST">

                <div class="section">

                    <div class="locations">

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

                    </div>


                    <!-- BOTÃO -->
                    <button
                        type="submit"
                        class="search-button"
                    >
                        Entrar
                    </button>

                </div>

            </form>


            <!-- CADASTRO -->
            <div class="section">

                <p>
                    Ainda não possui conta?
                    <a href="formusuario.php">
                        Criar conta
                    </a>
                </p>

            </div>

        </div>

    </div>

</body>
</html>