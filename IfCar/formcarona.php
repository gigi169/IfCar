<?php include "header2.php" ?> //TERMINADO
<section class="bg-dark">
  <form action="actioncarona.php" method="POST" class="was-validated" enctype="multipart/form-data">
    <div class="container py-3 ">
      <div class="row d-flex justify-content-center align-items-center ">
        <div class="col">
          <div class="card card-registration my-4">
            <div class="row g-0">
              <div class="col-xl-6">
                <div class="card-body p-md-5 text-black">
                  <h3 class="mb-5 text-uppercase">Cadastro da carona</h3>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="Nomeusuario">Nome Completo</label>
                    <input type="text" id="Nomeusuario" name="Nomeusuario" class="form-control form-control-lg" />
                  
                  </div>
                  
                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="Enderecosaida">Endereco de saida</label>
                    <input type="text" id="Enderecosaida" name="Enderecosaida" class="form-control form-control-lg" />
                  
                  </div>

                  <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="Enderecodestino">Endereco de destino</label>
                    <input type="text" id="Enderecodestino" name="Enderecodestino" class="form-control form-control-lg" />
                  
                  </div>
                  <div>

                   <label class="form-label" for="Bairros">Bairros percorridos</label>

    <label class="form-label"><strong>Bairros percorridos</strong></label>

    <div id="Bairros" name="Bairros" class="form-check">

        <input class="form-check-input" type="checkbox" id="centro" name="Bairros[]" value="Centro">
        <label class="form-check-label" for="centro">Centro</label><br>

    <input class="form-check-input" type="checkbox" id="centro" name="Bairros[]" value="Centro">
    <label class="form-check-label" for="centro">Centro</label><br>

    <input class="form-check-input" type="checkbox" id="alto_das_oliveiras" name="Bairros[]" value="Alto das Oliveiras">
    <label class="form-check-label" for="alto_das_oliveiras">Alto das Oliveiras</label><br>

    <input class="form-check-input" type="checkbox" id="alvorada" name="Bairros[]" value="Alvorada">
    <label class="form-check-label" for="alvorada">Alvorada</label><br>

    <input class="form-check-input" type="checkbox" id="ana_mary" name="Bairros[]" value="Ana Mary">
    <label class="form-check-label" for="ana_mary">Ana Mary</label><br>

    <input class="form-check-input" type="checkbox" id="bela_vista" name="Bairros[]" value="Bela Vista">
    <label class="form-check-label" for="bela_vista">Bela Vista</label><br>

    <input class="form-check-input" type="checkbox" id="bom_jesus" name="Bairros[]" value="Bom Jesus">
    <label class="form-check-label" for="bom_jesus">Bom Jesus</label><br>

    <input class="form-check-input" type="checkbox" id="caic" name="Bairros[]" value="CAIC">
    <label class="form-check-label" for="caic">CAIC</label><br>

    <input class="form-check-input" type="checkbox" id="cidade_nova" name="Bairros[]" value="Cidade Nova">
    <label class="form-check-label" for="cidade_nova">Cidade Nova</label><br>

    <input class="form-check-input" type="checkbox" id="aeroporto" name="Bairros[]" value="Aeroporto">
    <label class="form-check-label" for="aeroporto">Aeroporto</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_alegre" name="Bairros[]" value="Jardim Alegre">
    <label class="form-check-label" for="jardim_alegre">Jardim Alegre</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_bandeirantes" name="Bairros[]" value="Jardim Bandeirantes">
    <label class="form-check-label" for="jardim_bandeirantes">Jardim Bandeirantes</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_bonavila" name="Bairros[]" value="Jardim Bonavila">
    <label class="form-check-label" for="jardim_bonavila">Jardim Bonavila</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_florestal" name="Bairros[]" value="Jardim Florestal">
    <label class="form-check-label" for="jardim_florestal">Jardim Florestal</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_italia" name="Bairros[]" value="Jardim Itália">
    <label class="form-check-label" for="jardim_italia">Jardim Itália</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_kroll" name="Bairros[]" value="Jardim Kroll">
    <label class="form-check-label" for="jardim_kroll">Jardim Kroll</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_monte_carlo" name="Bairros[]" value="Jardim Monte Carlo">
    <label class="form-check-label" for="jardim_monte_carlo">Jardim Monte Carlo</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_monte_sinai" name="Bairros[]" value="Jardim Monte Sinai">
    <label class="form-check-label" for="jardim_monte_sinai">Jardim Monte Sinai</label><br>

    <input class="form-check-input" type="checkbox" id="jardim_uniao" name="Bairros[]" value="Jardim União">
    <label class="form-check-label" for="jardim_uniao">Jardim União</label><br>

    <input class="form-check-input" type="checkbox" id="limeira_ii" name="Bairros[]" value="Limeira Área II">
    <label class="form-check-label" for="limeira_ii">Limeira Área II</label><br>

    <input class="form-check-input" type="checkbox" id="limeira_iii" name="Bairros[]" value="Limeira Área III">
    <label class="form-check-label" for="limeira_iii">Limeira Área III</label><br>

    <input class="form-check-input" type="checkbox" id="limeira_vi" name="Bairros[]" value="Limeira Área VI">
    <label class="form-check-label" for="limeira_vi">Limeira Área VI</label><br>

    <input class="form-check-input" type="checkbox" id="limeira_vii" name="Bairros[]" value="Limeira Área VII">
    <label class="form-check-label" for="limeira_vii">Limeira Área VII</label><br>

    <input class="form-check-input" type="checkbox" id="macopa" name="Bairros[]" value="Macopa">
    <label class="form-check-label" for="macopa">Macopa</label><br>

    <input class="form-check-input" type="checkbox" id="monte_alegre" name="Bairros[]" value="Monte Alegre">
    <label class="form-check-label" for="monte_alegre">Monte Alegre</label><br>

    <input class="form-check-input" type="checkbox" id="fatima" name="Bairros[]" value="Nossa Senhora de Fátima">
    <label class="form-check-label" for="fatima">Nossa Senhora de Fátima</label><br>

    <input class="form-check-input" type="checkbox" id="perpetuo_socorro" name="Bairros[]" value="Nossa Senhora do Perpétuo Socorro">
    <label class="form-check-label" for="perpetuo_socorro">Nossa Senhora do Perpétuo Socorro</label><br>

    <input class="form-check-input" type="checkbox" id="praca_pinheiros" name="Bairros[]" value="Praça dos Pinheiros">
    <label class="form-check-label" for="praca_pinheiros">Praça dos Pinheiros</label><br>

    <input class="form-check-input" type="checkbox" id="santa_rita" name="Bairros[]" value="Santa Rita">
    <label class="form-check-label" for="santa_rita">Santa Rita</label><br>

    <input class="form-check-input" type="checkbox" id="sao_francisco" name="Bairros[]" value="São Francisco">
    <label class="form-check-label" for="sao_francisco">São Francisco</label><br>

    <input class="form-check-input" type="checkbox" id="sao_joao" name="Bairros[]" value="São João">
    <label class="form-check-label" for="sao_joao">São João</label><br>

    <input class="form-check-input" type="checkbox" id="socomim" name="Bairros[]" value="Socomim">
    <label class="form-check-label" for="socomim">Socomim</label><br>

    <input class="form-check-input" type="checkbox" id="triangulo" name="Bairros[]" value="Triângulo">
    <label class="form-check-label" for="triangulo">Triângulo</label><br>

    <input class="form-check-input" type="checkbox" id="vila_esperanca" name="Bairros[]" value="Vila Esperança">
    <label class="form-check-label" for="vila_esperanca">Vila Esperança</label><br>

    <input class="form-check-input" type="checkbox" id="vila_ozorio" name="Bairros[]" value="Vila Ozório">
    <label class="form-check-label" for="vila_ozorio">Vila Ozório</label><br>

    <input class="form-check-input" type="checkbox" id="vila_rural" name="Bairros[]" value="Vila Rural Brilho do Sol">
    <label class="form-check-label" for="vila_rural">Vila Rural Brilho do Sol</label><br>

    <input class="form-check-input" type="checkbox" id="fazenda_monte_alegre" name="Bairros[]" value="Fazenda Monte Alegre">
    <label class="form-check-label" for="fazenda_monte_alegre">Fazenda Monte Alegre</label>

</div>

                  </div>
                  </div>
                  <br>
                  <div>

                   
                          <label for="quantity"> Numero de caronas disponiveis(De 1 a 5):</label>
                          <input type="number" id="Numerocarona" name="Numerocarona" min="1" max="5">
                          <input type="submit" value="Submit">
                   
                  </div>
                  <br>
                  <div>
                  
                
                      <label for="caronatime">Data e Hora</label>
                      <input type="datetime-local" id="Caronatime" name="Caronatime">
                   
                  </div>

                 <button type="submit" class="btn btn-outline-dark">Criar Carona</button>


                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>
<include "conexaoBD.php";>
?php include "footer.php" ?>
