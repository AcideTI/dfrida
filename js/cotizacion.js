//agrergar productos a la cotizacion
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/cotizacion";
  if (currentPath == appPath) {
    //funcion para agregar productos a la cotizacion
    // Definir un contador global para los IDs de formulario
    var formularioProdCotiCounter = 1;

    $(".dataTableProductos").on("click", ".btnAddProdModalCoti", function () {
      var codAddProdModalCoti = $(this).attr("codAddProdModalCoti");

      var datos = new FormData();
      datos.append("codAddProdModalCoti", codAddProdModalCoti);
      $.ajax({
        url: "ajax/cotizacion.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          var idProd = respuesta["idProd"];
          var nombreProd = respuesta["nombreProd"];
          var unidadProd = respuesta["unidadProd"];
          var precioProd = respuesta["precioProd"];

          // Crear un nuevo formulario para el producto con un ID único que incrementa en 1 cada vez que se agrega un producto
          var formularioID = "formularioProdCoti" + formularioProdCotiCounter++;
          var nuevoProductoHTML =
            '<form id="' +
            formularioID +
            '" class="row productoRow" style="padding:5px 15px">' +
            '<div class="col-lg-4">' +
            /* id del prodcuto */
            '<input type="hidden" class="form-control" id="codProdCoti" value="' +
            idProd +
            '">' +
            /* nombre del producto */
            '<input type="text" class="form-control" id="nombreProdCoti" value="' +
            nombreProd +
            '" readonly>' +
            "</div>" +
            /* unidad del tipo de producto */
            '<div class="col-lg-2">' +
            '<input type="text" class="form-control" id="unidadProdCoti"value="' +
            unidadProd +
            '" readonly>' +
            "</div>" +
            /* cantidad editable inicia en 1 */
            '<div class="col-lg-2">' +
            '<input type="number" class="form-control cantidadProdCoti" id="cantidadProdCoti" value="1" min="1" step="1">' +
            "</div>" +
            /* precio */
            '<div class="col-lg-2">' +
            '<input type="text" class="form-control precioProdCoti" id="precioProdCoti" value="' +
            precioProd +
            '" data-original-precio="' +
            precioProd +
            '" readonly>' +
            "</div>" +
            /* boton de eliminar */
            '<div class="col-lg-1">' +
            '<button type="button" class="btn btn-danger btn-xs deleteNuevoIngresoProd"><i class="fa fa-times"></i></button>' +
            "</div>" +
            "</form>";

          // Agregar el nuevo formulario al contenedor
          $(".AddProductoCotizacion").append(nuevoProductoHTML);
        },
      });
    });
    // Actualizar el precio cuando cambia la cantidad
    $(document).on("input", ".cantidadProdCoti", function () {
      var count = $(this).val();
      var precioPerUnit = $(this)
        .closest(".productoRow")
        .find(".precioProdCoti")
        .data("original-precio");
      //si el valor del input es vacio o 0 el precio final es 0
      if (count === "" || parseInt(count) === 0) {
        var precioFinal = "0";
      } else {
        var precioFinal = (count * precioPerUnit).toFixed(2);
      }
      // Actualizar el valor interno y el atributo 'value' en el HTML
      $(this).val(count);
      $(this).attr("value", count); // Actualiza el atributo 'value' en el HTML para la cantidad
      $(this)
        .closest(".productoRow")
        .find(".precioProdCoti")
        .val(precioFinal) // Actualiza el valor interno para el precio
        .attr("value", precioFinal); // Actualiza el atributo 'value' en el HTML para el precio
    });

    // Eliminar el producto
    $(document).on("click", ".deleteNuevoIngresoProd", function () {
      $(this).closest(".productoRow").remove();
    });
    //fin agregar productos a la cotizacion
    //fin vericar ruta
  }
});
//fin agreagr productos a la cotizacion

//agrergar productos prima a la cotizacion
document.addEventListener("DOMContentLoaded", function () {
  //si la ruta no es la correcta no se ejecuta la función
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/cotizacion";
  if (currentPath == appPath) {
    //funcion para agregar productos prima a la cotizacion
    // Definir un contador global para los IDs de formulario
    var formularioProdMprimaCotiCounter = 1;

    $(".dataTableProductosMprima").on(
      "click",
      ".btnAddProdMprimaModalCoti",
      function () {
        var codAddProdMprimaModalCoti = $(this).attr(
          "codAddProdMprimaModalCoti"
        );

        var datos = new FormData();
        datos.append("codAddProdMprimaModalCoti", codAddProdMprimaModalCoti);
        $.ajax({
          url: "ajax/cotizacion.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (respuesta) {
            var idMprima = respuesta["idMprima"];
            var nombreMprima = respuesta["nombreMprima"];
            var unidadMprima = respuesta["unidadMprima"];
            var precioMprima = respuesta["precioMprima"];

            // Crear un nuevo formulario para el producto prima con un ID único que incrementa en 1 cada vez que se agrega un producto prima
            var formularioMprimaID =
              "formularioProdMprimaCoti" + formularioProdMprimaCotiCounter++;
            var nuevoProductoMprimaHTML =
              '<form id="' +
              formularioMprimaID +
              '" class="row productoMprimaRow" style="padding:5px 15px">' +
              '<div class="col-lg-4">' +
              /* id del prodcuto prima */
              '<input type="hidden" class="form-control" id="codProdMprimaCoti" value="' +
              idMprima +
              '">' +
              /* nombre del producto prima */
              '<input type="text" class="form-control" id="nombreProdMprimaCoti" value="' +
              nombreMprima +
              '" readonly>' +
              "</div>" +
              /* unidad del tipo de producto prima */
              '<div class="col-lg-2">' +
              '<input type="text" class="form-control" id="unidadProdMprimaCoti" value="' +
              unidadMprima +
              '" readonly>' +
              "</div>" +
              /* cantidad editable inicia en 1 */
              '<div class="col-lg-2">' +
              '<input type="number" class="form-control cantidadProdMprimaCoti" id="cantidadProdMprimaCoti" value="1" min="1" step="1">' +
              "</div>" +
              /* precio prima*/
              '<div class="col-lg-2">' +
              '<input type="text" class="form-control precioProdMprimaCoti" id="precioProdMprimaCoti" value="' +
              precioMprima +
              '" data-original-precioPrima="' +
              precioMprima +
              '" readonly>' +
              "</div>" +
              /* boton de eliminar prima*/
              '<div class="col-lg-1">' +
              '<button type="button" class="btn btn-danger btn-xs deleteNuevoIngresoProdMprima"><i class="fa fa-times"></i></button>' +
              "</div>" +
              "</form>";

            // Agregar el nuevo formulario al contenedor
            $(".AddProductoMprimaCotizacion").append(nuevoProductoMprimaHTML);
          },
        });
      }
    );

    // Actualizar el precio cuando cambia la cantidad
    // Actualizar el precio cuando cambia la cantidad para productos prima
    $(document).on("input", ".cantidadProdMprimaCoti", function () {
      var count = $(this).val();
      var precioPerUnitMprima = $(this)
        .closest(".productoMprimaRow")
        .find(".precioProdMprimaCoti")
        .data("original-precioPrima"); // Asegúrate de que esta línea coincida con cómo se establece el atributo en el HTML
      //si el valor del input es vacio o 0 el precio final es 0
      if (count === "" || parseInt(count) === 0) {
        var precioFinalMprima = "0";
      } else {
        var precioFinalMprima = (count * precioPerUnitMprima).toFixed(2);
      }
      // Actualizar el valor interno y el atributo 'value' en el HTML
      $(this).val(count);
      $(this).attr("value", count); // Actualiza el atributo 'value' en el HTML para la cantidad
      $(this)
        .closest(".productoMprimaRow")
        .find(".precioProdMprimaCoti")
        .val(precioFinalMprima) // Actualiza el valor interno para el precio
        .attr("value", precioFinalMprima); // Actualiza el atributo 'value' en el HTML para el precio
    });
    // Eliminar el producto
    $(document).on("click", ".deleteNuevoIngresoProdMprima", function () {
      $(this).closest(".productoMprimaRow").remove();
    });
    //fin agregar productos a la cotizacion
    //fin vericar ruta
  }
});
//fin agreagr productos prima a la cotizacion

// Crear productMprima nuevo
// Iniciar función por el document solo si se encuentra en la vista o ruta correcta que debe de ser "users"
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/cotizacion";
  if (currentPath == appPath) {
    //si la ruta no es la correcta no se ejecuta la función
    document
      .getElementById("btnCrearProductoMprima")
      .addEventListener("click", function (event) {
        //obtener el formulario por id
        var formulario = document.getElementById("formCrearProductoMprima");
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
        var jsonCrearProductosMprima = JSON.stringify(datosFormulario);

        $.ajax({
          url: "ajax/productMprima.ajax.php",
          method: "POST",
          data: { jsonCrearProductosMprima: jsonCrearProductosMprima },
          dataType: "json",

          success: function (response) {
            $("#modalAddProductoMprima").modal("hide"); // Cerrar el modal
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
                html: "<strong>Producto Prima creado correctamente</strong>",
              }).then(function (result) {
                if (result.value) {
                  limpiarURL(); // Llamar a la función para limpiar la URL
                  window.location.reload(); // Recargar la página
                }
              });
            } else if (response == "errorNom") {
              Swal.fire({
                icon: "error",
                title: "Error",
                html: "Ya existe un Producto Prima con el mismo <strong>nombre</strong>.",
              }).then(function (result) {
                if (result.value) {
                  limpiarURL(); // Llamar a la función para limpiar la URL
                }
              });
            } else if (response == "errorCod") {
              Swal.fire({
                icon: "error",
                title: "Error",
                html: "Ya existe un Producto Prima con el mismo <strong>código</strong>.",
              }).then(function (result) {
                if (result.value) {
                  limpiarURL(); // Llamar a la función para limpiar la URL
                }
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Error",
                html: "<strong>No se puede crear el Producto Prima con datos Vacios</strong>.",
              }).then(function (result) {
                if (result.value) {
                  limpiarURL(); // Llamar a la función para limpiar la URL
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
      });
    //fin vericar ruta
  }
});
//fin crear productMprima nuevo
//  editar productMprima
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/cotizacion";
  if (currentPath == appPath) {
    $(".dataTableProductosMprima").on(
      "click",
      ".btnEditProductoMprima",
      function () {
        var codProMp = $(this).attr("codProMp");
        var data = new FormData();
        data.append("codProMp", codProMp);
        //visualizar los datos del Productos en el modal
        $.ajax({
          url: "ajax/productMprima.ajax.php",
          method: "POST",
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            //console.log(response);
            $("#editProductNameMp").val(response["nombreMprima"]);
            $("#editProductCategoryMp").val(response["idCatMprima"]);
            $("#editProductCodigoMp").val(response["codigoMprima"]);
            $("#editProductUnitMp").val(response["unidadMprima"]);
            $("#editProductprecioMp").val(response["precioMprima"]);
            $("#editProductDetailMp").val(response["detalleMprima"]);
            $("#codProductMp").val(response["idMprima"]);
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
    );
    //fin visualizar los datos del ProductosMprima en el modal

    //editar ProductosMprima si se da clic en el boton editar
    $("#btnEditarProductoMprima").on("click", function () {
      //obtener el formulario por id
      var formulario = document.getElementById("formEditarProductoMprima");
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
      var jsonEditarProductosMprima = JSON.stringify(datosFormulario);
      //enviar el json por ajax
      $.ajax({
        url: "ajax/productMprima.ajax.php",
        method: "POST",
        data: { jsonEditarProductosMprima: jsonEditarProductosMprima },
        dataType: "json",
        success: function (response) {
          $("#modalEditProducto").modal("hide");
          if (response == "ok") {
            Swal.fire(
              "Correcto",
              "Producto Prima editado correctamente",
              "success"
            ).then(function () {
              window.location.reload(); // Recargar la página
            });
          } else {
            Swal.fire(
              "Error",
              "El Producto Prima no se ha podido editar existe otro igual",
              "error"
            ).then(function () {
              //$("#modalEditProveedor").modal("hide");
            });
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
        },
      });
    });
    //fin editar ProductosMprima si se da clic en el boton editar
    // Escuchar el clic en el botón de cerrar
    $("#btnCerrarEditarProducto").on("click", function () {
      $("#modalEditProducto").modal("hide");
    });
  }
});
//fin
// eliminar ProductosMprima
document.addEventListener("DOMContentLoaded", function () {
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/cotizacion";
  if (currentPath == appPath) {
    $(".dataTableProductosMprima").on(
      "click",
      ".btnDeleteProductoMprima",
      function () {
        var codProMp = $(this).attr("codProMp");
        //mensaje de confirmación para eliminar ProductosMprima
        swal
          .fire({
            title: "¿Está seguro de borrar el Producto Prima?",
            text: "¡No podrá revertir el cambio!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Si, borrar Producto!",
          })
          .then((result) => {
            if (result.isConfirmed) {
              var jsonBorraProductoMprima = JSON.stringify({
                codProMp: codProMp,
              });
              $.ajax({
                url: "ajax/productMprima.ajax.php",
                method: "POST",
                data: { jsonBorraProductoMprima: jsonBorraProductoMprima },
                dataType: "json",
                success: function (response) {
                  if (response == "ok") {
                    Swal.fire(
                      "Correcto",
                      "Producto Prima eliminado correctamente",
                      "success"
                    ).then(function () {
                      window.location.reload(); // Recargar la página
                    });
                  } else {
                    Swal.fire(
                      "Error",
                      "El Producto Prima se encuentra en el inventario no se puede eliminar",
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
      }
    );
  }
});
//fin eliminar ProductosMprima
