</div>
</div>

<div class="sb-sidenav-footer">
  <div class="small">Sesión iniciada como:</div>
  <?php echo $_SESSION["nombre"] ?>
</div>
</nav>
</div>

<div id="layoutSidenav_content">
  <main class="bg">
    <div class="container-fluid px-4">
      <h1 class="mt-4">
        Cotizacion D'Frida
      </h1>
    </div>

    <form role="form" method="post" class="row g-3 m-2 formNuevoIngreso">

      <div class="container row g-8" style="border: 3px solid #808080; padding: 3px; margin-left: 2px; ">

        <h3>Datos de la Empresa</h3>
        <!-- datos de la cotizacion -->
        <div class="form-group col-md-10">
          <label for="nameRes" class="form-label" style="font-weight: bold">Titulo Cotizacion:</label>
          <input type="text" class="form-control" id="dateProduction" name="dateProduction" required>
        </div>
        <div class="col-md-2">
          <label for="dateProduction" class="form-label" style="font-weight: bold">Fecha Cotizacion: </label>
          <input type="date" class="form-control" id="dateProduction" name="dateProduction" required>
        </div><br>

        <div class="form-group col-md-4">
          <label for="nameRes" class="form-label" style="font-weight: bold">Razon Social :</label>
          <input type="text" class="form-control" id="dateProduction" name="dateProduction" required>
        </div>

        <div class="form-group col-md-4">
          <label for="nameRes" class="form-label" style="font-weight: bold">Nombre Comercial :</label>
          <input type="text" class="form-control" id="dateProduction" name="dateProduction" required>
        </div>

        <div class="form-group col-md-4">
          <label for="nameRes" class="form-label" style="font-weight: bold">Ruc :</label>
          <input type="text" class="form-control" id="dateProduction" name="dateProduction" required>
        </div>
        <!-- fin -->
        <!-- datos de cliente -->
        <h3>Datos de Solicitante</h3>

        <div class="form-group col-md-6">
          <label for="DescripcionIng" class="form-label" style="font-weight: bold">Nombres Solicitante:</label>
          <input type="text" class="form-control" id="DescripcionIng" name="DescripcionIng" value=""
            placeholder="Descripcion Ingreso">
        </div>

        <div class="form-group col-md-2">
          <label for="DescripcionIng" class="form-label" style="font-weight: bold">Numero Celular:</label>
          <input type="text" class="form-control" id="DescripcionIng" name="DescripcionIng" value=""
            placeholder="Descripcion Ingreso">
        </div>

        <div class="form-group col-md-4">
          <label for="DescripcionIng" class="form-label" style="font-weight: bold">Correo:</label>
          <input type="text" class="form-control" id="DescripcionIng" name="DescripcionIng" value=""
            placeholder="Descripcion Ingreso">
        </div>

        <div class="col-md-4">
          <label for="dateVenci" class="form-label" style="font-weight: bold">Direccion: </label>
          <input type="text" class="form-control" id="dateVenci" name="dateVenci">
        </div>

        <div class="col-md-8" style="margin-bottom: 10px;">
          <label for="dateVenci" class="form-label" style="font-weight: bold">Observaciones: </label>
          <input type="text" class="form-control" id="dateVenci" name="dateVenci">
        </div>

      </div>

      <!-- Productos -->
      <div class="container row g-3" style="border: 3px solid #808080; padding: 3px; margin-left: 2px; ">
        <h3>Productos</h3>
        <div class="d-inline-flex m-2">
          <button type="button" class="btn btn-warning" data-bs-toggle="modal"
            data-bs-target="#modalAddProdCoti">Agregar Productos</button>
        </div>

        <div class="row" style="font-weight: bold">
          <div class="col-lg-4">Nombre</div>
          <div class="col-lg-2">Unidad</div>
          <div class="col-lg-2">Cantidad</div>
          <div class="col-lg-2">Precio</div>
        </div>
        <!-- aqui se agregan los productos del modal de prodcutos  -->
        <div class="form-group row AddProductoCotizacion">
          <!-- aqui se agregan los productos selecionado del modal de prodcutos  -->
        </div>
      </div>
      <!-- fin -->

      <!-- Productos materia prima-->
      <div class="container row g-3" style="border: 3px solid #808080; padding: 3px; margin-left: 2px; ">
        <h3>Productos Materia Prima</h3>
        <div class="d-inline-flex m-2">
          <button type="button" class="btn btn-warning" data-bs-toggle="modal"
            data-bs-target="#modalAddProdMprimaCoti">Agregar Productos Materia Prima</button>
        </div>

        <div class="row" style="font-weight: bold">
          <div class="col-lg-4">Nombre</div>
          <div class="col-lg-2">Unidad Medida</div>
          <div class="col-lg-2">Cantidad</div>
          <div class="col-lg-2">Precio</div>
        </div>
        <!-- aqui se agregan los productos del modal de prodcutos  -->
        <div class="form-group row AddProductoMprimaCotizacion">
        </div>
      </div>
      <!-- fin -->
      <div class="container row g-3 p-3 ">
        <button type="button" class="col-2 d-inline-flex-center p-2 btn btn-danger closeIngresoNuevo"
          style="margin-right: 10px;">Cerrar</button>
        <button type="button" class="col-2 d-inline-flex-center p-2 btn btn-success ">Registrar Cotizacion</button>
      </div>
    </form>
  </main>
</div>
</div>

<!-- Modal produtos -->
<div class="modal fade" id="modalAddProdCoti" tabindex="-1" aria-labelledby="modalAddProdCoti" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalAddProdCoti">Lista Productos </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="dataTableProductos" class="display dataTableProductos">
          <thead>
            <!-- dataTableProductos -->
          </thead>
          <tbody>
            <!--dataTableProductos-->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal produtos -->
<div class="modal fade" id="modalAddProdMprimaCoti" tabindex="-1" aria-labelledby="modalAddProdMprimaCoti"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalAddProdMprimaCoti">Lista Productos Materia Prima</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table id="dataTableProductosMprima" class="display dataTableProductosMprima">
          <thead>
            <!-- dataTableProductosMprima -->
          </thead>
          <tbody>
            <!--dataTableProductosMprima-->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>