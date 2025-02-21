</div>
</div>
<div class="sb-sidenav-footer">
  <div class="small">Sesión iniciada como:</div>
  <?php echo $_SESSION["nombre"] ?>
</div>
</nav>
</div>

<div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4-edited">
      <h1 class="mt-4">Inicio</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active"></li>
      </ol>
      <div class="row">

        <div class="col-xl-3 col-md-6">
          <div class="card text-white mb-4" style="background-color: #393c3f;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <i class="fas fa-shopping-cart fa-3x"></i>
                <div class="text-right">
                  <h3>Pedidos</h3>
                  <p class="display-4"></p>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="pedidosList">Ver Detalles</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card text-white mb-4" style="background-color: #393c3f;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <i class="fas fa-box fa-3x"></i>
                <div class="text-right">
                  <h3>Inventario</h3>
                  <p class="display-4"></p>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="almacenProductos">Ver Detalles</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card text-white mb-4" style="background-color: #393c3f;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <i class="fas fa-box-open fa-3x"></i>
                <div class="text-right">
                  <h3>Ingresos</h3>
                  <p class="display-4"></p>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="ingresoList">Ver Detalles</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>

        <div class="col-xl-3 col-md-6">
          <div class="card text-white mb-4" style="background-color: #393c3f;">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <i class="fas fa-users fa-3x"></i>
                <div class="text-right">
                  <h3>Clientes</h3>
                  <p class="display-4"></p>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
              <a class="small text-white stretched-link" href="clients">Ver Detalles</a>
              <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- Contenedor de los procesos operativos -->
        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="card-title">
                Procesos Operativos
                <span class="filtro-seleccionado-estados-procesos"></span>
              </h5>
              <div class="filter">
                <a class="icon" data-bs-toggle="dropdown" style="color: black; font-size: 23px; cursor: pointer;">
                  <i class="fa-solid fa-ellipsis"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" id="filtro-estados-procesos">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>
                  <!-- Opciones del filtro serán agregadas dinámicamente aquí -->
                </ul>
              </div>
            </div>

            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="ps-3 w-100">
                  <div class="estado-seleccionado d-flex align-items-center">
                    <div class="icon-container"
                      style="display: flex; align-items: center; justify-content: center; width: 120px; height: 120px; border-radius: 50%; background-color: #f0f0f0;">
                      <i class="estado-icon fa-solid fa-file-lines" style="font-size: 55px; color: #393c3f;"></i>
                    </div>
                    <span class="estado-text"
                      style="font-size: 25px; font-weight: normal; margin-left: 45px;">Registrado:</span>
                    <span class="estado-conteo" style="font-size: 30px; font-weight: bolder; margin-left: 5px;">0</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-6 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="card-title">
                Monto Recaudado
                <span class="filtro-seleccionado-ganancia-anio"></span>
              </h5>
              <div class="filter">
                <a class="icon" data-bs-toggle="dropdown" style="color: black; font-size: 23px; cursor: pointer;">
                  <i class="fa-solid fa-ellipsis"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow" id="filtro-ganancia-anio">
                  <li class="dropdown-header text-start">
                    <h6 style="color: red;">Filtro</h6>
                  </li>
                  <!-- Opciones del filtro serán agregadas dinámicamente aquí -->
                </ul>
              </div>
            </div>

            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="ps-3 w-100">
                  <div class="ganancia-seleccionada d-flex align-items-center">
                    <div class="icon-container"
                      style="display: flex; align-items: center; justify-content: center; width: 120px; height: 120px; border-radius: 50%; background-color: #fff;">
                      <i class="fa-solid fa-money-bill-trend-up"
                        style="font-size: 55px; color: #28a745; font-weight: 1px"></i>
                    </div>
                    <span class="ganancia-text"
                      style="font-size: 28px; font-weight: normal; margin-left: 45px;">Ganancia:</span>
                    <span class="ganancia-total" style="font-size: 31px; font-weight: bolder; margin-left: 5px;">S/.
                      0.00</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Espacio entre los dos contenedores -->
        <div style="margin-bottom: 20px;"></div>
        <div class="col-12 h-auto">
          <div class="card info-card sales-card">
            <!-- Filtro -->
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="card-title">
                Procesos Operativos
                <span class="filtro-seleccionado-alumnos-nuevo-antiguo">| Horas</span>
              </h5>
              <div class="filter">
                <a class="icon" data-bs-toggle="dropdown" style="color: black; font-size: 23px; cursor: pointer;">
                  <i class="fa-solid fa-ellipsis"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filtro</h6>
                  </li>
                  <li><a class="dropdown-item filtro-opcion" style="cursor: pointer;" data-value="horas">Horas</a></li>
                  <li><a class="dropdown-item filtro-opcion" style="cursor: pointer;" data-value="precio">Precio</a>
                  </li>
                </ul>
              </div>
            </div>

            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-rolodex"></i>
                </div>
                <div class="ps-3 w-100">
                  <!-- Contenedor para el gráfico -->
                  <canvas id="myChart" class="w-100" style="max-height: 500px;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
</div>