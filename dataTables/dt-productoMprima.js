// funciond ata table para modales de categorias de productos crear y eliminar registros sina ctualizar la pagina
document.addEventListener("DOMContentLoaded", function () {
  // Verificar si la ruta es la correcta al mostrar el modal
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/productMprima";
  if (currentPath == appPath) {
    // Estructura de dataTableProductosMprima
    $("#dataTableProductosMprima thead").html(`
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre Producto Prima</th>
          <th scope="col">Categoria Producto Prima</th>
          <th scope="col">Codigo Producto Prima</th>
          <th scope="col">Unidad Metros</th>
          <th scope="col">Precio Prima</th>
          <th scope="col">Observacion</th>
          <th scope="col">Acciones</th>
        </tr>
      `);

    // Definición inicial de dataTableProductosMprima
    var columnDefsProductosMprima = [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "nombreMprima" },
      { data: "nombreCategoriaMprima" },
      { data: "codigoMprima" },
      {
        data: "unidadMprima",
        render: function (data, type, row) {
          return data + " m&sup2;"; // Añade ' m²' al valor de la celda
        },
      },
      {
        data: "precioMprima",
        render: function (data, type, row) {
          return "S/ " + data; // Coloca 'S/' delante del valor de la celda
        },
      },
      { data: "detalleMprima" },
      { data: "buttons" },
    ];

    var tableProductosMprima = $("#dataTableProductosMprima").DataTable({
      columns: columnDefsProductosMprima,
    });

    // Titulo dataTableProductosMprima
    $(".tituloProductosMprima").text("Todos los Productos Prima");

    // Solicitud inicial de dataTableProductosMprima
    var data = new FormData();
    data.append("todosLosProductosMprima", true);

    $.ajax({
      url: "ajax/productMprima.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        tableProductosMprima.clear();
        tableProductosMprima.rows.add(response);
        tableProductosMprima.draw();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }
});
