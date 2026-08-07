<?php include "header2.php" ?>

<div class="d-flex justify-content-center mb-3">
    <h2>Cadastre-se</h2>
</div>

<section class="bg-dark">
    <form action="actionusuario.php" method="POST" class="was-validated" enctype="multipart/form-data">
            <div class="container py-3 ">
                <div class="row d-flex justify-content-center align-items-center ">
                    <div class="col">
                        <div class="card card-registration my-4">
                            <div class="row g-0">
                                <div class="col-xl-6">
                                    <div class="card-body p-md-5 text-black">
                                        <h3 class="mb-5 text-uppercase">Cadastro</h3>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="Nomeusuario">Nome Completo</label>
                                            <input type="text" id="Nomeusuario" nome="Nomeusuario" class="form-control form-control-lg" />
                            
                                            <div class="valid-feedback"></div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    
                                        <div data-mdb-input-init class="form-outline mb-4"> 
                                            <label class="form-label" for="Telefoneusuario">Telefone</label>
                                            <input type="tel" id="Telefoneusuario" nome="Telefoneusuario" class="form-control form-control-lg" />
                                           
                                            <div class="valid-feedback"></div>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label class="form-label" for="Emailusuario">Email</label>
                                            <input type="text" id="Emailusuario" name="Emailusuario" class="form-control form-control-lg" />
                                            
                                            <div class="valid-feedback"></div>
                                            <div class="invalid-feedback"></div>
                                        </div>


                                        <div data-mdb-input-init class="form-outline mb-4"> 
                                            <label class="form-label" for="Senhausuario">Senha</label>
                                            <input type="password" id="Senhausuario" name="Senhausuario" class="form-control form-control-lg" />
                                           
                                            <div class="valid-feedback"></div>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div data-mdb-input-init class="form-outline mb-4">
                                            <label for="Confirmarsenhausuario">Confirme a Senha</label>
                                            <input type="password" name="Confirmarsenhausuario" id="Confirmarsenhausuario" placeholder="Confirme a Senhausuario" class="form-control" minlength="3" maxlength="8">
                                            
                                            <div class="valid-feedback"></div>
                                            <div class="invalid-feedback"></div>
                                        </div>

                                        <div class="d-flex justify-content-end pt-3">
                                            <a href="index.php">
                                                <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2">Cadastrar</button>
                                            </a>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>         
    </form> 
 </section>
      

