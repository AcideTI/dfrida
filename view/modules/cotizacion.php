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

      <div class="container row g-8"
        style="border: 3px solid #808080; padding: 3px; margin-left: 2px; ">


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
              data-bs-target="#modalAddProdIng">Agregar Productos</button>
          </div>

          <div class="row" style="font-weight: bold">
            <div class="col-lg-4">Descripción</div>
            <div class="col-lg-2">Unidad</div>
            <div class="col-lg-2">Cantidad</div>
            <div class="col-lg-2">Precio</div>
          </div>
          <!-- aqui se agregan los productos del modal de prodcutos  -->
          <div class="form-group row newProductAddIng">
            <input type="hidden" id="listProducts" name="listProducts">
            <!-- aqui se agregan los productos del modal de prodcutos  -->
          </div>

        </div>
        <!-- Productos materia prima-->
        <div class="container row g-3" style="border: 3px solid #808080; padding: 3px; margin-left: 2px; ">
          <h3>Productos</h3>
          <div class="d-inline-flex m-2">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
              data-bs-target="#modalAddProdIng">Agregar Productos Materia Prima</button>
          </div>

          <div class="row" style="font-weight: bold">
            <div class="col-lg-4">Descripción</div>
            <div class="col-lg-2">Unidad</div>
            <div class="col-lg-2">Cantidad</div>
            <div class="col-lg-2">Precio</div>
          </div>
          <!-- aqui se agregan los productos del modal de prodcutos  -->
          <div class="form-group row newProductAddIng">
            <input type="hidden" id="listProducts" name="listProducts">
            <!-- aqui se agregan los productos del modal de prodcutos  -->
          </div>
        </div><br><br><br>

      <div class="container row g-3 p-3 ">
        <button type="button" class="col-2 d-inline-flex-center p-2 btn btn-danger closeIngresoNuevo" style="margin-right: 10px;">Cerrar</button>
        <button type="submit" class="col-2 d-inline-flex-center p-2 btn btn-success ">Registrar Ingreso</button>
      </div>
    </form>
  </main>
</div>
</div>




<!-- Modal Add Material -->
<div class="modal fade" id="modalAddProdIng" tabindex="-1" role="dialog" aria-labelledby="modalAddProdIng"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Listado de Productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <select name="categoriaModal" id="categoriaModal" class="form-control input-lg categoriaModal">
            <option value="">Seleccione la Categoría</option>

          </select>
        </div>
        <table id="dataTableProducts" class="display dataTableProducts" width="100%">
          <thead>
            <tr>
              <th style="width:10px">#</th>
              <th>Producto</th>
              <th>Categoria</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary pull-left" data-bs-dismiss="modal">Salir</button>
      </div>
    </div>
  </div>
</div>