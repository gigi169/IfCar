<?php include "header2.php" ?>

    <?php

        //Verifica se há alguma passagem de parâmetro via método GET chamada 'erroLogin'
        if(isset($_GET['erroLogin'])){
            $erroLogin = $_GET['erroLogin'];

            if($erroLogin == 'dadosInvalidos'){
                echo "<div class= 'alert alert-warning text-center'>Email ou Senha inválidos!</div>";
            }
        }

    ?>

    <section class="bg-dark">
        <form action="actionlogin.php" method="POST" class="was-validated" enctype="multipart/form-data">
                <div class="container py-3 ">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col">
                            <div class="card card-registration my-4">
                                <div class="row g-0">
                                    <div class="col-xl-6">
                                        <div class="card-body p-md-5 text-black">
                                        <h3 class="mb-5 text-uppercase">Login</h3>
                                        <form>
                                                <!-- Emailusuario input -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="Emailusuario" id="Emailusuario" name="Emailusuario" class="form-control" />
                                                <label class="form-label" for="Emailusuario">Email</label>
                                            </div>

                                            <!-- Password input -->
                                            <div data-mdb-input-init class="form-outline mb-4">
                                                <input type="password" id="Senhausuario" name="Senhausuario" class="form-control" />
                                                <label class="form-label" for="Senhausuario">Senha</label>
                                            </div>

                                            <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4" >Login

                                            </button>

                                                <!-- Register buttons -->
                                            <div class="d-flex justify-content-center mb-3">
                                                <p>Ainda não é cadastrado? <a href="formusuario.php" title="Cadastrar-se">Clique aqui!</a>&nbsp<i class="bi bi-emoji-smile"></i></p>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
        </form>
    </section>


