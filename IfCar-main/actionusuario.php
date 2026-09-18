<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$nomeUsuario = trim($_POST["Nomeusuario"] ?? "");
$telefoneUsuario = trim($_POST["Telefoneusuario"] ?? "");
$emailUsuario = trim($_POST["Emailusuario"] ?? "");
$senha = $_POST["Senhausuario"] ?? "";
$confirmarSenha = $_POST["Confirmarsenhausuario"] ?? "";

if ($nomeUsuario === "" || !preg_match('/^[\p{L} ]+$/u', $nomeUsuario)) {
    header("Location: formusuario.php?erro=nomeInvalido");
    exit;
}

if ($telefoneUsuario === "") {
    header("Location: formusuario.php?erro=telefoneInvalido");
    exit;
}

if (
    !filter_var($emailUsuario, FILTER_VALIDATE_EMAIL) ||
    !preg_match('/@estudantes\.ifpr\.edu\.br$/i', $emailUsuario)
) {
    header("Location: formusuario.php?erro=emailInvalido");
    exit;
}

if ($senha === "" || $senha !== $confirmarSenha) {
    header("Location: formusuario.php?erro=senhasDiferentes");
    exit;
}

require_once "conexaoBD.php";

$senhaUsuario = md5($senha);
$sql = "INSERT INTO usuarios
    (Nomeusuario, Telefoneusuario, Emailusuario, Senhausuario)
    VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    exit("Não foi possível preparar o cadastro do usuário.");
}

mysqli_stmt_bind_param(
    $stmt,
    "ssss",
    $nomeUsuario,
    $telefoneUsuario,
    $emailUsuario,
    $senhaUsuario
);

try {
    mysqli_stmt_execute($stmt);
} catch (mysqli_sql_exception $erro) {
    mysqli_stmt_close($stmt);
    if ($erro->getCode() === 1062) {
        header("Location: formusuario.php?erro=emailDuplicado");
        exit;
    }

    throw $erro;
}

mysqli_stmt_close($stmt);
$_SESSION["cadastro_sucesso"] = [
    "nome" => $nomeUsuario,
    "email" => $emailUsuario,
];

header("Location: usuario-criado.php");
exit;
