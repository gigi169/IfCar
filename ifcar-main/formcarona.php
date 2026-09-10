<?php
require_once "auth.php";
require_once "conexaoBD.php";

$pedido = null;
$idPedido = filter_input(INPUT_GET, "pedido", FILTER_VALIDATE_INT);

if ($idPedido) {
    $consultaPedido = mysqli_prepare(
        $conn,
        "SELECT
            caronas.Enderecosaida,
            caronas.Enderecodestino,
            caronas.Data,
            caronas.Hora,
            caronas.Numeropassageiros,
            usuarios.Nomeusuario
        FROM caronas
        INNER JOIN usuarios ON usuarios.ID = caronas.IDusuario
        WHERE caronas.ID = ? AND caronas.categoria = 'pedindo'
        LIMIT 1"
    );
    mysqli_stmt_bind_param($consultaPedido, "i", $idPedido);
    mysqli_stmt_execute($consultaPedido);
    $resultadoPedido = mysqli_stmt_get_result($consultaPedido);
    $pedido = mysqli_fetch_assoc($resultadoPedido);
    mysqli_stmt_close($consultaPedido);
}

include "header.php";

// Dados de exemplo das caronas
$caronas = [];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="assets/style.css">

</head>

<body>

    <div class="container">

        <div class="search-box">

            <div class="section">

                <?php if (in_array($_GET["sucesso"] ?? "", ["1", "cadastrada"], true)): ?>
                    <div class="verification">
                        <div class="verification-icon">✓</div>
                        <div>
                            <strong>Carona publicada com sucesso!</strong>
                            <p>Ela já está disponível no painel para outros estudantes.</p>
                        </div>
                    </div>
                <?php elseif (($_GET["erro"] ?? "") === "dadosInvalidos"): ?>
                    <div class="verification">
                        <div class="verification-icon">!</div>
                        <div>
                            <strong>Dados inválidos</strong>
                            <p>Preencha todos os campos com data, hora e quantidade de vagas válidas.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($pedido): ?>
                    <div class="verification">
                        <div class="verification-icon">i</div>
                        <div>
                            <strong>Oferta para um pedido</strong>
                            <p>Os dados do pedido de <?= htmlspecialchars($pedido["Nomeusuario"]) ?> foram preenchidos para você.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="title-area">
                    <div>
                        <h1>Oferecer Carona</h1>
                        <p>Ofereça uma carona para outros estudantes</p>
                    </div>
                </div>

                <form
                    action="actioncarona.php?categoria=oferecendo"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    <!-- DADOS DO USUÁRIO -->
                    <div class="section">

                        <h2 class="section-title">Dados do usuário</h2>

                        <div class="locations">

                            <div>
                                <label for="Nomeusuario">
                                    Nome Completo
                                </label>

                                <input
                                    type="text"
                                    id="Nomeusuario"
                                    name="Nomeusuario"
                                    value="<?= htmlspecialchars($_SESSION["Nomeusuario"]) ?>"
                                    placeholder="Digite seu nome completo"
                                    readonly
                                    required
                                >
                            </div>

                        </div>

                    </div>


                    <!-- LOCALIZAÇÃO -->
                    <div class="section">

                        <h2 class="section-title">Localização</h2>

                        <div class="locations">

                            <div>
                                <label for="Enderecosaida">
                                    Endereço de saída
                                </label>

                                <input
                                    type="text"
                                    id="Enderecosaida"
                                    name="Enderecosaida"
                                    value="<?= htmlspecialchars($pedido["Enderecosaida"] ?? "") ?>"
                                    placeholder="Onde você vai sair?"
                                    required
                                >
                            </div>


                            <div>
                                <label for="Enderecodestino">
                                    Endereço de destino
                                </label>

                                <input
                                    type="text"
                                    id="Enderecodestino"
                                    name="Enderecodestino"
                                    value="<?= htmlspecialchars($pedido["Enderecodestino"] ?? "") ?>"
                                    placeholder="Para onde você vai?"
                                    required
                                >
                            </div>

                        </div>

                    </div>


                    <!-- DATA E HORÁRIO -->
                    <div class="section">

                        <h2 class="section-title">Data e horário</h2>

                        <div class="custom-date">

                            <div>
                                <label for="Caronadate">
                                    Data
                                </label>

                                <input
                                    type="date"
                                    id="Caronadate"
                                    name="Data"
                                    value="<?= htmlspecialchars($pedido["Data"] ?? "") ?>"
                                    required
                                >
                            </div>


                            <div>
                                <label for="Caronatime">
                                    Hora
                                </label>

                                <input
                                    type="time"
                                    id="Caronatime"
                                    name="Hora"
                                    value="<?= htmlspecialchars(isset($pedido["Hora"]) ? substr($pedido["Hora"], 0, 5) : "") ?>"
                                    required
                                >
                            </div>

                        </div>

                    </div>


                    <!-- PASSAGEIROS -->
                    <div class="section">

                        <h2 class="section-title">
                            Vagas disponíveis
                        </h2>

                        <div class="locations">

                            <div>

                                <label for="Numerocarona">
                                    Número de caronas disponíveis
                                </label>

                                <input
                                    type="number"
                                    id="Numerocarona"
                                    name="Numeropassageiros"
                                    value="<?= htmlspecialchars($pedido["Numeropassageiros"] ?? "") ?>"
                                    min="1"
                                    max="4"
                                    placeholder="Escolha de 1 a 4"
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
                        Oferecer Carona
                    </button>

                </form>

            </div>

        </div>

    </div>

</body>
</html>