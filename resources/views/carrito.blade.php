<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('dist/css/estilos.css') }}">
    {{-- -CSS SWEETALERT 2-- --}}
    <link rel="stylesheet" href="{{ env('BASE_URL') }}node_modules/sweetalert2/dist/sweetalert2.css">
    <link rel="stylesheet" href="{{ env('BASE_URL') }}node_modules/sweetalert2/dist/sweetalert2.min.css">

    <style>
        #tabla_carrito>thead>tr>th {
            background-color: aqua;
        }
    </style>
</head>

<body>
    @include(component('nav_tienda'))
    <div class="container-fluid">
        @include(component('productos_carrito'))
    </div>
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    {{-- - SWEET ALERT 2- --}}
    <script src="{{ env('BASE_URL') }}node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
    <script src="{{ env('BASE_URL') }}node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="{{ env('BASE_URL') }}node_modules/sweetalert2/dist/sweetalert2.js"></script>
    <script src="{{ env('BASE_URL') }}node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    {{-- AXIOS --}}
    <script src="{{ env('BASE_URL') }}node_modules/axios/dist/axios.min.js"></script>
    <script>
        var TOKEN = "{{ $this->Csrf() }}";
        var URL_BASE = "{{ env('BASE_URL') }}";
        $(document).ready(function() {
          ConfirmarQuitarProductoCarrito();
        });

        /** Método para confirmar eliminado del producto añadido al carrito**/
        var ConfirmarQuitarProductoCarrito = () => {
            $('#tabla_carrito tbody').on('click', '#delete_producto', function(evento) {
                evento.preventDefault();
                /// obtenemos la fila seleccionada
                let filaSelect = $(this).parents('tr');

                /// obtenemos el producto
                let Producto = filaSelect.find('td').eq(3).text();
                Swal.fire({
                    title: "Deseas quitar al producto '"+Producto+"' del carrito ?",
                    text: "Al presionar que si, se quitará de la lista del carrito!",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si , eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        /// el método para eliminar
                        QuitarProductoCarrito(Producto);
                    }
                });
            });
        }

        /// método para quitar de la lista del carrito
        function QuitarProductoCarrito(producto_)
        {
          let FormDelete = new FormData();
          FormDelete.append('_token',TOKEN);
          FormDelete.append("producto_delete",producto_);
          axios({
            url:URL_BASE+"carrito/quitar_de_la_cesta",
            method:"POST",
            data:FormDelete,
          }).then(function(response){
             if(response.data.response === 'eliminado')
             {
              Swal.fire({
                title:"Mensaje del sistema!",
                text:"Producto "+producto_+" a sido quitado de la lista del carrito",
                icon:"success"
              }).then(function(){
               location.href = URL_BASE+"carrito";
              });
             }
             else{
              Swal.fire({
                title:"Mensaje del sistema!",
                text:"Error al quitar producto de la lista de la carrito",
                icon:"error"
              });
             }
          });
        }
    </script>
</body>

</html>
