<?php include "header2.php" ?>
<section class=" bg-dark">
  <div class="container py-3">
    <div class="row d-flex justify-content-center align-items-center ">
      <div class="col">
        <div class="card card-registration my-4">
          <div class="row g-0">
            <div class="col-xl-6">
              <div class="card-body p-md-5 text-black">
                <a class="nav-link" href="formusua.php"></a>
              <h3 class="mb-5 text-uppercase">Cadastro da carona</h3>

                  <div>
                        <select data-mdb-select-init>
                        <option value="1">Ocupação</option>
                        <option value="2">Motorista</option>
                        <option value="3">Passageiros</option>
                        <option value="4">Ambos</option>
                        </select>
                  </div>
                
                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="form3Example9" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example9">Origem</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                  <input type="text" id="form3Example9" class="form-control form-control-lg" />
                  <label class="form-label" for="form3Example9">Distino</label>
                </div>
            
                <div class="d-flex justify-content-end pt-3">
                  <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg ms-2">Proximo</button>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
?php include "footer.php" ?>
