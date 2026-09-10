<?php
require_once "auth.php";
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

                <?php if (in_array($_GET["sucesso"] ?? "", ["1", "cadastrado"], true)): ?>
                    <div class="verification">
                        <div class="verification-icon">✓</div>
                        <div>
                            <strong>Pedido publicado com sucesso!</strong>
                            <p>Ele já está disponível no painel para motoristas.</p>
                        </div>
                    </div>
                <?php elseif (($_GET["erro"] ?? "") === "dadosInvalidos"): ?>
                    <div class="verification">
                        <div class="verification-icon">!</div>
                        <div>
                            <strong>Dados inválidos</strong>
                            <p>Preencha todos os campos com data, hora e quantidade de passageiros válidas.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="title-area">
                    <div>
                        <h1>Pedir Carona</h1>
                        <p>Peça uma carona para outros estudantes</p>
                    </div>
                </div>

                <form
                    action="actioncarona.php?categoria=pedindo"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    <input type="hidden" name="Categoria" value="pedido">
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

                                <label for="Numeropassageiros">
                                    Número de passageiros disponíveis
                                </label>

                                <input
                                    type="number"
                                    id="Numeropassageiros"
                                    name="Numeropassageiros"
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
                        Pedir Carona
                    </button>

                </form>

            </div>

        </div>

    </div>

</body>
</html>