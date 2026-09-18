<?php
require_once "auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: perfil.php");
    exit;
}

$idUsuario = (int) $_SESSION["Idusuario"];
$nomeUsuario = trim($_POST["Nomeusuario"] ?? "");
$emailUsuario = trim($_POST["Emailusuario"] ?? "");
$telefoneUsuario = trim($_POST["Telefoneusuario"] ?? "");

if ($nomeUsuario === "" || $emailUsuario === "" || $telefoneUsuario === "") {
    header("Location: perfil.php?erro=camposObrigatorios");
    exit;
}

if (!filter_var($emailUsuario, FILTER_VALIDATE_EMAIL)) {
    header("Location: perfil.php?erro=emailInvalido");
    exit;
}

require_once "conexaoBD.php";

$sql = "UPDATE usuarios
    SET Nomeusuario = ?, Emailusuario = ?, Telefoneusuario = ?
    WHERE ID = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    exit("Nao foi possivel preparar a atualizacao do perfil.");
}

mysqli_stmt_bind_param(
    $stmt,
    "sssi",
    $nomeUsuario,
    $emailUsuario,
    $telefoneUsuario,
    $idUsuario
);

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    http_response_code(500);
    exit("Nao foi possivel atualizar o perfil.");
}

mysqli_stmt_close($stmt);
$_SESSION["Nomeusuario"] = $nomeUsuario;
$_SESSION["Emailusuario"] = $emailUsuario;
$_SESSION["Telefoneusuario"] = $telefoneUsuario;

header("Location: perfil.php?sucesso=alterado");
exit;
