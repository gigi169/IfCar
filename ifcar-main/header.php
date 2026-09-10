<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/style.css" rel="stylesheet" />
        <title>IfCar - Caronas estudantis</title>

    </head>

    <body>
        <header class="header">

            <div class="logo">
             <img src="assets/img/logo.png">
            </div>

            <nav>
                <?php if(isset($_SESSION['Idusuario'])): ?>
                    <a href="index.php">Início</a>
                    <a href="pedir-carona.php">Pedir carona</a>
                    <a href="formcarona.php">Oferecer carona</a>
                    <a href="perfil.php">Meu perfil</a>
                    <a href="logout.php">Sair</a>
                <?php else: ?>
                    <a href="login.php">Entrar</a>
                    <a href="formusuario.php">Criar conta</a>
                <?php endif; ?>
            </nav>

        </header>
    </body>
</html>
