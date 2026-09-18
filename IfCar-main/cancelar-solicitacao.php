<?php

require_once "auth.php";
require_once "conexaoBD.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: perfil.php");
    exit;
}

$idSolicitacao = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
if (!$idSolicitacao) {
    header("Location: perfil.php?erro=reservaInvalida");
    exit;
}

$idUsuario = (int) $_SESSION["Idusuario"];
mysqli_begin_transaction($conn);

try {
    $buscarReserva = mysqli_prepare(
        $conn,
        "SELECT solicitacoes.IDcarona, solicitacoes.Status
        FROM solicitacoes
        INNER JOIN caronas ON caronas.ID = solicitacoes.IDcarona
        WHERE solicitacoes.ID = ? AND solicitacoes.IDusuario = ?
        FOR UPDATE"
    );
    mysqli_stmt_bind_param($buscarReserva, "ii", $idSolicitacao, $idUsuario);
    mysqli_stmt_execute($buscarReserva);
    $resultado = mysqli_stmt_get_result($buscarReserva);
    $reserva = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($buscarReserva);

    if (!$reserva) {
        mysqli_rollback($conn);
        header("Location: perfil.php?erro=reservaInvalida");
        exit;
    }

    $removerReserva = mysqli_prepare(
        $conn,
        "DELETE FROM solicitacoes WHERE ID = ? AND IDusuario = ?"
    );
    mysqli_stmt_bind_param($removerReserva, "ii", $idSolicitacao, $idUsuario);
    mysqli_stmt_execute($removerReserva);
    mysqli_stmt_close($removerReserva);

    if ($reserva["Status"] === "confirmada") {
        $liberarVaga = mysqli_prepare(
            $conn,
            "UPDATE caronas
            SET Numeropassageiros = Numeropassageiros + 1
            WHERE ID = ?"
        );
        mysqli_stmt_bind_param($liberarVaga, "i", $reserva["IDcarona"]);
        mysqli_stmt_execute($liberarVaga);
        mysqli_stmt_close($liberarVaga);
    }

    mysqli_commit($conn);
    header("Location: perfil.php?sucesso=reservaCancelada");
    exit;
} catch (Throwable $erro) {
    mysqli_rollback($conn);
    throw $erro;
}
