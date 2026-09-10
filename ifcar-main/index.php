<?php

require_once "auth.php";

/* ==========================================
   CONEXÃO COM O BANCO
========================================== */

include "conexaoBD.php";

$mensagensSucesso = [
    "caronaSolicitada" => "Reserva confirmada. Uma vaga foi ocupada.",
];
$mensagensErro = [
    "caronaInvalida" => "A carona selecionada não está disponível.",
    "propriaCarona" => "Você não pode solicitar a própria carona.",
    "semVagas" => "Esta carona não possui vagas disponíveis.",
    "reservaExistente" => "Você já possui uma reserva nesta carona.",
];


/* ==========================================
   BUSCAR PEDIDOS DE CARONA
   categoria = pedindo
========================================== */

$sqlPedidos = "
    SELECT
        caronas.ID,
        caronas.IDusuario,
        caronas.Enderecosaida,
        caronas.Enderecodestino,
        caronas.Numeropassageiros,
        caronas.Data,
        caronas.Hora,
        caronas.categoria,

        usuarios.Nomeusuario,
        usuarios.Emailusuario,
        usuarios.Telefoneusuario

    FROM caronas

    INNER JOIN usuarios
        ON caronas.IDusuario = usuarios.ID

    WHERE caronas.categoria = 'pedindo'

    ORDER BY caronas.Data ASC, caronas.Hora ASC
";


$resultadoPedidos = mysqli_query($conn, $sqlPedidos);


/* Verificar erro */

if (!$resultadoPedidos) {

    die(
        "Erro ao buscar pedidos de carona: " .
        mysqli_error($conn)
    );

}


/* ==========================================
   BUSCAR CARONAS OFERECIDAS
   categoria = oferecendo
========================================== */

$sqlOfertas = "
    SELECT
        caronas.ID,
        caronas.IDusuario,
        caronas.Enderecosaida,
        caronas.Enderecodestino,
        caronas.Numeropassageiros,
        caronas.Data,
        caronas.Hora,
        caronas.categoria,

        usuarios.Nomeusuario,
        usuarios.Emailusuario,
        usuarios.Telefoneusuario

    FROM caronas

    INNER JOIN usuarios
        ON caronas.IDusuario = usuarios.ID

    WHERE caronas.categoria = 'oferecendo'

    ORDER BY caronas.Data ASC, caronas.Hora ASC
";


$resultadoOfertas = mysqli_query($conn, $sqlOfertas);


/* Verificar erro */

if (!$resultadoOfertas) {

    die(
        "Erro ao buscar caronas oferecidas: " .
        mysqli_error($conn)
    );

}


include "header.php";

?>


<!DOCTYPE html>

<html lang="pt-BR">


<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>IFCar - Caronas</title>


    <link
        rel="stylesheet"
        href="assets/style.css"
    >


    <style>


        /* ==========================================
           CONTAINER PRINCIPAL
        ========================================== */

        .container {

            width: 100%;
            max-width: none;

            margin: 30px 0;

            padding: 0 25px;

            box-sizing: border-box;

        }


        .main-card {

            width: 100%;

        }


        /* ==========================================
           DUAS COLUNAS
        ========================================== */

        .main-card .duas-colunas {

            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 80px;

            width: 100%;

        }


        .main-card .duas-colunas > .coluna {

            width: 100%;

            min-width: 0;

        }


        /* ==========================================
           TÍTULO
        ========================================== */

        .title-area {

            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 25px;

        }


        .title-area h1 {

            font-size: 23px;

            margin: 0 0 10px 0;

            color: #243447;

        }


        .title-area p {

            margin: 0;

            color: #6b7280;

        }


        /* ==========================================
           BOTÃO PUBLICAR
        ========================================== */

        .publish-button {

            background: #2f6949;

            color: white;

            border: none;

            border-radius: 6px;

            padding: 12px 18px;

            cursor: pointer;

            font-weight: bold;

        }


        .publish-button:hover {

            opacity: 0.9;

        }


        /* ==========================================
           CARD DA CARONA
        ========================================== */

        .request-table {

            width: 100%;

            border-collapse: separate;

            border-spacing: 0;

            margin-bottom: 18px;

            border: 1px solid #d9d9d9;

            border-radius: 10px;

            overflow: hidden;

            background: white;

        }


        .request-table td {

            padding: 14px;

        }


        /* ==========================================
           CABEÇALHO DO USUÁRIO
        ========================================== */

        .request-header {

            display: flex;

            justify-content: space-between;

            align-items: center;

        }


        .user {

            display: flex;

            align-items: center;

            gap: 12px;

        }


        .avatar {

            width: 42px;

            height: 42px;

            border-radius: 50%;

            display: flex;

            justify-content: center;

            align-items: center;

            background: #e1efea;

            color: #2f6949;

            font-weight: bold;

            font-size: 18px;

        }


        .user-name {

            font-weight: bold;

            color: #243447;

        }


        .student {

            background: #e7f0ec;

            color: #2f6949;

            padding: 7px 12px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;

        }


        /* ==========================================
           ORIGEM E DESTINO
        ========================================== */

        .location {

            width: 45%;

            border: 1px solid #dedede;

            border-radius: 8px;

        }


        .location small {

            display: block;

            color: #6b7280;

            margin-bottom: 8px;

            font-size: 11px;

        }


        .location strong {

            display: block;

            color: #243447;

        }


        .arrow {

            width: 10%;

            text-align: center;

            color: #2f6949;

            font-size: 22px;

        }


        /* ==========================================
           INFORMAÇÕES
        ========================================== */

        .request-info {

            display: flex;

            gap: 18px;

            border-top: 1px solid #eeeeee;

            padding-top: 14px;

            color: #4b5563;

            font-size: 14px;

        }


        /* ==========================================
           RODAPÉ / BOTÕES
        ========================================== */

        .request-footer {

            display: flex;

            justify-content: flex-end;

            gap: 12px;

        }


        .details-button {

            background: white;

            color: #2f6949;

            border: 1px solid #2f6949;

            border-radius: 6px;

            padding: 10px 15px;

            cursor: pointer;

        }


        .offer-button {

            background: #2f6949;

            color: white;

            border: none;

            border-radius: 6px;

            padding: 10px 15px;

            cursor: pointer;

            font-weight: bold;

        }


        /* ==========================================
           SEM CARONAS
        ========================================== */

        .sem-caronas {

            text-align: center;

            padding: 30px;

            border: 1px solid #dddddd;

            border-radius: 10px;

            color: #777;

        }


        /* ==========================================
           RESPONSIVIDADE
        ========================================== */

        @media (max-width: 900px) {


            .main-card .duas-colunas {

                grid-template-columns: 1fr;

                gap: 30px;

            }


        }


    </style>


</head>


<body>


<div class="container">


    <div class="main-card">

        <?php if (isset($mensagensSucesso[$_GET["sucesso"] ?? ""])): ?>
            <div class="verification">
                <div class="verification-icon">✓</div>
                <div>
                    <strong>Reserva realizada</strong>
                    <p><?= htmlspecialchars($mensagensSucesso[$_GET["sucesso"]]) ?></p>
                </div>
            </div>
        <?php elseif (isset($mensagensErro[$_GET["erro"] ?? ""])): ?>
            <div class="verification">
                <div class="verification-icon">!</div>
                <div>
                    <strong>Não foi possível concluir</strong>
                    <p><?= htmlspecialchars($mensagensErro[$_GET["erro"]]) ?></p>
                </div>
            </div>
        <?php endif; ?>


        <div class="duas-colunas">


            <!-- ======================================
                 COLUNA ESQUERDA
                 PEDIDOS DE CARONA
            ======================================= -->

            <div class="coluna">


                <div class="title-area">


                    <div>

                        <h1>
                            Alunos Precisando de Carona
                        </h1>

                        <p>
                            Encontre estudantes que estão procurando uma carona.
                        </p>

                    </div>


                    <a href="pedir-carona.php">

                        <button
                            type="button"
                            class="publish-button"
                        >
                            + Publicar pedido
                        </button>

                    </a>


                </div>


                <!-- ======================================
                     VERIFICAR SE EXISTEM PEDIDOS
                ======================================= -->

                <?php if (mysqli_num_rows($resultadoPedidos) > 0): ?>


                    <?php while ($request = mysqli_fetch_assoc($resultadoPedidos)): ?>


                        <table class="request-table">


                            <!-- CABEÇALHO -->

                            <tr>


                                <td colspan="3">


                                    <div class="request-header">


                                        <div class="user">


                                            <!-- AVATAR -->

                                            <div class="avatar">

                                                <?= strtoupper(
                                                    substr(
                                                        $request['Nomeusuario'],
                                                        0,
                                                        1
                                                    )
                                                ) ?>

                                            </div>


                                            <!-- NOME -->

                                            <div class="user-name">

                                                <?= htmlspecialchars(
                                                    $request['Nomeusuario']
                                                ) ?>

                                            </div>


                                        </div>


                                        <span class="student">

                                            ESTUDANTE

                                        </span>


                                    </div>


                                </td>


                            </tr>


                            <!-- ORIGEM / DESTINO -->

                            <tr>


                                <!-- ORIGEM -->

                                <td class="location">


                                    <small>
                                        ORIGEM
                                    </small>


                                    <strong>

                                        📍

                                        <?= htmlspecialchars(
                                            $request['Enderecosaida']
                                        ) ?>

                                    </strong>


                                </td>


                                <!-- SETA -->

                                <td class="arrow">

                                    →

                                </td>


                                <!-- DESTINO -->

                                <td class="location">


                                    <small>
                                        DESTINO
                                    </small>


                                    <strong>

                                        📍

                                        <?= htmlspecialchars(
                                            $request['Enderecodestino']
                                        ) ?>

                                    </strong>


                                </td>


                            </tr>


                            <!-- INFORMAÇÕES -->

                            <tr>


                                <td colspan="3">


                                    <div class="request-info">


                                        <!-- DATA -->

                                        <span>

                                            📅

                                            <?= date(
                                                "d/m/Y",
                                                strtotime(
                                                    $request['Data']
                                                )
                                            ) ?>

                                        </span>


                                        <!-- HORA -->

                                        <span>

                                            🕐

                                            <?= substr(
                                                $request['Hora'],
                                                0,
                                                5
                                            ) ?>

                                        </span>


                                        <!-- PASSAGEIROS -->

                                        <span>

                                            👥

                                            <?= htmlspecialchars(
                                                $request['Numeropassageiros']
                                            ) ?>

                                            passageiro(s)

                                        </span>


                                    </div>


                                </td>


                            </tr>


                            <!-- BOTÕES -->

                            <tr>


                                <td colspan="3">


                                    <div class="request-footer">

                                        <a
                                            href="detalhes-carona.php?id=<?= $request['ID'] ?>"
                                        >

                                            <button
                                                type="button"
                                                class="details-button"
                                            >

                                                Ver detalhes

                                            </button>

                                        </a>


                                        <a
                                                href="formcarona.php?pedido=<?= $request['ID'] ?>"
                                        >


                                            <button
                                                type="button"
                                                class="offer-button"
                                            >

                                                🚗 Oferecer carona

                                            </button>


                                        </a>


                                    </div>


                                </td>


                            </tr>


                        </table>


                    <?php endwhile; ?>


                <?php else: ?>


                    <p class="sem-caronas">

                        Nenhum aluno está procurando carona no momento.

                    </p>


                <?php endif; ?>


            </div>



            <div class="coluna">


                <div class="title-area">


                    <div>


                        <h1>
                            Caronas Oferecidas
                        </h1>


                        <p>
                            Encontre estudantes que estão oferecendo carona.
                        </p>


                    </div>


                    <a href="formcarona.php">


                        <button
                            type="button"
                            class="publish-button"
                        >

                            + Oferecer carona

                        </button>


                    </a>


                </div>


                <!-- ======================================
                     VERIFICAR SE EXISTEM OFERTAS
                ======================================= -->

                <?php if (mysqli_num_rows($resultadoOfertas) > 0): ?>


                    <?php while ($ride = mysqli_fetch_assoc($resultadoOfertas)): ?>


                        <table class="request-table">


                            <!-- CABEÇALHO -->

                            <tr>


                                <td colspan="3">


                                    <div class="request-header">


                                        <div class="user">


                                            <!-- AVATAR -->

                                            <div class="avatar">


                                                <?= strtoupper(
                                                    substr(
                                                        $ride['Nomeusuario'],
                                                        0,
                                                        1
                                                    )
                                                ) ?>


                                            </div>


                                            <!-- NOME -->

                                            <div class="user-name">


                                                <?= htmlspecialchars(
                                                    $ride['Nomeusuario']
                                                ) ?>


                                            </div>


                                        </div>


                                        <span class="student">

                                            MOTORISTA

                                        </span>


                                    </div>


                                </td>


                            </tr>


                            <!-- ORIGEM / DESTINO -->

                            <tr>


                                <!-- ORIGEM -->

                                <td class="location">


                                    <small>
                                        ORIGEM
                                    </small>


                                    <strong>

                                        📍

                                        <?= htmlspecialchars(
                                            $ride['Enderecosaida']
                                        ) ?>

                                    </strong>


                                </td>


                                <!-- SETA -->

                                <td class="arrow">

                                    →

                                </td>


                                <!-- DESTINO -->

                                <td class="location">


                                    <small>
                                        DESTINO
                                    </small>


                                    <strong>

                                        📍

                                        <?= htmlspecialchars(
                                            $ride['Enderecodestino']
                                        ) ?>

                                    </strong>


                                </td>


                            </tr>


                            <!-- INFORMAÇÕES -->

                            <tr>


                                <td colspan="3">


                                    <div class="request-info">


                                        <!-- DATA -->

                                        <span>

                                            📅

                                            <?= date(
                                                "d/m/Y",
                                                strtotime(
                                                    $ride['Data']
                                                )
                                            ) ?>

                                        </span>


                                        <!-- HORA -->

                                        <span>

                                            🕐

                                            <?= substr(
                                                $ride['Hora'],
                                                0,
                                                5
                                            ) ?>

                                        </span>


                                        <!-- VAGAS -->

                                        <span>

                                            🚗

                                            <?= htmlspecialchars(
                                                $ride['Numeropassageiros']
                                            ) ?>

                                            vaga(s)

                                        </span>


                                    </div>


                                </td>


                            </tr>


                            <!-- BOTÕES -->

                            <tr>


                                <td colspan="3">


                                    <div class="request-footer">

                                        <a
                                            href="detalhes-carona.php?id=<?= $ride['ID'] ?>"
                                        >

                                            <button
                                                type="button"
                                                class="details-button"
                                            >

                                                Ver detalhes

                                            </button>

                                        </a>


                                        <?php if ((int) $ride['Numeropassageiros'] > 0): ?>
                                            <form action="solicitar-carona.php" method="POST">
                                                <input type="hidden" name="id" value="<?= $ride['ID'] ?>">
                                                <button
                                                    type="submit"
                                                    class="offer-button"
                                                >

                                                    🙋 Solicitar carona

                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span>Sem vagas disponíveis</span>
                                        <?php endif; ?>


                                    </div>


                                </td>


                            </tr>


                        </table>


                    <?php endwhile; ?>


                <?php else: ?>


                    <p class="sem-caronas">

                        Nenhuma carona foi oferecida no momento.

                    </p>


                <?php endif; ?>


            </div>


        </div>


    </div>


</div>


</body>


</html>