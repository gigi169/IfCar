<?php

require_once "auth.php";
require_once "conexaoBD.php";

$idUsuario = (int) $_SESSION["Idusuario"];

function contarRegistrosDoPerfil(mysqli $conn, string $sql, int $idUsuario): int
{
    $consulta = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($consulta, "i", $idUsuario);
    mysqli_stmt_execute($consulta);
    $resultado = mysqli_stmt_get_result($consulta);
    $registro = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($consulta);

    return (int) $registro["total"];
}

$caronasOferecidas = contarRegistrosDoPerfil(
    $conn,
    "SELECT COUNT(*) AS total
    FROM caronas
    WHERE IDusuario = ? AND categoria = 'oferecendo'",
    $idUsuario
);
$pedidosPublicados = contarRegistrosDoPerfil(
    $conn,
    "SELECT COUNT(*) AS total
    FROM caronas
    WHERE IDusuario = ? AND categoria = 'pedindo'",
    $idUsuario
);
$reservasConfirmadas = contarRegistrosDoPerfil(
    $conn,
    "SELECT COUNT(*) AS total
    FROM solicitacoes
    WHERE IDusuario = ? AND Status = 'confirmada'",
    $idUsuario
);

$consultaPublicacoes = mysqli_prepare(
    $conn,
    "SELECT ID, Enderecosaida, Enderecodestino, Data, Hora, Numeropassageiros, categoria
    FROM caronas
    WHERE IDusuario = ?
    ORDER BY Data DESC, Hora DESC"
);
mysqli_stmt_bind_param($consultaPublicacoes, "i", $idUsuario);
mysqli_stmt_execute($consultaPublicacoes);
$publicacoes = mysqli_stmt_get_result($consultaPublicacoes);

$consultaReservas = mysqli_prepare(
    $conn,
    "SELECT
        solicitacoes.ID,
        solicitacoes.Status,
        caronas.ID AS IDcarona,
        caronas.Enderecosaida,
        caronas.Enderecodestino,
        caronas.Data,
        caronas.Hora,
        usuarios.Nomeusuario
    FROM solicitacoes
    INNER JOIN caronas ON caronas.ID = solicitacoes.IDcarona
    INNER JOIN usuarios ON usuarios.ID = caronas.IDusuario
    WHERE solicitacoes.IDusuario = ?
    ORDER BY caronas.Data DESC, caronas.Hora DESC"
);
mysqli_stmt_bind_param($consultaReservas, "i", $idUsuario);
mysqli_stmt_execute($consultaReservas);
$reservas = mysqli_stmt_get_result($consultaReservas);

include "header.php";

$usuario = [

    'nome' => $_SESSION['Nomeusuario'] ?? 'Maria da Silva',

    'email' => $_SESSION['Emailusuario'] ?? 'maria@email.com',

    'Telefoneusuario' => $_SESSION['Telefoneusuario'] ?? '(42) 99999-9999',
];

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link
        rel="stylesheet"
        href="assets/style.css"
    >

    <title>Meu Perfil - IFCAR</title>

</head>

<body>

<div class="container">

    <div class="main-card">

        <?php if (($_GET["sucesso"] ?? "") === "reservaCancelada"): ?>
            <div class="verification">
                <div class="verification-icon">✓</div>
                <div>
                    <strong>Reserva cancelada</strong>
                    <p>A vaga foi devolvida para a carona.</p>
                </div>
            </div>
        <?php elseif (($_GET["erro"] ?? "") === "reservaInvalida"): ?>
            <div class="verification">
                <div class="verification-icon">!</div>
                <div>
                    <strong>Reserva indisponível</strong>
                    <p>Não foi possível localizar a reserva selecionada.</p>
                </div>
            </div>
        <?php endif; ?>


        <!-- =================================
             CABEÇALHO DO PERFIL
        ================================== -->

        <div class="profile-header">

            <div class="profile-avatar">

                <?php

                echo strtoupper(
                    substr(
                        $usuario['nome'],
                        0,
                        1
                    )
                );

                ?>

            </div>


            <div class="profile-title">

                <h1>
                    Meu Perfil
                </h1>

                <p>
                    Gerencie suas informações no IFCAR.
                </p>

            </div>

        </div>


        <!-- =================================
             INFORMAÇÕES DA CONTA
        ================================== -->

        <div class="section">

            <h2 class="section-title">
                Informações da conta
            </h2>


            <form
                action="actionperfil.php"
                method="POST"
            >

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
                            value="<?php
                                echo htmlspecialchars(
                                    $usuario['nome']
                                );
                            ?>"
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
                            value="<?php
                                echo htmlspecialchars(
                                    $usuario['email']
                                );
                            ?>"
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
                            value="<?php
                                echo htmlspecialchars(
                                    $usuario['Telefoneusuario']
                                );
                            ?>"
                            required
                        >

                    </div>

                </div>


                <!-- BOTÃO -->

                <button
                    type="submit"
                    class="search-button"
                >
                    Salvar alterações
                </button>

            </form>

        </div>


        <!-- =================================
             RESUMO DO USUÁRIO
        ================================== -->

        <div class="section">

            <h2 class="section-title">
                Resumo da minha conta
            </h2>


            <div class="profile-stats">


                <div class="profile-stat">

                    <strong>
                        <?= $caronasOferecidas ?>
                    </strong>

                    <span>
                        Caronas oferecidas
                    </span>

                </div>


                <div class="profile-stat">

                    <strong>
                        <?= $pedidosPublicados ?>
                    </strong>

                    <span>
                        Pedidos publicados
                    </span>

                </div>


                <div class="profile-stat">

                    <strong>
                        <?= $reservasConfirmadas ?>
                    </strong>

                    <span>
                        Reservas confirmadas
                    </span>

                </div>

            </div>

        </div>

        <div class="section">

            <h2 class="section-title">
                Minhas publicações
            </h2>

            <?php if (mysqli_num_rows($publicacoes) > 0): ?>
                <?php while ($publicacao = mysqli_fetch_assoc($publicacoes)): ?>
                    <table class="request-table">
                        <tr>
                            <td>
                                <strong><?= $publicacao["categoria"] === "oferecendo" ? "Carona oferecida" : "Pedido de carona" ?></strong>
                                <p><?= htmlspecialchars($publicacao["Enderecosaida"]) ?> → <?= htmlspecialchars($publicacao["Enderecodestino"]) ?></p>
                                <p><?= htmlspecialchars($publicacao["Data"]) ?> às <?= htmlspecialchars(substr($publicacao["Hora"], 0, 5)) ?></p>
                                <p><?= htmlspecialchars($publicacao["Numeropassageiros"]) ?> <?= $publicacao["categoria"] === "oferecendo" ? "vaga(s) disponível(is)" : "passageiro(s)" ?></p>
                                <a href="detalhes-carona.php?id=<?= $publicacao["ID"] ?>">Ver detalhes</a>
                            </td>
                        </tr>
                    </table>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Você ainda não publicou caronas ou pedidos.</p>
            <?php endif; ?>

        </div>

        <div class="section">

            <h2 class="section-title">
                Minhas reservas
            </h2>

            <?php if (mysqli_num_rows($reservas) > 0): ?>
                <?php while ($reserva = mysqli_fetch_assoc($reservas)): ?>
                    <table class="request-table">
                        <tr>
                            <td>
                                <strong>Carona de <?= htmlspecialchars($reserva["Nomeusuario"]) ?></strong>
                                <p><?= htmlspecialchars($reserva["Enderecosaida"]) ?> → <?= htmlspecialchars($reserva["Enderecodestino"]) ?></p>
                                <p><?= htmlspecialchars($reserva["Data"]) ?> às <?= htmlspecialchars(substr($reserva["Hora"], 0, 5)) ?></p>
                                <p>Status: <?= htmlspecialchars(ucfirst($reserva["Status"])) ?></p>
                                <a href="detalhes-carona.php?id=<?= $reserva["IDcarona"] ?>">Ver detalhes</a>
                                <form action="cancelar-solicitacao.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $reserva["ID"] ?>">
                                    <button type="submit" class="details-button">Cancelar reserva</button>
                                </form>
                            </td>
                        </tr>
                    </table>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Você ainda não possui reservas confirmadas.</p>
            <?php endif; ?>

        </div>

        <!-- =================================
             SAIR
        ================================== -->

        <div class="profile-logout">

            <a href="logout.php">
                Sair da minha conta
            </a>

        </div>


    </div>

</div>

</body>

</html>