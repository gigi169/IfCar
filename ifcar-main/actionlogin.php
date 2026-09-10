<?php

    include "conexaoBD.php"; //Inclui o arquivo de conexão com o BD para consultar usuários
    session_start(); //Função para iniciar uma sessão

    $Emailusuario = mysqli_real_escape_string($conn, $_POST['Emailusuario']); //Função para filtrar a entrada de dados
    $Senhausuario = mysqli_real_escape_string($conn, $_POST['Senhausuario']);

    //QUERY para buscar dados de Login
    $buscarLogin = "SELECT *
                    FROM usuarios
                    WHERE Emailusuario = '$Emailusuario'
                    AND Senhausuario = md5('$Senhausuario')
                    ";

    $efetuarLogin = mysqli_query($conn, $buscarLogin); //Executa a QUERY

    //Verifica se encontrou registros associados à a consulta
    if($registro = mysqli_fetch_assoc($efetuarLogin)){
        //Cria variáveis de sessão
        $_SESSION['Idusuario']    = $registro['ID'];
        $_SESSION['Nomeusuario']  = $registro['Nomeusuario'];
        $_SESSION['Emailusuario'] = $registro['Emailusuario'];
        $_SESSION['Telefoneusuario'] = $registro['Telefoneusuario'];
        $_SESSION['logado']       = true;

        //Redirecion o usuário para a página inicial
        header("Location: index.php");
        exit();
    }
    else{
        //Redireciona o usuário para formLogin.php
        header("Location: login.php?erroLogin=dadosInvalidos"); //Passa por GET o erro ocorrido
        exit();
    }


?>