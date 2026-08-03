<?php include "header2.php" ?>
    
<section class="bg-dark">
  <div class="container py-3 ">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col">
        <div class="card card-registration my-4">
          <div class="row g-0">
            <div class="col-xl-6">
                <div class="card-body p-md-5 text-black">
                  <h3 class="mb-5 text-uppercase">Login</h3>
                  <form>
                        <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                      <input type="email" id="form2Example1" class="form-control" />
                      <label class="form-label" for="form2Example1">Email</label>
                    </div>

                      <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                       <input type="password" id="form2Example2" class="form-control" />
                       <label class="form-label" for="form2Example2">Password</label>
                     </div>

                        <!-- 2 column grid layout for inline styling -->

                        <!-- Submit button -->
                      <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Entrar</button>

                        <!-- Register buttons -->
                      <div class="text-center">
                        <a href="formusuario.php">Cadastrar</a>
                      </div>
                  </form>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
?php include "footer.php" ?>
