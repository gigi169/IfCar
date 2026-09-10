<?php
require_once "auth.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formcarona.php");
    exit;
}

$categoria = $_GET["categoria"] ?? "";
if (!in_array($categoria, ["oferecendo", "pedindo"], true)) {
    header("Location: index.php?erro=categoriaInvalida");
    exit;
}

$enderecosaida = trim($_POST["Enderecosaida"] ?? "");
$enderecodestino = trim($_POST["Enderecodestino"] ?? "");
$numeroPassageiros = filter_input(
    INPUT_POST,
    "Numeropassageiros",
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1, "max_range" => 4]]
);
$data = $_POST["Data"] ?? "";
$hora = $_POST["Hora"] ?? "";

$dataValida = DateTime::createFromFormat("Y-m-d", $data);
$horaValida = DateTime::createFromFormat("H:i", $hora);

if (
    $enderecosaida === "" ||
    $enderecodestino === "" ||
    !is_int($numeroPassageiros) ||
    !$dataValida ||
    $dataValida->format("Y-m-d") !== $data ||
    !$horaValida ||
    $horaValida->format("H:i") !== $hora
) {
    $paginaErro = $categoria === "oferecendo" ? "formcarona.php" : "pedir-carona.php";
    header("Location: $paginaErro?erro=dadosInvalidos");
    exit;
}

require_once "conexaoBD.php";

$idUsuario = (int) $_SESSION["Idusuario"];
$sql = "INSERT INTO caronas
    (Numeropassageiros, Enderecosaida, Enderecodestino, Data, Hora, categoria, IDusuario)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    exit("Nao foi possivel preparar o cadastro da carona.");
}

mysqli_stmt_bind_param(
    $stmt,
    "isssssi",
    $numeroPassageiros,
    $enderecosaida,
    $enderecodestino,
    $data,
    $hora,
    $categoria,
    $idUsuario
);

if (!mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    http_response_code(500);
    exit("Nao foi possivel cadastrar a carona.");
}

mysqli_stmt_close($stmt);
$paginaRetorno = $categoria === "oferecendo" ? "formcarona.php?sucesso=cadastrada" : "pedir-carona.php?sucesso=cadastrado";
header("Location: $paginaRetorno");
exit;
