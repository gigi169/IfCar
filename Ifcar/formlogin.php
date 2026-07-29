<?php include "header.php" ?>

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
</form>
<?php include "footer.php" ?>