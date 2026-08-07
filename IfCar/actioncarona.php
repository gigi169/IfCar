<?php include "header.php" ?> //TERMINADO

    <?php
        //Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Cria variáveis para armazenar as informações recebidas do array $_POST
            $Nomeusuario = $Enderecosaida = $Enderecodestino = $Bairros = $Numerocarona = $Caronatime = "";

            //Variável booleana para controle de erros de preenchimento
            $erroPreenchimento = false;

            //Validação do campo Nomeusuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Nomeusuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Nomeusuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Nomeusuario = filtrar_entrada($_POST["Nomeusuario"]);

                //Utiliza a função preg_match() para verificar se há apenas letras no nome
                if(!preg_match('/^[\p{L} ]+$/u', $Nomeusuario)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $erroPreenchimento = true;
                }
            }

            if(empty($_POST["Enderecosaida"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>ENDEREÇO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Nomeusuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Enderecosaida= filtrar_entrada($_POST["Enderecosaida"]);

                //Utiliza a função preg_match() para verificar se há apenas letras no nome
                if(!preg_match('/^[\p{L} ]+$/u', $Enderecosaida)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $erroPreenchimento = true;
                }
            }

            if(empty($_POST["Enderecodestino"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>ENDEREÇO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Nomeusuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Enderecodestino= filtrar_entrada($_POST["Enderecodestino"]);

                //Utiliza a função preg_match() para verificar se há apenas letras no nome
                if(!preg_match('/^[\p{L} ]+$/u', $Enderecodestino)){
                    echo "<div class='alert alert-warning text-center'>O campo <strong>NOME</strong> deve conter apenas letras!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Validação do campo Bairros
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Bairros"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>BAIRRO</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Bairros"] não estiver vazio, é filtrado e armazenado na variável PHP
                $bairros = implode(", ", $_POST["Bairros"]);
            }

            //Validação do campo Numerocarona
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Numerocarona"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>NUMERO DE PESSOAS NA CARONA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Numerocarona"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Numerocarona = filtrar_entrada($_POST["Numerocarona"]);
            }

            //Validação do campo Caronatime
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Caronatime"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>DATA E HORA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Caronatime"] não estiver vazio, é filtrado e armazenado na variável PHP
                //Usa a função md5() para criptografar a senha do usuário
                $Caronatime = filtrar_entrada($_POST["Caronatime"]);
            }


           
            //Verifica se não há erro de preenchimento
            if(!$erroPreenchimento){

                //Cria uma variável para armazenar a QUERY que realiza a inserção de dados na tabela Usuarios
                $inserirUsuario = "INSERT INTO Carona ( Nomeusuario,Bairros, Numerocarona, Caronatime,
                Enderecosaida, Enderecodestino)
                 VALUES ('$Nomeusuario', '$Bairros', '$Numerocarona', '$Caronatime', '$Enderecosaida', '$Enderecodestino')";

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                //Usa a função mysqli_query() para executar a QUERY no Banco de Dados
                //Se conseguir, exibe alerta de sucesso e tabela com os dados informados
                if(mysqli_query($conn, $inserirUsuario)){

                    echo "<div class='alert alert-success text-center'>O cadastro do <strong>Carona</strong> foi efetuado com sucesso!</div>";
                    echo "
                        <div class='container mb-3 mt-3'>
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$Nomeusuario</td>
                                </tr>
                                <tr>
                                    <th>BAIRROS</th>
                                    <td>$Bairros</td>
                                </tr>
                                <tr>
                                    <th>NUMEROS DE CARONAS DISPONIVEIS</th>
                                    <td>$Numerocarona</td>
                                </tr>
                                <tr>
                                    <th>HORA E DIA DA CARONA</th>
                                    <td>$Caronatime</td>
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
            //Usa a função header() para redirecionar o usuário para o formUsuario.php
            header("location:formcarona.php");
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

<?php include "footer.php" ?>