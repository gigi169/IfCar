<?php include "header.php" ?>
<section class="h-100 bg-dark">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col">
        <div class="card card-registration my-4">
          <div class="row g-0">
            <div class="col-xl-6">
              <div class="card-body p-md-5 text-black">
                <h3 class="mb-5 text-uppercase">Cadastro</h3>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="form3Example9" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example9">Nome Completo</label>
                </div>
                
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="tel" id="form3Example9" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example9">Telefone</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="form3Example9" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example9">Email</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="password" id="form3Example9" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example9">Senha</label>
                </div>

                <div class="d-flex justify-content-end pt-3">
                  <a href="formusuario2.php">
                     <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2">Proximo</button>
                  </a>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include "footer.php" ?>