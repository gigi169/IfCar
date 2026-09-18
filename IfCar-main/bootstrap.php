<?php

function configuracaoBanco(): array
{
    $arquivoConfiguracao = __DIR__ . DIRECTORY_SEPARATOR . "config.local.php";

    if (!is_file($arquivoConfiguracao)) {
        throw new RuntimeException(
            "Configure o banco copiando config.example.php para config.local.php."
        );
    }

    return require $arquivoConfiguracao;
}

function conectarBanco(): mysqli
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $config = configuracaoBanco();
    $database = $config["database"];

    $conn = mysqli_connect($config["host"], $config["usuario"], $config["senha"]);
    mysqli_set_charset($conn, "utf8mb4");

    mysqli_query(
        $conn,
        "CREATE DATABASE IF NOT EXISTS `$database`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_general_ci"
    );
    mysqli_select_db($conn, $database);

    mysqli_query(
        $conn,
        "CREATE TABLE IF NOT EXISTS usuarios (
            ID INT NOT NULL AUTO_INCREMENT,
            Nomeusuario VARCHAR(50) NOT NULL,
            Emailusuario VARCHAR(255) NOT NULL,
            Telefoneusuario VARCHAR(20) NOT NULL,
            Senhausuario VARCHAR(255) NOT NULL,
            PRIMARY KEY (ID),
            UNIQUE KEY usuarios_email_unico (Emailusuario)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    );

    mysqli_query(
        $conn,
        "CREATE TABLE IF NOT EXISTS caronas (
            ID INT NOT NULL AUTO_INCREMENT,
            IDusuario INT NOT NULL,
            Enderecosaida VARCHAR(100) NOT NULL,
            Enderecodestino VARCHAR(100) NOT NULL,
            Numeropassageiros TINYINT UNSIGNED NOT NULL,
            Data DATE NOT NULL,
            Hora TIME NOT NULL,
            categoria VARCHAR(50) DEFAULT NULL,
            PRIMARY KEY (ID),
            KEY caronas_usuario (IDusuario),
            CONSTRAINT caronas_usuario_fk
                FOREIGN KEY (IDusuario) REFERENCES usuarios (ID)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    );

    mysqli_query(
        $conn,
        "CREATE TABLE IF NOT EXISTS solicitacoes (
            ID INT NOT NULL AUTO_INCREMENT,
            IDcarona INT NOT NULL,
            IDusuario INT NOT NULL,
            Status VARCHAR(20) NOT NULL DEFAULT 'pendente',
            PRIMARY KEY (ID),
            UNIQUE KEY solicitacao_unica (IDcarona, IDusuario),
            KEY solicitacao_usuario (IDusuario),
            CONSTRAINT solicitacao_carona_fk
                FOREIGN KEY (IDcarona) REFERENCES caronas (ID),
            CONSTRAINT solicitacao_usuario_fk
                FOREIGN KEY (IDusuario) REFERENCES usuarios (ID)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci"
    );

    return $conn;
}
