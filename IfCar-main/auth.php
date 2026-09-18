<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (
    !isset($_SESSION['logado'], $_SESSION['Idusuario']) ||
    $_SESSION['logado'] !== true
) {
    header("Location: login.php");
    exit;
}
