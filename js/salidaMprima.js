//campo de proceso oprativo añadifo
//funcion para mostrar el selec2 de selecionar proceso Operativo
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprima";
  if (currentPath == appPath) {
    // Verificar si el botón existe en el DOM
    var btnProcesoOperativoAdd = document.getElementById(
      "btnProcesoOperativoAdd"
    );
    if (btnProcesoOperativoAdd) {
      // Inicializar Select2
      btnProcesoOperativoAdd.addEventListener("click", function () {
        Swal.fire({
          title: "¿Ya ha creado un Proceso Operativo para esta salida?",
          text: "Puede asignar esta salida desde la creación del proceso operativo también. Puede omitir este paso con, No.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "No, lo asignaré después.",
          confirmButtonText: "Sí, asignar proceso ya creado.",
        }).then((result) => {
          if (result.isConfirmed) {
            // Cambiar el botón por un campo select
            var container = document.getElementById("procesoOperativoAdd");
            container.innerHTML = `
              <select class="form-control select2" id="pedidoSalProdAdd" name="pedidoSalProdAdd">
                <option value="">Seleccione un proceso operativo</option>
              </select>
            `;

            // Inicializar Select2 en el nuevo campo select
            $("#pedidoSalProdAdd").select2();

            // Cargar datos dinámicamente al confirmar
            var data = new FormData();
            data.append("todosLosProcesoOperativosMprima", true);

            $.ajax({
              url: "ajax/salidaMprima.ajax.php",
              method: "POST",
              data: data,
              contentType: false,
              processData: false,
              dataType: "json",
              success: function (data) {
                // Limpiar las opciones actuales
                $("#pedidoSalProdAdd").empty();
                $("#pedidoSalProdAdd").append(
                  '<option value="0">Seleccionar Proceso Operativo</option>'
                );
                // Agregar las nuevas opciones
                $.each(data, function (key, value) {
                  $("#pedidoSalProdAdd").append(
                    '<option value="' +
                      value.idProcOp +
                      '">' +
                      value.nombreProcOp +
                      "</option>"
                  );
                });
                // Actualizar Select2 después de agregar las opciones
                $("#pedidoSalProdAdd").trigger("change");
              },
              error: function (xhr, status, error) {
                console.error("Error al cargar los datos:", error);
              },
            });
          }
        });
      });
    } else {
      console.error(
        'El elemento con id "btnProcesoOperativoAdd" no se encontró en el DOM.'
      );
    }
  }
});
//fin

//agregar productos a ingreso productos prima****
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprima";
  if (currentPath == appPath) {
    // Definir un contador global para los IDs de formulario no taocar
    var formularioIngProdCounter = 1;

    // variable global guardar los codigos de los productos agregados no tocar
    window.codigosProductosAgregados = new Set();
    //console.log(window.codigosProductosAgregados); // Mostrar el estado actual
    // Variable global acumulativa para almacenar datos del formulario, idProd y cantidad para validar cantidad maxima en almacen no tocar
    window.datosFormularios = [];
    //onsole.log(datosFormularios);

    $(".dataTableProductosSalidaAlmacenMprima").on(
      "click",
      ".btnAddProdModalSal",
      function () {
        var codAddSalProdModal = $(this).attr("codAddSalProdModal");
        // Primero, verificar si el string es vacío antes de cualquier conversión
        if (codAddSalProdModal.trim() === "") {
          return; // No proceder con el resto de la función si el string es vacío
        }
        // Convertir el código a entero antes de verificar y agregar
        var codAddSalProdModal = parseInt(codAddSalProdModal, 10);

        // Validar que el código no sea NaN, cero, o el string no sea vacío
        if (
          isNaN(codAddSalProdModal) ||
          codAddSalProdModal === 0
          //codAddSalProdModal.trim() === ""
        ) {
          return; // No proceder con el resto de la función
        }

        // Verificar si el código ya ha sido agregado
        if (window.codigosProductosAgregados.has(codAddSalProdModal)) {
          // Cerrar el modal antes de mostrar el mensaje de SweetAlert
          $("#modalAddProdSali").modal("hide");
          Swal.fire({
            icon: "warning",
            title: "Producto Prima duplicado",
            text: "El producto ya está en la lista.",
          }).then((result) => {
            if (result.value) {
              // Mostrar el modal de nuevo
              $("#modalAddProdSali").modal("show");
            }
          });
          return; // No proceder con el AJAX
        }

        // Agregar el código al conjunto de productos agregados como entero
        window.codigosProductosAgregados.add(codAddSalProdModal);
        //console.log(window.codigosProductosAgregados); // Mostrar el estado actual

        var datos = new FormData();
        datos.append("codAddSalProdModal", codAddSalProdModal);
        $.ajax({
          url: "ajax/salidaMprima.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (respuesta) {
            var idProd = respuesta["idMprima"];
            var nombreProd = respuesta["nombreMprimaAlma"];
            var codigoProd = respuesta["codigoMprimaAlma"];
            var unidadProd = respuesta["unidadMprimaAlma"];
            var precioProd = respuesta["precioMprima"];
            //cantidad
            var cantidadProd = respuesta["cantidadMprimaAlma"];

            // Crear un nuevo formulario para el producto con un ID único que incrementa en 1 cada vez que se agrega un producto
            var formularioID = "formularioIngProd" + formularioIngProdCounter++;
            var nuevoProductoHTML =
              '<form id="' +
              formularioID +
              '" class="row productoRow" style="padding:5px 15px">' +
              '<div class="col-lg-2">' +
              /* id del prodcuto */
              '<input type="hidden" class="form-control" id="codProdIng" value="' +
              idProd +
              '">' +
              /* nombre del producto */
              '<input type="text" class="form-control" id="nombreProdIng" value="' +
              nombreProd +
              '" readonly>' +
              "</div>" +
              /* codigo del producto */
              '<div class="col-lg-2">' +
              '<input type="text" class="form-control" id="codigoProdIng" value="' +
              codigoProd +
              '" readonly>' +
              "</div>" +
              /* unidad del tipo de producto */
              '<div class="col-lg-2">' +
              '<input type="text" class="form-control" id="unidadProdIng"value="' +
              unidadProd +
              '" readonly>' +
              "</div>" +
              /* cantidad editable inicia en 1 */
              '<div class="col-lg-2">' +
              '<input type="number" class="form-control cantidadProdIng" id="cantidadProdIng" value="1" min="1" step="1" data-original-idProd="' +
              idProd +
              '">' +
              "</div>" +
              /* precio */
              '<div class="col-lg-2">' +
              '<input type="text" class="form-control precioProdIng" id="precioProdIng" value="' +
              precioProd +
              '" data-original-precio="' +
              precioProd +
              '" readonly>' +
              "</div>" +
              /* boton de eliminar */
              '<div class="col-lg-1">' +
              '<button type="button" class="btn btn-danger btn-xs deleteNuevoIngresoProd" id="deleteNuevoIngresoProd" value="' +
              idProd +
              '"><i class="fa fa-times"></i></button>' +
              "</div>" +
              "</form>";

            // Agregar el nuevo formulario al contenedor
            $(".AddProductoSalida").append(nuevoProductoHTML);

            //agregar la cantidad a la variable gloval contadora
            var nuevoDatoFormulario = [formularioID, idProd, cantidadProd];
            window.datosFormularios.push(nuevoDatoFormulario);
            //console.log(datosFormularios);
          },
        });
      }
    );

    // funcion para actualizar el precio y validar la cantidad y mostrar la cantidad maxima en almacen
    $(document).on(
      "input",
      ".cantidadProdIng",
      actualizarPrecioYValidarCantidad
    );

    // Eliminar el producto
    $(document).on("click", ".deleteNuevoIngresoProd", function (e) {
      // Paso 1: Capturar el valor del botón presionado y convertirlo a número entero
      var valorBoton = parseInt($(this).val(), 10);
      //console.log("Valor del botón presionado:", valorBoton);
      // Paso 2: Copiar los datos de la variable global a una nueva
      var datosTemporales = new Set(codigosProductosAgregados);
      // Paso 3: Buscar y eliminar el valor del botón en la nueva variable
      if (datosTemporales.has(valorBoton)) {
        datosTemporales.delete(valorBoton);
      } else {
        //console.log("El valor no se encontró en la variable global.");
      }
      // Paso 4: Limpiar la variable global
      codigosProductosAgregados.clear();
      // Paso 5: Actualizar la variable global con los nuevos datos
      datosTemporales.forEach((valor) => {
        codigosProductosAgregados.add(valor);
      });
      // Eliminar el formulario del producto del DOM
      $(this).closest(".productoRow").remove();
    });
    //fin agregar productos
    ///fin vericar ruta
  }
});
//fin agreagr productos
// TOTALES
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprima";
  if (currentPath == appPath) {
    //funcion para calcular los totales
    $(document).ready(function () {
      function calcularTotalSalida() {
        //guarda el valor de los productos y productos prima en 0 para  sumar los precios
        let totalProductos = 0;

        //busca todos los formularios que comiencen con formularioIngProd = productos
        // Sumar los precios de todos los productos
        $("[id^=formularioIngProd]").each(function () {
          const precio = parseFloat($(this).find("#precioProdIng").val()) || 0;
          //toma el valor del input con id precioProdIng y lo convierte a float
          totalProductos += precio;
        });

        // Asignar el totalProducto al input de totalIngProdAddList y actualizar el atributo 'value'
        $("#totalIngProdAddList")
          .val(totalProductos.toFixed(2))
          .attr("value", totalProductos.toFixed(2));

        // Calcular el total general
        const totalGeneral = totalProductos;

        // Asignar el totalGeneral al input de subTotalIngProdAdd y actualizar el atributo 'value'
        $("#subTotalIngProdAdd")
          .val(totalGeneral.toFixed(2))
          .attr("value", totalGeneral.toFixed(2));

        // Asignar un valor estático de 0 a igvIngProdAdd y actualizar el atributo 'value'
        $("#igvIngProdAdd").val(0).attr("value", 0);
        // Calcular el totalCotizacion como la suma de totalGeneral + igvIngProdAdd
        const igvIngProdAdd = parseFloat($("#igvIngProdAdd").val()) || 0;

        // Calcular el 18% de totalGeneral para igvIngProdAdd y actualizar el atributo 'value'
        //const igvIngProdAdd = totalGeneral * 0.18;
        //$("#igvIngProdAdd").val(igvIngProdAdd).attr("value", igvIngProdAdd);

        const totalIngProdAdd = totalGeneral + igvIngProdAdd;

        // Asignar el totalCotizacion al input de totalCotizacion y actualizar el atributo 'value'
        $("#totalIngProdAdd")
          .val(totalIngProdAdd.toFixed(2))
          .attr("value", totalIngProdAdd.toFixed(2));
      }

      //botón para calcular el total
      $("#btnCalcularTotalIng").click(function () {
        calcularTotalSalida();
      });
    });
    //fin vericar ruta
  }
});
//FIN TOTALES

//  crear salida productos
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprima";
  if (currentPath == appPath) {
    //escuchar el evento click en el boton registrar cotizacion
    const btnRegistrar = document.getElementById("btnRegistrarSalidaProd");
    btnRegistrar.addEventListener("click", function () {
      let camposRequeridos = [
        { id: "tituloSalProdAdd", nombre: "Titulo salida producto prima" },
        { id: "fechaSalProdAdd", nombre: "Fecha salida" },
        { id: "subTotalIngProdAdd", nombre: "Sub Total " },
        { id: "totalIngProdAdd", nombre: "Total Producto" },
      ];
      let formularioValido = true;
      //verificar que los campos de total cotizacion no esten vacios
      camposRequeridos.forEach(function (campo) {
        let input = document.getElementById(campo.id);
        if (!input.value || parseFloat(input.value) === 0) {
          formularioValido = false;
          input.classList.add("is-invalid");

          Swal.fire({
            icon: "error",
            title: "Campo Requerido",
            html: `Complete el campo <b>${campo.nombre}</b> verifique que los <b>Totales</b> no sean <b>0</b> oprima en el botón <b>Calcular</b>.`,
          });
          return;
        } else {
          input.classList.remove("is-invalid"); // Remueve la clase de error si el campo está lleno y no es 0
        }
      });

      if (!formularioValido) {
        // Si el formulario no es válido, se detiene aquí. El mensaje ya fue mostrado por SweetAlert2.
        return;
        // Si el formulario es válido, se procede con la CREACION
      } else {
        // Aquí puedes añadir la lógica para enviar el formulario manualmente o cualquier otra acción
        //console.log("Formulario válido, proceder con la acción deseada.");
        // Simula la pulsación del botón "btnCalcularTotalIng" para asegurar que los totales estén actualizados si el usuario no lo hizo
        document.getElementById("btnCalcularTotalIng").click();
        /* fin click calcular total */
        //recolectar los datos del formulario principal
        var formulario = document.getElementById("formSalidaMprima");
        var datosFormulario = {};
        var elementosFormulario = formulario.querySelectorAll("input, select");
        elementosFormulario.forEach(function (elemento) {
          if (elemento.id) {
            datosFormulario[elemento.id] = elemento.value;
          }
        });
        // Crear un JSON con los datos recolectados del formulario principal
        var jsonCrearSalidaProd = JSON.stringify(datosFormulario);

        // Llamada a la función para recolectar datos de formularios anidados PRODUCTOS
        recojerFormulariosAnidadosIngProductos(function (
          datosFormulariosProductos
        ) {
          // Crear un JSON con los datos recolectados de los formularios anidados
          var jsonProductosSalidaProd = JSON.stringify(
            datosFormulariosProductos
          );

          $.ajax({
            url: "ajax/salidaMprima.ajax.php",
            method: "POST",
            data: {
              jsonCrearSalidaProd: jsonCrearSalidaProd,
              jsonProductosSalidaProd: jsonProductosSalidaProd,
            },
            dataType: "json",
            success: function (response) {
              // Función para limpiar los datos de la URL
              var limpiarURL = function () {
                window.history.pushState(
                  {},
                  document.title,
                  window.location.pathname
                );
              };

              if (response == "ok") {
                Swal.fire({
                  icon: "success",
                  title: "Correcto",
                  html: "Retiro de productos de Almacen Prima Correctamente<br> <strong>¿Desea Crear Otro retiro?</strong> ",
                  showCancelButton: true,
                  confirmButtonText: "Si",
                  cancelButtonText: "No",
                }).then(function (result) {
                  if (result.value) {
                    limpiarURL(); // Llamar a la función para limpiar la URL
                    window.location.reload(); // Recargar la página
                  } else {
                    window.location.href = "/dfrida/salidaMprimaList"; // Redirigir a la
                  }
                });
              } else if (response == "errorSalAlmacen") {
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  html: "Un producto que se intenta retirar es negativo o esta en 0 en Almacen Prima <strong>¿Desea verificar el Almacen?</strong>.",
                  showCancelButton: true,
                  confirmButtonText: "Si",
                  cancelButtonText: "No",
                }).then(function (result) {
                  if (result.value) {
                    window.location.href = "/dfrida/almacenMateriaPrima"; // Redirigir a la
                  } else {
                    limpiarURL(); // Llamar a la función para limpiar la URL
                    //window.location.reload(); // Recargar la página
                  }
                });
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  html: "No se pudo crear el registro de Salida <strong>¿Desea Crear Otro?</strong>.",
                  showCancelButton: true,
                  confirmButtonText: "Si",
                  cancelButtonText: "No",
                }).then(function (result) {
                  if (result.value) {
                    limpiarURL(); // Llamar a la función para limpiar la URL
                    window.location.reload(); // Recargar la página
                  } else {
                    window.location.href = "/dfrida/salidaMprimaList"; // Redirigir a la vista de cotizacionList
                  }
                });
              }
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.log(
                "Error en la solicitud AJAX: ",
                textStatus,
                errorThrown
              );
            },
          });
          // Fin de la llamada AJAX
        });

        //funcion para recolectar los datos de los formularios productos y productos prima
        function recojerFormulariosAnidadosIngProductos(callback) {
          //alamcena los datos de los formularios productos y productos prima
          let datosFormulariosProductos = {};

          // Recorrer los formularios de productos
          $("[id^=formularioIngProd]").each(function (index) {
            let datosFormulario = {};
            $(this)
              .find("input, select")
              .each(function () {
                if (this.id) {
                  datosFormulario[this.id] = $(this).val();
                }
              });
            datosFormulariosProductos["producto" + index] = datosFormulario;
          });

          // Llamar al callback con los datos recolectados de ambos formularios
          if (callback && typeof callback === "function") {
            callback(datosFormulariosProductos);
          }
        }
        //fin agregar productos
      }
    });
    //fin verificar que los campos
  }
});
//fin agregar y crear Salida****

//****funciones para editar producto prima ////
//agrergar productos
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprimaEdit";
  if (currentPath == appPath) {
    // Definir un contador global para los IDs de formulario no tocar
    var formularioIngProdCounter = 1;

    // guardar los codigos de los productos agregados no tocar
    window.codigosProductosAgregados = new Set();
    //console.log(window.codigosProductosAgregados);
    // Variable global acumulativa para almacenar datos del formulario, idProd y cantidad para validar cantidad maxima en almacen no tocar
    window.datosFormularios = [];
    //console.log(datosFormularios);

    //agregar producto de modal a formulario
    $(".dataTableProductosSalidaAlmacenMprima").on(
      "click",
      ".btnAddProdModalSal",
      function () {
        var codAddSalProdModal = $(this).attr("codAddSalProdModal");

        // Primero, verificar si el string es vacío antes de cualquier conversión
        if (codAddSalProdModal.trim() === "") {
          return; // No proceder con el resto de la función si el string es vacío
        }
        // Convertir el código a entero antes de verificar y agregar
        var codAddSalProdModal = parseInt(codAddSalProdModal, 10);
        // Validar que el código no sea NaN, cero, o el string no sea vacío
        if (
          isNaN(codAddSalProdModal) ||
          codAddSalProdModal === 0
          //codAddSalProdModal.trim() === ""
        ) {
          return; // No proceder con el resto de la función
        }
        //console.log(window.codigosProductosAgregados); // Mostrar el estado actual
        // Verificar si el código ya ha sido agregado
        if (window.codigosProductosAgregados.has(codAddSalProdModal)) {
          // Cerrar el modal antes de mostrar el mensaje de SweetAlert
          $("#modalAddProdSali").modal("hide");
          Swal.fire({
            icon: "warning",
            title: "Producto duplicado",
            text: "El producto ya está en la lista.",
          }).then((result) => {
            if (result.value) {
              // Mostrar el modal de nuevo
              $("#modalAddProdSali").modal("show");
            }
          });
          return; // No proceder con el AJAX
        }

        // Agregar el código al conjunto de productos agregados como entero
        window.codigosProductosAgregados.add(codAddSalProdModal);
        // console.log(window.codigosProductosAgregados); // Mostrar el estado actual

        var datos = new FormData();
        datos.append("codAddSalProdModal", codAddSalProdModal);
        $.ajax({
          url: "ajax/salidaMprima.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (respuesta) {
            var idProd = respuesta["idMprima"];
            var nombreProd = respuesta["nombreMprimaAlma"];
            var codigoProd = respuesta["codigoMprimaAlma"];
            var unidadProd = respuesta["unidadMprimaAlma"];
            var precioProd = respuesta["precioMprima"];
            //cantidad
            var cantidadProd = respuesta["cantidadMprimaAlma"];

            // Crear un nuevo formulario para el producto con un ID único que incrementa en 1 cada vez que se agrega un producto
            var formularioID = "formularioIngProd" + formularioIngProdCounter++;
            var nuevoProductoHTML =
              '<form id="' +
              formularioID +
              '" class="row productoRow" style="padding:5px 15px">' +
              '<div class="col-lg-2">' +
              /* id del prodcuto */
              '<input type="hidden" class="form-control" id="codProdIng" value="' +
              idProd +
              '">' +
              /* nombre del producto */
              '<input type="text" class="form-control" id="nombreProdIng" value="' +
              nombreProd +
              '" readonly>' +
              "</div>" +
              /* codigo del producto */
              '<div class="col-lg-2">' +
              '<input type="text" class="form-control" id="codigoProdIng" value="' +
              codigoProd +
              '" readonly>' +
              "</div>" +
              /* unidad del tipo de producto */
              '<div class="col-lg-2">' +
              '<input type="text" class="form-control" id="unidadProdIng"value="' +
              unidadProd +
              '" readonly>' +
              "</div>" +
              /* cantidad editable inicia en 1 */
              '<div class="col-lg-2">' +
              '<input type="number" class="form-control cantidadProdIng" id="cantidadProdIng" value="1" min="1" step="1" data-original-idProd="' +
              idProd +
              '">' +
              "</div>" +
              /* precio */
              '<div class="col-lg-2">' +
              '<input type="text" class="form-control precioProdIng" id="precioProdIng" value="' +
              precioProd +
              '" data-original-precio="' +
              precioProd +
              '" readonly>' +
              "</div>" +
              /* boton de eliminar */
              '<div class="col-lg-1">' +
              '<button type="button" class="btn btn-danger btn-xs deleteNuevoIngresoProd" id="deleteNuevoIngresoProd" value="' +
              idProd +
              '"><i class="fa fa-times"></i></button>' +
              "</div>" +
              "</form>";

            // Agregar el nuevo formulario al contenedor
            $(".AddProductoSalida").append(nuevoProductoHTML);

            //agregar la cantidad a la variable gloval contadora
            var nuevoDatoFormulario = [formularioID, idProd, cantidadProd];
            window.datosFormularios.push(nuevoDatoFormulario);
            //console.log(datosFormularios);
          },
        });
      }
    );

    // verificar la cantidad de productos en almacen y actualizar el precio al maximo de almacen
    $(document).on(
      "input",
      ".cantidadProdIng",
      actualizarPrecioYValidarCantidad
    );

    // Eliminar el producto y eliminarlo de la variable global para volver a ingresarlo
    $(document).on("click", ".deleteNuevoIngresoProd", function (e) {
      // Paso 1: Capturar el valor del botón presionado y convertirlo a número entero
      var valorBoton = parseInt($(this).val(), 10);
      //console.log("Valor del botón presionado:", valorBoton);
      // Paso 2: Copiar los datos de la variable global a una nueva variable (manteniendo el formato de Set)
      var datosTemporales = new Set(codigosProductosAgregados);

      // Paso 3: Buscar y eliminar el valor del botón en la nueva variable
      if (datosTemporales.has(valorBoton)) {
        datosTemporales.delete(valorBoton);
      } else {
        //console.log("El valor no se encontró en la variable global.");
      }
      // Paso 4: Limpiar la variable global
      codigosProductosAgregados.clear();
      // Paso 5: Actualizar la variable global con los nuevos datos
      datosTemporales.forEach((valor) => {
        codigosProductosAgregados.add(valor);
      });
      // Eliminar el formulario del producto del DOM que asu ves el array contenedor del id del producto recojido del btoon
      $(this).closest(".productoRow").remove();
    });
    //fin agregar productos
    //fin vericar ruta
  }
});
//fin agreagr productos

//*****funcion para validad cantidades de alamacen y actualizar precio y mostrar mensaje de cantidad maxima
// Actualizar el precio cuando cambia la cantidad y valida y muestra la cantidad maxiama en // Definir la función globalmente
function actualizarPrecioYValidarCantidad(event) {
  var input = $(event.target);
  var count = input.val();
  var idProd = input.data("original-idprod");
  var precioPerUnit = input
    .closest(".productoRow")
    .find(".precioProdIng")
    .data("original-precio");

  // Lógica para calcular el precio final
  var precioFinal = "0";
  if (count !== "" && parseInt(count) !== 0) {
    precioFinal = (count * precioPerUnit).toFixed(2);
  }

  // Verificar si el campo tiene exactamente 0 y mostrar alerta
  if (count === "0") {
    Swal.fire({
      icon: "warning",
      title: "Cantidad Inválida",
      html: "La cantidad no puede ser 0.",
    }).then((result) => {
      if (result.value) {
        count = 1;
        precioFinal = (count * precioPerUnit).toFixed(2);
        input.val(count).attr("value", count);
        input
          .closest(".productoRow")
          .find(".precioProdIng")
          .val(precioFinal)
          .attr("value", precioFinal);
      }
    });
    return; // Salir de la función para evitar continuar con la lógica
  }

  // Actualizar el valor interno y el atributo 'value' en el HTML
  input.val(count).attr("value", count);
  input
    .closest(".productoRow")
    .find(".precioProdIng")
    .val(precioFinal)
    .attr("value", precioFinal);

  // Lógica para mostrar el mensaje basado en la cantidad
  var formularioID = "";
  var cantidadInicial = 0;
  window.datosFormularios.forEach(function (item) {
    //console.log(item);
    if (item[1] === idProd) {
      formularioID = item[0];
      cantidadInicial = item[2];
    }
  });

  if (formularioID && parseInt(count) > cantidadInicial) {
    Swal.fire({
      icon: "info",
      title: "Cantidad Excedente",
      html: "La cantidad máxima en almacén es <b>" + cantidadInicial + "</b>.",
    }).then((result) => {
      if (result.value) {
        input.val(cantidadInicial).attr("value", cantidadInicial);
        var precioFinalMax = (cantidadInicial * precioPerUnit).toFixed(2);
        input
          .closest(".productoRow")
          .find(".precioProdIng")
          .val(precioFinalMax)
          .attr("value", precioFinalMax);
      }
    });
  }
}
//***fin validar cantidad y actualizar precio */

// TOTALES
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprimaEdit";
  if (currentPath == appPath) {
    //funcion para calcular los totales
    $(document).ready(function () {
      function calcularTotalSalida() {
        //guarda el valor de los productos y productos prima en 0 para  sumar los precios
        let totalProductos = 0;

        //busca todos los formularios que comiencen con formularioIngProd = productos
        // Sumar los precios de todos los productos
        $("[id^=formularioIngProd]").each(function () {
          const precio = parseFloat($(this).find("#precioProdIng").val()) || 0;
          //toma el valor del input con id precioProdIng y lo convierte a float
          totalProductos += precio;
        });

        // Asignar el totalProducto al input de totalIngProdAddList y actualizar el atributo 'value'
        $("#totalIngProdAddList")
          .val(totalProductos.toFixed(2))
          .attr("value", totalProductos.toFixed(2));

        // Calcular el total general
        const totalGeneral = totalProductos;

        // Asignar el totalGeneral al input de subTotalIngProdAdd y actualizar el atributo 'value'
        $("#subTotalIngProdAdd")
          .val(totalGeneral.toFixed(2))
          .attr("value", totalGeneral.toFixed(2));

        // Asignar un valor estático de 0 a igvIngProdAdd y actualizar el atributo 'value'
        $("#igvIngProdAdd").val(0).attr("value", 0);
        // Calcular el total como la suma de totalGeneral + igvIngProdAdd
        const igvIngProdAdd = parseFloat($("#igvIngProdAdd").val()) || 0;

        // Calcular el 18% de totalGeneral para igvIngProdAdd y actualizar el atributo 'value'
        //const igvIngProdAdd = totalGeneral * 0.18;
        //$("#igvIngProdAdd").val(igvIngProdAdd).attr("value", igvIngProdAdd);

        const totalIngProdAdd = totalGeneral + igvIngProdAdd;

        // Asignar el total al input de total y actualizar el atributo 'value'
        $("#totalIngProdAdd")
          .val(totalIngProdAdd.toFixed(2))
          .attr("value", totalIngProdAdd.toFixed(2));
      }

      //botón para calcular el total
      $("#btnCalcularTotalIng").click(function () {
        calcularTotalSalida();
      });
    });
    //fin vericar ruta
  }
});
//FIN TOTALES
////

//editar ingreso productos
// Enviar código a la vista de editar tomadnodlo el valor del boton
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprimaList";
  if (currentPath == appPath) {
    $(".dataTableSalidasMprima").on("click", ".btnEditarSalProd", function () {
      swal
        .fire({
          title:
            "¡Editar la Salida Productos Prima Puede generar negativos y exedentes!",
          text: "¡Esta accion afectara directamente al almacen!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Si, Editar Salida!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            var codSalMprima = $(this).attr("codSalMprima");
            // Usar la variable directamente en la URL de redirección
            window.location.href =
              "/dfrida/salidaMprimaEdit?codSalMprima=" + codSalMprima;
          }
        });
    });
  }
});
// Fin

//tomar el valor de la url y asignarlo al campo oculto
function getQueryParam(name) {
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(window.location.href);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}
//variable gloval para contar los formularios  de edit a agregar los que llegan de respeusta ajax visualizar datos  y los nuevos que sea greagaran
window.formularioIngProdCounter = 1;

document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprimaEdit";
  if (currentPath == appPath) {
    // Función para obtener el valor de un parámetro por nombre

    //funcion para mostrar el selec2 de selecionar proceso Operativo edit

    // Inicializar Select2
    // Función para manejar el evento change
    let warningConfirmed = false; // Variable de estado

    function handleSelectOpening(e) {
      if (warningConfirmed) {
        // Si el mensaje ya fue confirmado, permitir la apertura del select2
        warningConfirmed = false; // Resetear el estado para futuras interacciones
        return;
      }
      e.preventDefault(); // Prevenir la apertura del select2
      Swal.fire({
        title: "Advertencia",
        text: "Modificar este campo afectará al proceso operativo. ¿Desea continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, modificar",
        cancelButtonText: "No, cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          // Si el usuario confirma, permitir la apertura del select2
          warningConfirmed = true; // Actualizar el estado
          $("#pedidoSalProdEdit").select2("open");
        }
      });
    }

    // Función para cargar los datos de proceso operativo en el select2
    function Select2EditMprima(id, nombre) {
      $("#pedidoSalProdEdit").select2();
      // Cargar datos dinámicamente al abrir el modal
      var data = new FormData();
      data.append("todosLosProcesoOperativosMprimaEdit", true);
      $.ajax({
        url: "ajax/salidaMprima.ajax.php",
        method: "POST",
        data: data,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (data) {
          // Limpiar las opciones actuales
          $("#pedidoSalProdEdit").empty();
          // Agregar las nuevas opciones
          $.each(data, function (key, value) {
            $("#pedidoSalProdEdit").append(
              '<option value="' +
                value.idProcOp +
                '">' +
                value.nombreProcOp +
                "</option>"
            );
          });

          // Inicializar Select2 después de agregar las opciones
          $("#pedidoSalProdEdit").select2();

          // Seleccionar la opción específica
          $("#pedidoSalProdEdit").val(id).trigger("change");

          // Asignar la función handleSelectOpening al evento select2:opening solo si warningConfirmed es false
          if (!warningConfirmed) {
            $("#pedidoSalProdEdit").on("select2:opening", handleSelectOpening);
          }
        },

        error: function (xhr, status, error) {
          console.error("Error al cargar los datos:", error);
        },
      });
    }
    //fin

    // Inicializar Select2 pedidos
    // Función para manejar el evento change
    let warningConfirmedPedido = false; // Variable de estado

    function handleSelectOpeningPedido(e) {
      if (warningConfirmedPedido) {
        // Si el mensaje ya fue confirmado, permitir la apertura del select2
        warningConfirmedPedido = false; // Resetear el estado para futuras interacciones
        return;
      }
      e.preventDefault(); // Prevenir la apertura del select2
      Swal.fire({
        title: "Advertencia",
        text: "Modificar este campo afectará al proceso operativo. ¿Desea continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, modificar",
        cancelButtonText: "No, cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          // Si el usuario confirma, permitir la apertura del select2
          warningConfirmedPedido = true; // Actualizar el estado
          $("#pedidoAddSalProdEdit").select2("open");
        }
      });
    }
    // Función para cargar los datos de pedidos en el select2
    function Select2EditMprimaPedido(id, nombre) {
      $("#pedidoAddSalProdEdit").select2();
      // Cargar datos dinámicamente al abrir el modal
      var data = new FormData();
      data.append("todosLosPedidosMprimaEdit", true);
      $.ajax({
        url: "ajax/salidaMprima.ajax.php",
        method: "POST",
        data: data,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (data) {
          // Limpiar las opciones actuales
          $("#pedidoAddSalProdEdit").empty();
          // Agregar las nuevas opciones
          $.each(data, function (key, value) {
            $("#pedidoAddSalProdEdit").append(
              '<option value="' +
                value.idPedido +
                '">' +
                value.nombrePedido +
                "</option>"
            );
          });

          // Inicializar Select2 después de agregar las opciones
          $("#pedidoAddSalProdEdit").select2();

          // Seleccionar la opción específica
          $("#pedidoAddSalProdEdit").val(id).trigger("change");

          // Asignar la función handleSelectOpening al evento select2:opening solo si warningConfirmed es false
          if (!warningConfirmedPedido) {
            $("#pedidoAddSalProdEdit").on(
              "select2:opening",
              handleSelectOpeningPedido
            );
          }
        },

        error: function (xhr, status, error) {
          console.error("Error al cargar los datos:", error);
        },
      });
    }
    //fin
    // Extraer el valor de 'codFichaTec' de la URL
    var codSalMprima = getQueryParam("codSalMprima");
    if (codSalMprima) {
      // Asignar el valor extraído al campo oculto
      document.getElementById("codSalMprima").value = codSalMprima;

      // Eliminar el parámetro 'codFichaTec' de la URL
      var newUrl = window.location.pathname;
      history.replaceState(null, "", newUrl);
    }

    //editar ficha tecnica
    //obtener el valor guardado en el campo oculto cuando carga la pagina
    var codSalMprima = document.getElementById("codSalMprima").value;
    var data = new FormData();
    data.append("codSalMprima", codSalMprima);
    //visualizar los datos
    $.ajax({
      url: "ajax/salidaMprima.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        $("#codSalMprima").val(response["idSalMprima"]);
        $("#tituloSalProdEdit").val(response["nombreSalMprima"]);
        $("#fechaSalProdEdit").val(response["fechaSalMprima"]);
        $("#igvIngProdAdd").val(response["igvSalMprima"]);
        $("#subTotalIngProdAdd").val(response["subTotalSalMprima"]);
        $("#totalIngProdAdd").val(response["totalSalMprima"]);
        $("#totalIngProdAddList").val(response["totalSalMprima"]);
        $("#salidaAnteriorJsonEdit").val(response["salJsonMprima"]);
        if (response.hasOwnProperty("salJsonMprima")) {
          ingresoProductoEdit(response["salJsonMprima"]);
        }
        // Llamar a la función Select2EditMprima con los datos recibidos
        Select2EditMprima(response["idProcOp"], response["nombreProcOp"]);
        // Llamar a la función Select2EditMprima con los datos recibidos
        Select2EditMprimaPedido(response["idPedido"], response["nombrePedido"]);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });

    //promesa para obtener el stock de los productos de almacen y sumarlo ala cantidad de la salida para mostrar un maximo a editar y tambien el precio del porducto
    // Modificación de obtenerStock para que retorne una promesa la funcion retorana la cantidad ala funcion de *insertarFormulario*
    function obtenerStockMprima(codProdIng) {
      return new Promise((resolve, reject) => {
        var data = new FormData();
        data.append("codProdIng", codProdIng);
        $.ajax({
          url: "ajax/salidaMprima.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            resolve({
              cantidadProdAlma: response["cantidadMprimaAlma"],
              precioProd: response["precioMprima"],
            }); // Resuelve la promesa con un objeto que contiene ambos valores
          },
          error: function (jqXHR, textStatus, errorThrown) {
            reject(
              "Error en la solicitud AJAX: " + textStatus + " " + errorThrown
            ); // Rechaza la promesa si hay un error
          },
        });
      });
    }

    // Uso de async/await en ingresoProductoEdit para esperar la respuesta de obtenerStock
    async function ingresoProductoEdit(salJsonMprima) {
      // Decodificar el JSON recibido de la respeusta de visualiar datos
      const procesos = JSON.parse(salJsonMprima);

      // Mostrar el modal de carga por que la promesa es asincrona y espera la respuesta para crear el formulario
      //el usuario visualizara una demora en al carga de los datos
      Swal.fire({
        title: "Cargando...",
        text: "Por favor, espere mientras se procesan los datos.",
        allowOutsideClick: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });
      //recorre todos los arrays decodificado del json para crear un formulario por cada producto resuelto
      for (const proceso of Object.values(procesos)) {
        const {
          codProdIng,
          nombreProdIng,
          codigoProdIng,
          unidadProdIng,
          cantidadProdIng,
          precioProdIng,
        } = proceso;

        // Convertir el código del producto a entero antes de agregarlo a la variable global
        //que valida los productos agregados a la lista
        var codProdIngInt = parseInt(codProdIng, 10);
        codAddSalProdModal = codProdIngInt;
        // Agregar el código del producto a la variable global
        codigosProductosAgregados.add(codAddSalProdModal);
        //console.log(codigosProductosAgregados); // Mostrar el estado actual

        // Esperar la respuesta de obtenerStock
        try {
          // Enviar el id de producto a la función de obtener stock para traer el stock del almacén
          const { cantidadProdAlma, precioProd } = await obtenerStockMprima(
            codProdIng
          );
          insertarFormulario(
            codProdIng,
            nombreProdIng,
            codigoProdIng,
            unidadProdIng,
            cantidadProdIng,
            precioProdIng,
            cantidadProdAlma,
            precioProd
          );
        } catch (error) {
          console.error(error); // Manejar el error si la promesa es rechazada
        }
      }

      // Cerrar el modal de carga una vez que se haya completado el procesamiento
      Swal.close();
    }

    function insertarFormulario(
      codProdIng,
      nombreProdIng,
      codigoProdIng,
      unidadProdIng,
      cantidadProdIng,
      precioProdIng,
      cantidadProdStock,
      precioProd,
      //valores para la varible global que espera estos datos para inicar la funcion de cantidades maximas editables
      cantidadProd = Number(cantidadProdStock) + Number(cantidadProdIng),
      idProd = codProdIng
    ) {
      var formularioID = "formularioIngProd" + formularioIngProdCounter++;
      var nuevoProductoHTML = `
        <form id="${formularioID}" class="row productoRow" style="padding:5px 15px">
          <div class="col-lg-2">
            <!-- id del producto -->
            <input type="hidden" class="form-control" id="codProdIng" value="${idProd}">
            <!-- nombre del producto -->
            <input type="text" class="form-control" id="nombreProdIng" value="${nombreProdIng}" readonly>
          </div>
          <!-- codigo del producto -->
          <div class="col-lg-2">
            <input type="text" class="form-control" id="codigoProdIng" value="${codigoProdIng}" readonly>
          </div>
          <!-- unidad del tipo de producto -->
          <div class="col-lg-2">
            <input type="text" class="form-control" id="unidadProdIng" value="${unidadProdIng}" readonly>
          </div>
          <!-- cantidad editable inicia en 1 -->
          <div class="col-lg-2">
            <input type="number" class="form-control cantidadProdIng" id="cantidadProdIng" value="${cantidadProdIng}" min="1" step="1" data-original-idProd="${idProd}">
          </div>
          <!-- precio -->
          <div class="col-lg-2">
            <input type="text" class="form-control precioProdIng" id="precioProdIng" value="${precioProdIng}" data-original-precio="${precioProd}" readonly>
          </div>
          <!-- boton de eliminar -->
          <div class="col-lg-1">
            <button type="button" class="btn btn-danger btn-xs deleteNuevoIngresoProd" value="${codProdIng}"><i class="fa fa-times"></i></button>
          </div>
        </form>`;

      // Agregar el nuevo formulario al contenedor
      $(".AddProductoSalida").append(nuevoProductoHTML);

      //agregar la cantidad a la variable gloval contadora
      var nuevoDatoFormulario = [
        formularioID,
        Number(idProd),
        String(cantidadProd),
      ];
      window.datosFormularios.push(nuevoDatoFormulario);
      //console.log(datosFormularios);

      //llama ala funcion de editar cantidad y precio para que valide la cantidad maxima
      $(document).on(
        "input",
        ".cantidadProdIng",
        actualizarPrecioYValidarCantidad
      );

      /*  // Eliminar el producto
      $(document).on("click", ".deleteNuevoIngresoProd", function (e) {
        // Paso 1: Capturar el valor del botón presionado y convertirlo a número entero
        var valorBoton = parseInt($(this).val(), 10);
        //console.log("Valor del botón presionado:", valorBoton);
        // Paso 2: Copiar los datos de la variable global a una nueva variable (manteniendo el formato de Set)
        var datosTemporales = new Set(codigosProductosAgregados);

        // Paso 3: Buscar y eliminar el valor del botón en la nueva variable
        if (datosTemporales.has(valorBoton)) {
          datosTemporales.delete(valorBoton);
        } else {
          //console.log("El valor no se encontró en la variable global.");
        }
        // Paso 4: Limpiar la variable global
        codigosProductosAgregados.clear();
        // Paso 5: Actualizar la variable global con los nuevos datos
        datosTemporales.forEach((valor) => {
          codigosProductosAgregados.add(valor);
        });
        // Eliminar el formulario del producto del DOM
        $(this).closest(".productoRow").remove();
      });
      //fin agregar productos */
    }
    //enviar formulario al servidor para editar
    $("#btnEditarSalidaMprima").on("click", function () {
      //totales estén actualizados si el usuario no lo hizo
      document.getElementById("btnCalcularTotalIng").click();
      //obtener el formulario por id

      var formulario = document.getElementById("formSalidaMprimaEdit");
      var datosFormulario = {};
      //obtener los elementos del formulario
      var elementosFormulario = formulario.querySelectorAll("input, select");
      //for each para recorrer los elementos del formulario y asignarle la clave como su id y su valor
      elementosFormulario.forEach(function (elemento) {
        if (elemento.id) {
          datosFormulario[elemento.id] = elemento.value;
        }
      });
      //crear el json
      var jsonEditarSalProd = JSON.stringify(datosFormulario);

      // Llamada a la función para recolectar datos de formularios anidados PRODUCTOS
      recojerFormulariosAnidadosSalProdEdit(function (datosFormulariosSalProd) {
        // Crear un JSON con los datos recolectados de los formularios anidados
        var jsonEditarSalProductosForms = JSON.stringify(
          datosFormulariosSalProd
        );

        $.ajax({
          url: "ajax/salidaMprima.ajax.php",
          method: "POST",
          data: {
            jsonEditarSalProd: jsonEditarSalProd,
            jsonEditarSalProductosForms: jsonEditarSalProductosForms,
          },
          dataType: "json",
          success: function (response) {
            if (response == "ok") {
              Swal.fire({
                icon: "success",
                title: "Correcto",
                text: "Salida Productos Prima Editado Correctamente",
              }).then(function () {
                window.location.href = "/dfrida/salidaMprimaList";
              });
            } else {
              Swal.fire(
                "Error",
                "Nesesita permisos de administrador para realizar esta acción",
                "error"
              ).then(function () {});
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(
              "Error en la solicitud AJAX: ",
              textStatus,
              errorThrown
            );
          },
        });
      });
      //fin editar
      //recojer todos los formularios anidados que son los productos  y asignarle un nombre++ que es un json con sus datos recoje todos los productos = fromularios
      function recojerFormulariosAnidadosSalProdEdit(callback) {
        let datosFormulariosSalProd = {};

        $("[id^=formularioIngProd]").each(function (index) {
          let datosFormulario = {};
          $(this)
            .find("input, select")
            .each(function () {
              if (this.id) {
                datosFormulario[this.id] = $(this).val();
              }
            });
          datosFormulariosSalProd["producto" + index] = datosFormulario;
        });

        // Llamar al callback con los datos recolectados
        if (callback && typeof callback === "function") {
          callback(datosFormulariosSalProd);
        }
      }
      //fin
    });
  }
});
//fin editar ingreso productos

//****eliminar registro de salida prima****
//borrar salida productos
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprimaList";
  if (currentPath == appPath) {
    $(".dataTableSalidasMprima").on("click", ".btnDeleteSalProd", function () {
      var codSalMprima = $(this).attr("codSalMprima");
      swal
        .fire({
          title: "¿Está seguro de borrar la Salida? Puede generar exedentes",
          text: "¡No podrá revertir el cambio esta accion afectara directamente al almacen Prodcutos Prima!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Si, Borrar Salida!",
        })
        .then((result) => {
          if (result.isConfirmed) {
            var jsonBorraSalProdcutos = JSON.stringify({
              codSalMprima: codSalMprima,
            });
            $.ajax({
              url: "ajax/salidaMprima.ajax.php",
              method: "POST",
              data: { jsonBorraSalProdcutos: jsonBorraSalProdcutos },
              dataType: "json",
              success: function (response) {
                if (response == "ok") {
                  Swal.fire(
                    "Correcto",
                    "Salida de Productos Prima eliminado correctamente",
                    "success"
                  ).then(function () {
                    window.location.reload(); // Recargar la página
                  });
                } else if (response == "errorProcOp") {
                  Swal.fire(
                    "Error",
                    "La Salida de Productos Prima no se puede eliminar, actualmente esta asignada a un proceso operativo",
                    "error"
                  ).then(function () {
                    //window.location.reload(); // Recargar la página
                  });
                } else {
                  Swal.fire(
                    "Error",
                    "Necesita permisos de administrador para realizar esta acción",
                    "error"
                  ).then(function () {
                    //window.location.reload(); // Recargar la página
                  });
                }
              },
              error: function (jqXHR, textStatus, errorThrown) {
                console.log(
                  "Error en la solicitud AJAX: ",
                  textStatus,
                  errorThrown
                );
              },
            });
          }
        });
    });
  }
});
//fin eliminar registro de salida prima

//funcion para traer productos prima de pedido / cotizacion
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprima";
  if (currentPath == appPath) {
    // Verificar si el botón existe en el DOM
    var btnPedidoMprimaAdd = document.getElementById("btnPedidoMprimaAdd");
    if (btnPedidoMprimaAdd) {
      // Inicializar Select2
      btnPedidoMprimaAdd.addEventListener("click", function () {
        Swal.fire({
          title:
            "¿Agregar productos prima de Pedido a salida de productos prima? Verifique Stocks en alamacen",
          text: "Selecione un pedido para registrar los productos prima, recuerde que puede crear salidas de materia prima sin esta restriccion y despues asignarla a un proceso.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "No, asignaré esta salida en proceso operativo.",
          confirmButtonText: "Sí, asignar pedido ya creado.",
        }).then((result) => {
          if (result.isConfirmed) {
            // Cambiar el botón por un campo select
            var container = document.getElementById("pedidoAsignarAdd");
            container.innerHTML = `
              <select class="form-control select2" id="pedidoSalAdd" name="pedidoSalAdd">
                <option value="0">Seleccione un pedido</option>
              </select>
            `;

            // Inicializar Select2 en el nuevo campo select
            $("#pedidoSalAdd").select2();

            // Cargar datos dinámicamente al confirmar
            var data = new FormData();
            data.append("todosLosPedidosDisponibles", true);

            $.ajax({
              url: "ajax/salidaMprima.ajax.php",
              method: "POST",
              data: data,
              contentType: false,
              processData: false,
              dataType: "json",
              success: function (data) {
                // Limpiar las opciones actuales
                $("#pedidoSalAdd").empty();
                $("#pedidoSalAdd").append(
                  '<option value="0">Seleccionar Proceso Operativo</option>'
                );
                // Agregar las nuevas opciones
                $.each(data, function (key, value) {
                  $("#pedidoSalAdd").append(
                    '<option value="' +
                      value.idPedido +
                      '">' +
                      value.nombrePedido +
                      "</option>"
                  );
                });
                // Actualizar Select2 después de agregar las opciones
                $("#pedidoSalAdd").trigger("change");

                // Agregar evento change para capturar el valor seleccionado
                $("#pedidoSalAdd").on("change", function () {
                  var codPedidoSalMp = $(this).val();
                  //console.log("Valor seleccionado:", codPedidoSalMp);
                  // Aquí puedes agregar cualquier lógica adicional que necesites
                  //productosPrimaPedido(codPedidoSalMp);
                });
              },
              error: function (xhr, status, error) {
                console.error("Error al cargar los datos:", error);
              },
            });
          }
        });
      });
    } else {
      console.error(
        'El elemento con id "btnProcesoOperativoAdd" no se encontró en el DOM.'
      );
    }
  }
});
//fin funcion

//funcion para trear los productos de la cotizacion
function productosPrimaPedido(codPedidoSalMp) {
  var data = new FormData();
  data.append("codPedidoSalMp", codPedidoSalMp);
  //visualizar los datos
  $.ajax({
    url: "ajax/salidaMprima.ajax.php",
    method: "POST",
    data: data,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response.hasOwnProperty("productsMprimaCoti")) {
        ingresoProductoMprima(response["productsMprimaCoti"]);
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
    },
  });
}

//promesa para obtener el stock de los productos de almacen y sumarlo a la cantidad de la salida para mostrar un máximo a editar y también el precio del producto
// Modificación de obtenerStock para que retorne una promesa la función retorna la cantidad a la función de *insertarFormulario*
function obtenerStockMprima(codProdMprimaCoti) {
  return new Promise((resolve, reject) => {
    var data = new FormData();
    data.append("codProdMprimaCoti", codProdMprimaCoti);
    $.ajax({
      url: "ajax/salidaMprima.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        resolve({
          cantidadProdAlma: response["cantidadMprimaAlma"],
          precioProd: response["precioMprima"],
          codigoProd: response["codigoMprima"],
        }); // Resuelve la promesa con un objeto que contiene ambos valores
      },
      error: function (jqXHR, textStatus, errorThrown) {
        reject("Error en la solicitud AJAX: " + textStatus + " " + errorThrown); // Rechaza la promesa si hay un error
      },
    });
  });
}

// Uso de async/await en ingresoProductoEdit para esperar la respuesta de obtenerStock
async function ingresoProductoMprima(productsMprimaCoti) {
  // Decodificar el JSON recibido de la respuesta de visualizar datos
  const procesos = JSON.parse(productsMprimaCoti);

  // Mostrar el modal de carga porque la promesa es asíncrona y espera la respuesta para crear el formulario
  //el usuario visualizará una demora en la carga de los datos
  Swal.fire({
    title: "Cargando...",
    text: "Por favor, espere mientras se procesan los datos.",
    allowOutsideClick: false,
    didOpen: () => {
      Swal.showLoading();
    },
  });
  //recorre todos los arrays decodificados del json para crear un formulario por cada producto resuelto
  for (const proceso of Object.values(procesos)) {
    const {
      codProdMprimaCoti,
      nombreProdMprimaCoti,
      unidadProdMprimaCoti,
      cantidadProdMprimaCoti,
      precioProdMprimaCoti,
    } = proceso;

    // Convertir el código del producto a entero antes de agregarlo a la variable global
    //que valida los productos agregados a la lista
    var codProdIngInt = parseInt(codProdMprimaCoti, 10);
    codAddSalProdModal = codProdIngInt;
    // Agregar el código del producto a la variable global
    codigosProductosAgregados.add(codAddSalProdModal);
    //console.log(codigosProductosAgregados); // Mostrar el estado actual

    // Esperar la respuesta de obtenerStock
    try {
      // Enviar el id de producto a la función de obtener stock para traer el stock del almacén
      const { cantidadProdAlma, precioProd, codigoProd } =
        await obtenerStockMprima(codProdMprimaCoti);
      insertarFormulario(
        codProdMprimaCoti,
        nombreProdMprimaCoti,
        codigoProd,
        unidadProdMprimaCoti,
        cantidadProdMprimaCoti,
        precioProdMprimaCoti,
        cantidadProdAlma,
        precioProd
      );
    } catch (error) {
      console.error(error); // Manejar el error si la promesa es rechazada
    }
  }

  // Cerrar el modal de carga una vez que se haya completado el procesamiento
  Swal.close();
}

function insertarFormulario(
  codProdIng,
  nombreProdIng,
  codigoProdIng,
  unidadProdIng,
  cantidadProdIng,
  precioProdIng,
  cantidadProdStock,
  precioProd,
  //valores para la variable global que espera estos datos para iniciar la función de cantidades máximas editables
  cantidadProd = Number(cantidadProdStock), //+ Number(cantidadProdIng),
  idProd = codProdIng
) {
  // Llamar a validarCantidad después de que todos los parámetros estén definidos
  cantidadProdIng = validarCantidad(cantidadProdIng, cantidadProdStock);

  var formularioID = "formularioIngProd" + formularioIngProdCounter++;
  var nuevoProductoHTML = `
    <form id="${formularioID}" class="row productoRow" style="padding:5px 15px">
      <div class="col-lg-2">
        <!-- id del producto -->
        <input type="hidden" class="form-control" id="codProdIng" value="${idProd}">
        <!-- nombre del producto -->
        <input type="text" class="form-control" id="nombreProdIng" value="${nombreProdIng}" readonly>
      </div>
      <!-- codigo del producto -->
      <div class="col-lg-2">
        <input type="text" class="form-control" id="codigoProdIng" value="${codigoProdIng}" readonly>
      </div>
      <!-- unidad del tipo de producto -->
      <div class="col-lg-2">
        <input type="text" class="form-control" id="unidadProdIng" value="${unidadProdIng}" readonly>
      </div>
      <!-- cantidad editable inicia en 1 -->
      <div class="col-lg-2">
        <input type="number" class="form-control cantidadProdIng" id="cantidadProdIng" value="${cantidadProdIng}" min="1" step="1" data-original-idProd="${idProd}">
      </div>
      <!-- precio -->
      <div class="col-lg-2">
        <input type="text" class="form-control precioProdIng" id="precioProdIng" value="${precioProdIng}" data-original-precio="${precioProd}" readonly>
      </div>
      <!-- boton de eliminar -->
      <div class="col-lg-1">
        <button type="button" class="btn btn-danger btn-xs deleteNuevoIngresoProd" value="${codProdIng}"><i class="fa fa-times"></i></button>
      </div>
    </form>`;

  // Agregar el nuevo formulario al contenedor
  $(".AddProductoSalida").append(nuevoProductoHTML);

  //agregar la cantidad a la variable global contadora
  var nuevoDatoFormulario = [
    formularioID,
    Number(idProd),
    String(cantidadProd),
  ];
  window.datosFormularios.push(nuevoDatoFormulario);
  //console.log(datosFormularios);

  //llama a la función de editar cantidad y precio para que valide la cantidad máxima
  $(document).on("input", ".cantidadProdIng", actualizarPrecioYValidarCantidad);
}

function validarCantidad(cantidadProdIng, cantidadProdStock) {
  if (cantidadProdIng > cantidadProdStock) {
    if (cantidadProdStock < 0) {
      cantidadProdIng = cantidadProdStock; // Mantener el valor negativo
    } else if (cantidadProdStock === 0) {
      cantidadProdIng = 0;
    } else {
      if (cantidadProdIng <= cantidadProdStock) {
        return cantidadProdIng;
      } else {
        return cantidadProdStock;
      }
    }
  }
  return cantidadProdIng;
}
//fin funcion

//funcion para mostrar proceso oeprativo adjunto
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprimaList";
  if (currentPath == appPath) {
    $(".dataTableSalidasMprima").on("click", ".btnVerProcOp", function () {
      // Abrir el modal
      $("#modalEstadosProcesosOp").modal("show");

      // Limpiar todos los datos del modal
      $("#modalEstadosProcesosOp").find("input, textarea, select").val("");

      // Obtener los datos del botón
      var codProcSalMprima = $(this).attr("codProcSalMprima");

      // Crear el objeto FormData
      var jsonEstadosProcOp = JSON.stringify({
        codProcSalMprima: codProcSalMprima,
      });

      // Realizar la solicitud AJAX
      $.ajax({
        url: "ajax/salidaMprima.ajax.php",
        method: "POST",
        data: { jsonEstadosProcOp: jsonEstadosProcOp },
        dataType: "json",
        success: function (response) {
          if (response == "error") {
            Swal.fire({
              title: "No se encuentra un proceso operativo asignado",
              text: "¿Desea asignarle un proceso operativo?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Si, asignar Proceso Operativo",
              cancelButtonText: "No, en otro momento",
            }).then((result) => {
              if (result.isConfirmed) {
                // Redirigir a la ruta para asignar proceso operativo
                window.location.href = "/dfrida/procesosOperativos";
              } else {
                $("#modalEstadosProcesosOp").modal("hide");
              }
            });
          } else {
            $("#nombrePorcesoOpNombreEstate").val(response["nombreProcOp"]);
            $("#fechaInicioProcOpEstate").val(response["fechaInicioProcOp"]);
            $("#fechaFinProcOpEstate").val(response["fechaFinProcOp"]);
            $("#tipoPorcesoOpNombreEstate").val(response["nombreTipoProc"]);
            $("#estadoPrincipalProcOP").val(response["estadoProcOp"]);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.error(
            "Error en la solicitud AJAX: ",
            textStatus,
            errorThrown
          );
        },
      });
    });
  }
});
//fin proceso operativo

//vista de agregar productos a los ingresos de productos a el almacen
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprimaList";
  if (currentPath == appPath) {
    var btn = document.getElementById("btnAddSalidaMprima");
    if (btn) {
      btn.addEventListener("click", function () {
        window.location.href = "/dfrida/salidaMprima";
      });
    }
  }
});

//cerrar salida productos
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprima";
  if (currentPath == appPath) {
    var btn = document.getElementById("btnCerrarSalidaMprima");
    if (btn) {
      btn.addEventListener("click", function () {
        window.location.href = "/dfrida/salidaMprimaList";
      });
    }
  }
});

//cerrar editar productos
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/salidaMprimaEdit";
  if (currentPath == appPath) {
    var btn = document.getElementById("btnCerrarEditSalMprima");
    if (btn) {
      btn.addEventListener("click", function () {
        window.location.href = "/dfrida/salidaMprimaList";
      });
    }
  }
});
