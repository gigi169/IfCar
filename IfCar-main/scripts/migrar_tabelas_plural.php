<?php

if (PHP_SAPI !== "cli") {
    http_response_code(403);
    exit("Este script deve ser executado somente pelo terminal.");
}

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . "bootstrap.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$config = configuracaoBanco();
$conn = mysqli_connect($config["host"], $config["usuario"], $config["senha"]);
mysqli_select_db($conn, $config["database"]);

function tabelaExiste(mysqli $conn, string $nome): bool
{
    $consulta = mysqli_prepare(
        $conn,
        "SELECT 1
        FROM information_schema.TABLES
        WHERE TABLE_SCHEMA = DATABASE()
        AND TABLE_NAME = ?
        LIMIT 1"
    );
    mysqli_stmt_bind_param($consulta, "s", $nome);
    mysqli_stmt_execute($consulta);
    $resultado = mysqli_stmt_get_result($consulta);
    $existe = mysqli_fetch_assoc($resultado) !== null;
    mysqli_stmt_close($consulta);

    return $existe;
}

$temUsuario = tabelaExiste($conn, "usuario");
$temCarona = tabelaExiste($conn, "carona");
$temUsuarios = tabelaExiste($conn, "usuarios");
$temCaronas = tabelaExiste($conn, "caronas");

if (!$temUsuario && !$temCarona) {
    if ($temUsuarios && $temCaronas) {
        exit("A migração já foi aplicada; nenhuma alteração foi feita." . PHP_EOL);
    }

    exit("Esquema incompleto. Execute o bootstrap ou restaure as tabelas antes de migrar." . PHP_EOL);
}

if ($temUsuarios || $temCaronas) {
    exit("Foram encontradas tabelas singulares e plurais. Nenhuma alteração foi feita para evitar perda de dados." . PHP_EOL);
}

if (!$temUsuario || !$temCarona) {
    exit("As tabelas singulares necessárias não estão completas. Nenhuma alteração foi feita." . PHP_EOL);
}

mysqli_query($conn, "RENAME TABLE usuario TO usuarios, carona TO caronas");

echo "Tabelas renomeadas com sucesso: usuario -> usuarios; carona -> caronas." . PHP_EOL;
