<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crear cuenta-cliente</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset("plugins/fontawesome-free/css/all.min.css")}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset("dist/css/adminlte.min.css")}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
 <div class="container-fluid">
    @if ($this->ExistSession("error_confirm"))
    <div class="alert alert-danger my-4">
        <b>{{$this->getSession("error_confirm")}} <a href="{{route("tienda")}}">Ir a la tienda</a></b>
    </div>
    {{$this->destroyOneSesion("error_confirm")}}
    @else 
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-xl-5 col-lg-5 col-md-6 col-12">
          <div class="card card-info">
              <div class="card-header text-center">
                <h4> <b>Confirmar la cuenta</b> </h4>
              </div>
              <div class="card-body">
                @if ($this->ExistSession("error_"))
                <div class="alert alert-danger my-4">
                    <b>{{$this->getSession("error_")}}</b>
                </div>
                {{$this->destroyOneSesion("error_")}}
                @endif
                <form action="{{route("cliente/confirm_cuenta")}}" method="post">
                    {{$this->InputCsrf()}}
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Ingrese código...."
                    name="codigo">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="row justify-content-center">
                    <!-- /.col -->
                    <div class="col-xl-5 col-lg-5 col-md-6 col-12">
                      <button type="submit" class="btn btn-outline-success btn-block">Activar mi cuenta <i class="fas fa-refresh"></i></button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
            
              </div>
              <!-- /.form-box -->
            </div><!-- /.card -->
        </div>
      </div>
    @endif
 </div>
 
<!-- jQuery -->
<script src="{{asset("plugins/jquery/jquery.min.js")}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("dist/js/adminlte.min.js")}}"></script>
</body>
</html>
