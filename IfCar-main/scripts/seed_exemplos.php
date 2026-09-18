<?php

if (PHP_SAPI !== "cli") {
    http_response_code(403);
    exit("Este script deve ser executado somente pelo terminal.");
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "bootstrap.php";

function encontrarOuCriarUsuario(mysqli $conn, array $usuario): int
{
    $buscar = mysqli_prepare(
        $conn,
        "SELECT ID FROM usuarios WHERE Emailusuario = ? LIMIT 1"
    );
    mysqli_stmt_bind_param($buscar, "s", $usuario["email"]);
    mysqli_stmt_execute($buscar);
    $resultado = mysqli_stmt_get_result($buscar);
    $existente = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($buscar);

    if ($existente) {
        return (int) $existente["ID"];
    }

    $senha = md5($usuario["senha"]);
    $inserir = mysqli_prepare(
        $conn,
        "INSERT INTO usuarios
            (Nomeusuario, Emailusuario, Telefoneusuario, Senhausuario)
        VALUES (?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param(
        $inserir,
        "ssss",
        $usuario["nome"],
        $usuario["email"],
        $usuario["telefone"],
        $senha
    );
    mysqli_stmt_execute($inserir);
    $id = (int) mysqli_insert_id($conn);
    mysqli_stmt_close($inserir);

    return $id;
}

function criarCaronaSeNaoExistir(mysqli $conn, array $carona): bool
{
    $buscar = mysqli_prepare(
        $conn,
        "SELECT ID FROM caronas
        WHERE IDusuario = ?
        AND Enderecosaida = ?
        AND Enderecodestino = ?
        AND Data = ?
        AND Hora = ?
        AND categoria = ?
        LIMIT 1"
    );
    mysqli_stmt_bind_param(
        $buscar,
        "isssss",
        $carona["usuario"],
        $carona["origem"],
        $carona["destino"],
        $carona["data"],
        $carona["hora"],
        $carona["categoria"]
    );
    mysqli_stmt_execute($buscar);
    $resultado = mysqli_stmt_get_result($buscar);
    $existe = mysqli_fetch_assoc($resultado) !== null;
    mysqli_stmt_close($buscar);

    if ($existe) {
        return false;
    }

    $inserir = mysqli_prepare(
        $conn,
        "INSERT INTO caronas
            (IDusuario, Enderecosaida, Enderecodestino, Numeropassageiros, Data, Hora, categoria)
        VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    mysqli_stmt_bind_param(
        $inserir,
        "ississs",
        $carona["usuario"],
        $carona["origem"],
        $carona["destino"],
        $carona["passageiros"],
        $carona["data"],
        $carona["hora"],
        $carona["categoria"]
    );
    mysqli_stmt_execute($inserir);
    mysqli_stmt_close($inserir);

    return true;
}

$usuarios = [
    ["nome" => "Ana Souza", "email" => "ana.souza@estudantes.ifpr.edu.br", "telefone" => "42990000001", "senha" => "senha123"],
    ["nome" => "Bruno Lima", "email" => "bruno.lima@estudantes.ifpr.edu.br", "telefone" => "42990000002", "senha" => "senha123"],
    ["nome" => "Carla Mendes", "email" => "carla.mendes@estudantes.ifpr.edu.br", "telefone" => "42990000003", "senha" => "senha123"],
    ["nome" => "Diego Alves", "email" => "diego.alves@estudantes.ifpr.edu.br", "telefone" => "42990000004", "senha" => "senha123"],
    ["nome" => "Elisa Rocha", "email" => "elisa.rocha@estudantes.ifpr.edu.br", "telefone" => "42990000005", "senha" => "senha123"],
    ["nome" => "Felipe Costa", "email" => "felipe.costa@estudantes.ifpr.edu.br", "telefone" => "42990000006", "senha" => "senha123"],
    ["nome" => "Gabriela Nunes", "email" => "gabriela.nunes@estudantes.ifpr.edu.br", "telefone" => "42990000007", "senha" => "senha123"],
    ["nome" => "Henrique Silva", "email" => "henrique.silva@estudantes.ifpr.edu.br", "telefone" => "42990000008", "senha" => "senha123"],
    ["nome" => "Isabela Freitas", "email" => "isabela.freitas@estudantes.ifpr.edu.br", "telefone" => "42990000009", "senha" => "senha123"],
    ["nome" => "Joao Martins", "email" => "joao.martins@estudantes.ifpr.edu.br", "telefone" => "42990000010", "senha" => "senha123"],
];

$origens = [
    "Centro", "Vila Maria", "Jardim Paraiso", "Bela Vista", "Santa Rita",
    "Cem Casas", "Industrial", "Bandeirantes", "Jardim Europa", "Universitario",
];
$destinos = [
    "IFPR Campus", "Terminal Rodoviario", "Centro", "IFPR Campus", "Biblioteca",
    "IFPR Campus", "Shopping", "IFPR Campus", "Mercado Municipal", "IFPR Campus",
];

$conn = conectarBanco();
$criadas = ["usuarios" => 0, "ofertas" => 0, "pedidos" => 0];

mysqli_begin_transaction($conn);

try {
    $idsUsuarios = [];
    foreach ($usuarios as $usuario) {
        $idAntes = mysqli_prepare(
            $conn,
            "SELECT ID FROM usuarios WHERE Emailusuario = ? LIMIT 1"
        );
        mysqli_stmt_bind_param($idAntes, "s", $usuario["email"]);
        mysqli_stmt_execute($idAntes);
        $resultadoAntes = mysqli_stmt_get_result($idAntes);
        $jaExiste = mysqli_fetch_assoc($resultadoAntes) !== null;
        mysqli_stmt_close($idAntes);

        $idsUsuarios[] = encontrarOuCriarUsuario($conn, $usuario);
        if (!$jaExiste) {
            $criadas["usuarios"]++;
        }
    }

    $hoje = new DateTimeImmutable("today");
    for ($indice = 0; $indice < 10; $indice++) {
        $data = $hoje->modify("+" . ($indice + 1) . " days")->format("Y-m-d");
        $oferta = [
            "usuario" => $idsUsuarios[$indice],
            "origem" => $origens[$indice],
            "destino" => $destinos[$indice],
            "passageiros" => ($indice % 4) + 1,
            "data" => $data,
            "hora" => sprintf("%02d:00:00", 7 + ($indice % 4)),
            "categoria" => "oferecendo",
        ];
        if (criarCaronaSeNaoExistir($conn, $oferta)) {
            $criadas["ofertas"]++;
        }

        $pedido = [
            "usuario" => $idsUsuarios[($indice + 1) % 10],
            "origem" => $destinos[$indice],
            "destino" => $origens[$indice],
            "passageiros" => 1,
            "data" => $data,
            "hora" => sprintf("%02d:30:00", 12 + ($indice % 4)),
            "categoria" => "pedindo",
        ];
        if (criarCaronaSeNaoExistir($conn, $pedido)) {
            $criadas["pedidos"]++;
        }
    }

    mysqli_commit($conn);
} catch (Throwable $erro) {
    mysqli_rollback($conn);
    throw $erro;
}

printf(
    "Dados de exemplo prontos: %d usuarios, %d caronas oferecidas e %d pedidos inseridos.%s",
    $criadas["usuarios"],
    $criadas["ofertas"],
    $criadas["pedidos"],
    PHP_EOL
);
