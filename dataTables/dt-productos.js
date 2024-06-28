// funciond ata table para modales de categorias de productos crear y eliminar registros sina ctualizar la pagina
document.addEventListener("DOMContentLoaded", function () {
  // Verificar si la ruta es la correcta al mostrar el modal
  var currentPath = window.location.pathname;
  var appPath = "/dfrida/products";
  if (currentPath == appPath) {
    // Estructura de dataTableProductos
    $("#dataTableProductos thead").html(`
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nombre Producto</th>
          <th scope="col">Categoria</th>
          <th scope="col">Codigo</th>
          <th scope="col">Unidad Metros</th>
          <th scope="col">Precio</th>
          <th scope="col">Observacion</th>
          <th scope="col">Acciones</th>
        </tr>
      `);

    // Definición inicial de dataTableProductos
    var columnDefsProductos = [
      {
        data: null,
        render: function (data, type, row, meta) {
          return meta.row + 1;
        },
      },
      { data: "nombreProd" },
      { data: "nombreCategoriaProd" },
      { data: "codigoProd" },
      {
        data: "unidadProd",
        render: function (data, type, row) {
          return data + " m&sup2;"; // Añade ' m²' al valor de la celda
        },
      },
      {
        data: "precioProd",
        render: function (data, type, row) {
          return "S/ " + data; // Coloca 'S/' delante del valor de la celda
        },
      },
      { data: "detalleProd" },
      { data: "buttons" },
    ];

    var tableProductos = $("#dataTableProductos").DataTable({
      columns: columnDefsProductos,
    });

    // Titulo dataTableProductos
    $(".tituloProductos").text("Todos los Productos");

    // Solicitud inicial de dataTableProductos
    var data = new FormData();
    data.append("todosLosProductos", true);

    $.ajax({
      url: "ajax/products.ajax.php",
      method: "POST",
      data: data,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        tableProductos.clear();
        tableProductos.rows.add(response);
        tableProductos.draw();
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("Error en la solicitud AJAX: ", textStatus, errorThrown);
      },
    });
  }
});
