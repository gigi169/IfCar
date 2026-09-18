<?php

require_once "auth.php";
require_once "conexaoBD.php";

$idCarona = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$idCarona) {
    header("Location: index.php");
    exit;
}

$consulta = mysqli_prepare(
    $conn,
    "SELECT
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
    INNER JOIN usuarios ON caronas.IDusuario = usuarios.ID
    WHERE caronas.ID = ?
    LIMIT 1"
);
mysqli_stmt_bind_param($consulta, "i", $idCarona);
mysqli_stmt_execute($consulta);
$resultado = mysqli_stmt_get_result($consulta);
$carona = mysqli_fetch_assoc($resultado);
mysqli_stmt_close($consulta);

if (!$carona) {
    header("Location: index.php");
    exit;
}

$propriaCarona = (int) $carona["IDusuario"] === (int) $_SESSION["Idusuario"];
$ehPedido = $carona["categoria"] === "pedindo";
$temVagas = (int) $carona["Numeropassageiros"] > 0;

include "header.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Detalhes da carona - IfCar</title>
</head>
<body>
    <div class="container">
        <div class="search-box">
            <div class="title-area">
                <div>
                    <h1><?= $ehPedido ? "Pedido de carona" : "Carona oferecida" ?></h1>
                    <p>Detalhes publicados por <?= htmlspecialchars($carona["Nomeusuario"]) ?></p>
                </div>
            </div>

            <div class="section">
                <div class="locations">
                    <div>
                        <label>Origem</label>
                        <p><?= htmlspecialchars($carona["Enderecosaida"]) ?></p>
                    </div>
                    <div>
                        <label>Destino</label>
                        <p><?= htmlspecialchars($carona["Enderecodestino"]) ?></p>
                    </div>
                    <div>
                        <label>Data e hora</label>
                        <p><?= htmlspecialchars($carona["Data"]) ?> às <?= htmlspecialchars(substr($carona["Hora"], 0, 5)) ?></p>
                    </div>
                    <div>
                        <label><?= $ehPedido ? "Passageiros" : "Vagas" ?></label>
                        <p><?= htmlspecialchars($carona["Numeropassageiros"]) ?></p>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2 class="section-title">Contato</h2>
                <p><strong><?= htmlspecialchars($carona["Nomeusuario"]) ?></strong></p>
                <p><?= htmlspecialchars($carona["Emailusuario"]) ?></p>
                <p><?= htmlspecialchars($carona["Telefoneusuario"]) ?></p>
            </div>

            <div class="request-footer">
                <a href="index.php"><button type="button" class="details-button">Voltar</button></a>
                <?php if (!$propriaCarona && $ehPedido): ?>
                    <a href="formcarona.php?pedido=<?= $carona["ID"] ?>"><button type="button" class="offer-button">Oferecer carona</button></a>
                <?php elseif (!$propriaCarona && $temVagas): ?>
                    <form action="solicitar-carona.php" method="POST">
                        <input type="hidden" name="id" value="<?= $carona["ID"] ?>">
                        <button type="submit" class="offer-button">Solicitar carona</button>
                    </form>
                <?php elseif (!$propriaCarona): ?>
                    <span>Esta carona não possui vagas disponíveis.</span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
