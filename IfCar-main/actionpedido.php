<?php require_once "auth.php"; ?>

    <?php
        //Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Cria variáveis para armazenar as informações recebidas do array $_POST
            $Enderecosaida = $Enderecodestino =  $Numeropassageiros = $Data = $Hora = $Detalhes= "";

            //Variável booleana para controle de erros de preenchimento
            $Erropreenchimento = false;

            if(empty($_POST["Enderecosaida"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>ENDEREÇO</strong> é obrigatório!</div>";
                $Erropreenchimento = true;
            }
            else{
                //Se o $_POST["Nomeusuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Enderecosaida= filtrar_entrada($_POST["Enderecosaida"]);

                //Utiliza a função preg_match() para verificar se há apenas letras no nome
                if(!preg_match('/^[\p{L} ]+$/u', $Enderecosaida)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $Erropreenchimento = true;
                }
            }

            if(empty($_POST["Enderecodestino"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>ENDEREÇO</strong> é obrigatório!</div>";
                $Erropreenchimento = true;
            }
            else{
                //Se o $_POST["Nomeusuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Enderecodestino= filtrar_entrada($_POST["Enderecodestino"]);

                //Utiliza a função preg_match() para verificar se há apenas letras no nome
                if(!preg_match('/^[\p{L} ]+$/u', $Enderecodestino)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $Erropreenchimento = true;
                }
            }


            //Validação do campo Numeropassageiros
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Numeropassageiros"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NUMERO DE PESSOAS NA CARONA</strong> é obrigatório!</div>";
                $Erropreenchimento = true;
            }
            else{
                //Se o $_POST["Numeropassageiros"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Numeropassageiros = filtrar_entrada($_POST["Numeropassageiros"]);
            }


            if(empty($_POST["Data"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA </strong> é obrigatório!</div>";
                $Erropreenchimento = true;
            }
            else{
                //Se o $_POST["Caronatime"] não estiver vazio, é filtrado e armazenado na variável PHP
                //Usa a função md5() para criptografar a senha do usuário
                $Data = filtrar_entrada($_POST["Data"]);
            }

            if(empty($_POST["Hora"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>HORA</strong> é obrigatório!</div>";
                $Erropreenchimento = true;
            }
            else{
                //Se o $_POST["Caronatime"] não estiver vazio, é filtrado e armazenado na variável PHP
                //Usa a função md5() para criptografar a senha do usuário
                $Hora= filtrar_entrada($_POST["Hora"]);
            }


            //Verifica se não há erro de preenchimento
            if(!$Erropreenchimento){

                include "conexaoBD.php"; //Inclui o arquivo de conexão com o BD para consultar usuários

                $Idusuario = $_SESSION['Idusuario'] ?? "";
                //Cria uma variável para armazenar a QUERY que realiza a inserção de dados na tabela Usuarios
                $Inserirusuario = "INSERT INTO Caronas (Numeropassageiros, Enderecosaida, Enderecodestino, Data, Hora, Detalhes, Idusuario)
                 VALUES ( '$Numeropassageiros', '$Enderecosaida', '$Enderecodestino' , '$Data' , '$Hora', '$Detalhes' , '$Idusuario')";


                //Usa a função mysqli_query() para executar a QUERY no Banco de Dados
                //Se conseguir, exibe alerta de sucesso e tabela com os dados informados
                if(mysqli_query($conn, $Inserirusuario)){

                    echo "<div class='alert alert-success text-center'>O cadastro do <strong>Carona</strong> foi efetuado com sucesso!</div>";
                    echo "
                        <div class='container mb-3 mt-3'>
                            <table class='table'>
                                <tr>
                                    <th>NUMEROS DE CARONAS DISPONIVEIS</th>
                                    <td>$Numeropassageiros</td>
                                </tr>
                                <tr>
                                    <th>Data DA CARONA</th>
                                    <td>$Data</td>
                                </tr>
                                <tr>
                                    <th>HORA DA CARONA</th>
                                    <td>$Hora</td>
                                </tr>
                                <tr>
                                    <th>DETALHES DA CARONA</th>
                                    <td>$Detalhes</td>
                                </tr>
                            </table>
                        </div>
                    ";
                }
                else{
                    echo "<div class='alert alert-danger text-center'>Erro ao tentar cadastrar <strong>USUÁRIO</strong> no banco de dados!</div>";
                }
            }

        }
        else{
            header("location:pedir-carona.php");
        }

        //Função para filtrar entrada de dados e evitar SQL Injection
        function filtrar_entrada($dado){
            $dado = trim($dado); //Remove espaços desnecessários
            $dado = stripslashes($dado); //Remove barras invertidas
            $dado = htmlspecialchars($dado); //Converte caracteres especiais em entidades HTML

            //Após o dado passar pelos filtros, é retornado
            return($dado);
        }
    ?>
