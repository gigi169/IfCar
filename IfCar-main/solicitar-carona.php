<?php

require_once "auth.php";
require_once "conexaoBD.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$idCarona = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
if (!$idCarona) {
    header("Location: index.php?erro=caronaInvalida");
    exit;
}

$idUsuario = (int) $_SESSION["Idusuario"];
mysqli_begin_transaction($conn);

try {
    $buscarCarona = mysqli_prepare(
        $conn,
        "SELECT IDusuario, Numeropassageiros
        FROM caronas
        WHERE ID = ?
        FOR UPDATE"
    );
    mysqli_stmt_bind_param($buscarCarona, "i", $idCarona);
    mysqli_stmt_execute($buscarCarona);
    $resultadoCarona = mysqli_stmt_get_result($buscarCarona);
    $carona = mysqli_fetch_assoc($resultadoCarona);
    mysqli_stmt_close($buscarCarona);

    if (!$carona) {
        mysqli_rollback($conn);
        header("Location: index.php?erro=caronaInvalida");
        exit;
    }

    if ((int) $carona["IDusuario"] === $idUsuario) {
        mysqli_rollback($conn);
        header("Location: index.php?erro=propriaCarona");
        exit;
    }

    if ((int) $carona["Numeropassageiros"] < 1) {
        mysqli_rollback($conn);
        header("Location: index.php?erro=semVagas");
        exit;
    }

    $buscarReserva = mysqli_prepare(
        $conn,
        "SELECT ID
        FROM solicitacoes
        WHERE IDcarona = ? AND IDusuario = ?
        LIMIT 1"
    );
    mysqli_stmt_bind_param($buscarReserva, "ii", $idCarona, $idUsuario);
    mysqli_stmt_execute($buscarReserva);
    $resultadoReserva = mysqli_stmt_get_result($buscarReserva);
    $reservaExistente = mysqli_fetch_assoc($resultadoReserva);
    mysqli_stmt_close($buscarReserva);

    if ($reservaExistente) {
        mysqli_rollback($conn);
        header("Location: index.php?erro=reservaExistente");
        exit;
    }

    $criarReserva = mysqli_prepare(
        $conn,
        "INSERT INTO solicitacoes (IDcarona, IDusuario, Status)
        VALUES (?, ?, 'confirmada')"
    );
    mysqli_stmt_bind_param($criarReserva, "ii", $idCarona, $idUsuario);
    mysqli_stmt_execute($criarReserva);
    mysqli_stmt_close($criarReserva);

    $ocuparVaga = mysqli_prepare(
        $conn,
        "UPDATE caronas
        SET Numeropassageiros = Numeropassageiros - 1
        WHERE ID = ? AND Numeropassageiros > 0"
    );
    mysqli_stmt_bind_param($ocuparVaga, "i", $idCarona);
    mysqli_stmt_execute($ocuparVaga);
    $vagaOcupada = mysqli_stmt_affected_rows($ocuparVaga) === 1;
    mysqli_stmt_close($ocuparVaga);

    if (!$vagaOcupada) {
        mysqli_rollback($conn);
        header("Location: index.php?erro=semVagas");
        exit;
    }

    mysqli_commit($conn);
    header("Location: index.php?sucesso=caronaSolicitada");
    exit;
} catch (Throwable $erro) {
    mysqli_rollback($conn);
    throw $erro;
}
