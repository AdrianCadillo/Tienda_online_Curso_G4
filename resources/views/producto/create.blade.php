@extends(layout("app"))

@section('title_page','crear-productos')

@section('css')
    
@endsection

@section('content')
<div class="col mt-3">
    <div class="card">
        <div class="card-header">
            <h4>Crear productos</h4>
        </div>

        <div class="card-body">
            @if ($this->ExistSession("success"))
              @if ($this->getSession("success") === 'ok')
                  <div class="alert alert-success">
                    <b>Producto registrado correctamente</b>
                  </div>
                  @else 
                  <div class="alert alert-danger">
                    <b>Error al registrar producto</b>
                  </div> 
              @endif
            {{$this->destroyOneSesion("success")}}
            @endif

            @if ($this->ExistSession("error"))
               
                  <div class="alert alert-danger">
                    <b>{{$this->getSession("error")}}</b>
                  </div> 
               
            {{$this->destroyOneSesion("error")}}
            @endif

            @if ($this->ExistSession("warning"))
               
            <div class="alert alert-warning">
              <b>El producto que desea registrar, ya existe</b>
            </div> 
         
           {{$this->destroyOneSesion("warning")}}
           @endif
            <form action="{{route('producto/store')}}" method="post" enctype="multipart/form-data" id="form_producto">
               {{$this->InputCsrf()}}
                <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="nombre_producto"><b>Nombre producto (*)</b></label>
                        <input type="text" name="nombre_producto" id="nombre_producto" class="form-control">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="descripcion"><b>Descripción</b></label>
                        <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-xl-5 col-lg-5 col-md-6 col-12">
                    <div class="form-group">
                        <label for="precio"><b>Precio (*)</b></label>
                        <input type="text" name="precio" id="precio" class="form-control">
                    </div>
                </div>

                <div class="col-xl-7 col-lg-7 col-md-6 col-12">
                    <div class="form-group">
                        <label for="foto"><b>Seleccione una imágen</b></label>
                        <input type="file" name="foto" id="foto" class="form-control">
                    </div>
                </div>
              </div>
            </form>
        </div>

        <div class="card-footer text-right">
            <button class="btn btn-primary" onclick="document.getElementById('form_producto').submit()">Guardar <i class="fas fa-save"></i></button>
        </div>
    </div>
</div>
@endsection