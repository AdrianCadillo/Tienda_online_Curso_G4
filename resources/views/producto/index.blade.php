@extends(layout('app'))

@section('title_page', 'Productos')

@section('css')

@endsection

@section('content')
    <div class="col mt-2">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="tab_productos">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="true" href="#productos_existentes" id="producto_e">Productos
                            existentes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#productos_papelera" id="producto_p">Papelera de productos</a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="productos_existentes" role="tabpanel"
                        aria-labelledby="nav-home-tab">
                        <div class="row mb-2">
                            <div class="col-auto">
                                <a href="{{ route('producto/create') }}" class="btn btn-primary float-end">Agregar uno nuevo <i
                                    class="fas fa-plus"></i></a>
                            </div>
                            <div class="col-auto">
                                <a href="{{route('producto/reporte') }}" target="_blank" class="btn btn-danger float-end">reporte pdf <i
                                    class="fas fa-file-pdf"></i></a>
                            </div>
                            <div class="col-auto">
                                <form action="{{route("producto/reporte_excel")}}" method="post">
                                    {{$this->InputCsrf()}}
                                    <button class="btn btn-outline-success">reporte excel</button>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped nowrap responsive" id="table_productos"
                                style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Foto</th>
                                        <th>Producto</th>
                                        <th>Descripción</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="productos_papelera" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped nowrap responsive"
                                id="table_productos_papelera" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- MODAL PARA EDITAR PRODUCTOS --}}
    <div class="modal fade" id="modal_editar_producto">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Editar producto</h5>
                </div>

                <div class="modal-body">
                    <form action="{{ route('producto/store') }}" method="post" enctype="multipart/form-data"
                        id="form_producto">
                        {{ $this->InputCsrf() }}
                        <div class="row">

                            <div class="col-12 text-center">
                                <img src="{{ asset('dist/img/avatar.png') }}" id="image_preview" alt=""
                                    class="img-fluid" style="border-radius: 50%;width: 160px;height: 160px;">
                            </div>
                            <div class="col-12 text-center">
                                <button class="btn btn-info" id="select_foto">Seleccionar imágen <i
                                        class="fas fa-upload"></i></button>
                            </div>
                            <div class="col-xl-7 col-lg-7 col-md-6 col-12">
                                <div class="form-group  d-none">
                                    <label for="foto"><b>Seleccione una imágen</b></label>
                                    <input type="file" name="foto" id="foto" class="form-control">
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-8 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="nombre_producto"><b>Nombre producto (*)</b></label>
                                    <input type="text" name="nombre_producto" id="nombre_producto" class="form-control">
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="precio"><b>Precio (*)</b></label>
                                    <input type="text" name="precio" id="precio" class="form-control">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="descripcion"><b>Descripción</b></label>
                                    <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="update">Guardar cambios <i class="fas fa-save"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var TablaProductos, TablaProductoEnPapelera;
        var TOKEN = "{{ $this->Csrf() }}";
        var URL_BASE = "{{ env('BASE_URL') }}";
        var ID_PRODUCTO;
        $(document).ready(function() {


            $('#tab_productos').on('click', 'a', function(evento) {
                evento.preventDefault();
                if ($(this)[0].id === 'producto_e') {
                    showProductos();

                    Editar('#table_productos tbody', TablaProductos);
                    ConfirmDelete('#table_productos tbody', TablaProductos);
                } else {
                    showProductosEnPapelera();
                    Activar('#table_productos_papelera tbody', TablaProductoEnPapelera);
                    ConfirmarForceDelete('#table_productos_papelera tbody', TablaProductoEnPapelera)
                }

                $(this).tab("show")
            });

            $('#select_foto').click(function(evento) {
                evento.preventDefault();
                $('#foto').click();
            });

            /// modificar
            $('#update').click(function() {
                modificar(ID_PRODUCTO);
            });
        });
        /** Método para mostrar los productos en el DataTable**/
        function showProductos() {
            TablaProductos = $('#table_productos').DataTable({
                retrieve: true,
                responsive: true,
                ajax: {
                    url: URL_BASE + "producto/mostrarProductos?_token=" + TOKEN + "&&operador=is",
                    method: "GET",
                    dataSrc: "response",
                },
                columns: [{
                        "data": null,
                        render: function() {
                            return `
                          <button class='btn btn-warning btn-sm' id='editar'><i class='fas fa-edit'></i></button>
                          <button class='btn btn-danger btn-sm' id='delete'><i class='fas fa-trash-alt'></i></button>
                          `;
                        }
                    },
                    {
                        "data": "foto",
                        render: function(foto) {
                            let RutaImagen = "";
                            if (foto == null) {
                                RutaImagen = "{{ asset('dist/img/avatar.png') }}";
                            } else {

                                RutaImagen = "{{ asset('dist/foto/') }}" + foto;
                            }

                            return '<img src=' + RutaImagen +
                                ' style="width:35px;height:35px;border-radius:50%">';
                        }
                    },
                    {
                        "data": "nombre_producto"
                    },
                    {
                        "data": "descripcion",
                        render: function(desc) {
                            if (desc == null) {
                                return '<span class="text-danger">Producto sin descripción...</span>';
                            }

                            return desc;
                        }
                    },
                    {
                        "data": "precio",
                        render: function(precio) {
                            return precio + "<b> USD</b>";
                        }
                    }
                ]
            }).ajax.reload();
        }


        /** Método para mostrar los productos eliminados en el DataTable**/
        function showProductosEnPapelera() {
            TablaProductoEnPapelera = $('#table_productos_papelera').DataTable({
                retrieve: true,
                responsive: true,
                ajax: {
                    url: URL_BASE + "producto/mostrarProductos?_token=" + TOKEN + "&&operador=is not",
                    method: "GET",
                    dataSrc: "response",
                },
                columns: [{
                        "data": null,
                        render: function() {
                            return `
                          <button class='btn btn-info btn-sm' id='activar'><i class='fas fa-refresh'></i></button>
                          <button class='btn btn-danger btn-sm' id='force_delete'><i class='fas fa-trash-alt'></i></button>
                          `;
                        }
                    },

                    {
                        "data": "nombre_producto"
                    },

                    {
                        "data": "precio",
                        render: function(precio) {
                            return precio + "<b> USD</b>";
                        }
                    }
                ]
            }).ajax.reload();
        }

        /*Método para editar*/
        function Editar(Tbody, Tabla) {
            $(Tbody).on('click', '#editar', function() {
                /// obtenemos la fila seleccionado
                let Fila = $(this).parents('tr');

                if (Fila.hasClass('child')) {
                    Fila = Fila.prev();
                }

                /// obtenemos los datos
                let Data = Tabla.row(Fila).data();

                /// llamamos al modal para editar
                ID_PRODUCTO = Data.id_producto;
                $('#modal_editar_producto').modal("show")
                $('#nombre_producto').val(Data.nombre_producto);
                $('#precio').val(Data.precio);
                $('#descripcion').val(Data.descripcion);

                let Foto = Data.foto == null ? "{{ asset('dist/img/avatar.png') }}" : "{{ asset('dist/foto/') }}" +
                    Data.foto;

                $('#image_preview').attr('src', Foto);
            });
        }

        /*Método para activar el producto*/
        function Activar(Tbody, Tabla) {
            $(Tbody).on('click', '#activar', function() {
                /// obtenemos la fila seleccionado
                let Fila = $(this).parents('tr');

                if (Fila.hasClass('child')) {
                    Fila = Fila.prev();
                }

                /// obtenemos los datos
                let Data = Tabla.row(Fila).data();

                /// llamamos al modal para editar
                ID_PRODUCTO = Data.id_producto;

                DeleteSoft(ID_PRODUCTO, "activar");
            });
        }

        /*Método para activar el producto*/
        function ConfirmarForceDelete(Tbody, Tabla) {
            $(Tbody).on('click', '#force_delete', function() {
                /// obtenemos la fila seleccionado
                let Fila = $(this).parents('tr');

                if (Fila.hasClass('child')) {
                    Fila = Fila.prev();
                }

                /// obtenemos los datos
                let Data = Tabla.row(Fila).data();

                /// llamamos al modal para editar
                ID_PRODUCTO = Data.id_producto;

                Swal.fire({
                    title: "Estas seguro de eliminar por completo al producto "+Data.nombre_producto+" ?",
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Si, eliminar",
                    
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    ForzarEliminado(ID_PRODUCTO)
                });
            });
        }

        /** Forzar eliminado*/
        function ForzarEliminado(id)
        {
            let FormForzeDelete = new FormData();
            FormForzeDelete.append("_token",TOKEN);
            axios({
                url:URL_BASE+"producto/ForceDelete/"+id,
                data:FormForzeDelete,
                method:"POST",
            }).then(function(response){
              if(response.data.response === 'ok')
              {
                Swal.fire({
                    title:"Mensaje del sistema!",
                    text:"Producto eliminado",
                    icon:"success"
                }).then(function(){
                showProductosEnPapelera();
                });
              }else
              {
                Swal.fire({
                    title:"Mensaje del sistema!",
                    text:"Error al eliminar producto",
                    icon:"error"
                })
              }
            });
        }

        /*Método para eliminado lógico*/
        function ConfirmDelete(Tbody, Tabla) {
            $(Tbody).on('click', '#delete', function() {
                /// obtenemos la fila seleccionado
                let Fila = $(this).parents('tr');

                if (Fila.hasClass('child')) {
                    Fila = Fila.prev();
                }

                /// obtenemos los datos
                let Data = Tabla.row(Fila).data();

                /// llamamos al modal para editar
                ID_PRODUCTO = Data.id_producto;

                Swal.fire({
                    title: "Estas seguro de eliminar al producto " + Data.nombre_producto + " ?",
                    text: "Al eliminar el producto, se quitará automaticamente de la lista de productos existentes!",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        /// eliminar
                        DeleteSoft(ID_PRODUCTO, "eliminado_logico");
                    }
                });
            });
        }

        /*Modificar los productos*/
        function modificar(id) {
            let FormProducto = new FormData(document.getElementById('form_producto'))
            $.ajax({
                url: URL_BASE + "producto/modificar/" + id,
                method: "POST",
                data: FormProducto,
                contentType: false,
                processData: false,
                success: function(response) {
                    response = JSON.parse(response);

                    if (response.response === 'ok') {
                        Swal.fire({
                            title: "Mensaje del sistema!",
                            text: "Producto modificado",
                            icon: "success"
                        }).then(function() {
                            $('#modal_editar_producto').modal("hide");
                            showProductos();
                        });
                    } else {
                        if (response.response === 'error token') {
                            Swal.fire({
                                title: "Mensaje del sistema!",
                                text: "Error en el token",
                                icon: "error"
                            })
                        } else {
                            Swal.fire({
                                title: "Mensaje del sistema!",
                                text: "Error al modificar producto",
                                icon: "error"
                            })
                        }
                    }
                }
            });
        }

        /*eliminado lógico*/
        function DeleteSoft(id, operacion) {
            let Form = new FormData();
            Form.append("_token", TOKEN);
            Form.append("operacion", operacion)
            axios({
                url: URL_BASE + "producto/SoftDelete/" + id,
                method: "POST",
                data: Form
            }).then(function(respuesta) {
                if (respuesta.data.response === 'ok') {
                    Swal.fire({
                        title: "Mensaje del sistema!",
                        text: operacion === 'eliminado_logico' ? "Producto enviado a la papelera" :
                            "Producto activado",
                        icon: "success"
                    }).then(function() {
                        if (operacion === 'eliminado_logico') {
                            showProductos();
                        } else {
                            showProductosEnPapelera();
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Mensaje del sistema!",
                        text: "Error al eliminar producto",
                        icon: "error"
                    });
                }
            });
        }
    </script>
@endsection
