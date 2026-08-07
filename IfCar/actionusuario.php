 <?php
        //Verifica se o método de envio das informações do form é "POST"
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //Cria variáveis para armazenar as informações recebidas do array $_POST
            $Nomeusuario = $Telefoneusuario = $Emailusuario = $Senhausuario = $Confirmarsenhausuario = "";

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

            //Validação do campo Telefoneusuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Telefoneusuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>TELEFONE</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Telefoneusuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Telefoneusuario = filtrar_entrada($_POST["Telefoneusuario"]);
            }

            //Validação do campo Emailusuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Emailusuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>EMAIL</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Emailusuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Emailusuario = filtrar_entrada($_POST["Emailusuario"]);
            }

            //Validação do campo Senhausuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Senhausuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Senhausuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                //Usa a função md5() para criptografar a senha do usuário
                $Senhausuario = md5(filtrar_entrada($_POST["Senhausuario"]));
            }

            //Validação do campo Confirmarsenhausuario
            //Utiliza a função empty() para verificar se o campo está vazio
            if(empty($_POST["Confirmarsenhausuario"])){
                echo "<div class='alert alert-warning text-center'>O campo <strong>CONFIRMAR SENHA</strong> é obrigatório!</div>";
                $erroPreenchimento = true;
            }
            else{
                //Se o $_POST["Confirmarsenhausuario"] não estiver vazio, é filtrado e armazenado na variável PHP
                $Confirmarsenhausuario = md5(filtrar_entrada($_POST["Confirmarsenhausuario"]));

                //Compara se as senhas são diferentes
                if($Senhausuario != $Confirmarsenhausuario){
                    echo "<div class='alert alert-warning text-center'>As <strong>SENHAS</strong> informadas não são iguais!</div>";
                    $erroPreenchimento = true;
                }
            }

            //Verifica se não há erro de preenchimento
            if(!$erroPreenchimento ){

                //Cria uma variável para armazenar a QUERY que realiza a inserção de dados na tabela Usuarios
                $inserirUsuario = "INSERT INTO Usuarios ( Nomeusuario, Telefoneusuario, Emailusuario, Senhausuario) VALUES ('$Nomeusuario', '$Telefoneusuario', '$Emailusuario', '$Senhausuario')";

                //Inclui o arquivo de conexão com o Banco de Dados
                include "conexaoBD.php";

                //Usa a função mysqli_query() para executar a QUERY no Banco de Dados
                //Se conseguir, exibe alerta de sucesso e tabela com os dados informados
                if(mysqli_query($conn, $inserirUsuario)){

                    echo "<div class='alert alert-success text-center'>O cadastro do <strong>USUÁRIO</strong> foi efetuado com sucesso!</div>";
                    echo "
                        <div class='container mb-3 mt-3'>
                            <table class='table'>
                                <tr>
                                    <th>NOME</th>
                                    <td>$Nomeusuario</td>
                                </tr>
                                <tr>
                                    <th>TELEFONE</th>
                                    <td>$Telefoneusuario</td>
                                </tr>
                                <tr>
                                    <th>EMAIL</th>
                                    <td>$Emailusuario</td>
                                </tr>
                                <tr>
                                    <th>SENHA</th>
                                    <td>$Senhausuario</td>
                                </tr>
                                <tr>
                                    <th>CONFIRMAR SENHA</th>
                                    <td>$Confirmarsenhausuario</td>
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
            header("location:formusuario.php");
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