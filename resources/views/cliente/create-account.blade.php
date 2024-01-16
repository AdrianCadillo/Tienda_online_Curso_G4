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
</head>
<body>
 <div class="container-fluid">
    <div class="row justify-content-center align-items-center vh-100">
        <div class="col-xl-5 col-lg-5 col-md-6 col-12">
          <div class="card card-info">
              <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Regístra</b>te</a>
              </div>
              <div class="card-body">
               @if ($this->ExistSession("errors"))
                  <div class="alert alert-danger">
                     <ul>
                        @foreach ($this->getSession("errors") as $error)
                          <li>{{$error}}</li>
                        @endforeach
                     </ul>
                  </div>
                  {{$this->destroyOneSesion("errors")}}
               @endif

               @if ($this->ExistSession("error_mail"))
                  <div class="alert alert-danger">
                      <b>{{$this->getSession("error_mail")}}</b>
                  </div>
                  {{$this->destroyOneSesion("error_mail")}}
               @endif
                <form action="{{route("cliente/saveAccount")}}" method="post">
                    {{$this->InputCsrf()}}
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nombre del usuario...."
                    name="username">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-user"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Correo electrónico...."
                    name="email">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password..."
                    name="password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Confirmar password..."
                    name="confirm_password">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <!-- /.col -->
                    <div class="col-4">
                      <button type="submit" class="btn btn-primary btn-block">Register <img src="{{asset("dist/img/save.svg")}}" alt=""></button>
                    </div>
                    <!-- /.col -->
                  </div>
                </form>
            
              </div>
              <!-- /.form-box -->
            </div><!-- /.card -->
        </div>
      </div>
 </div>
 
<!-- jQuery -->
<script src="{{asset("plugins/jquery/jquery.min.js")}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("dist/js/adminlte.min.js")}}"></script>
</body>
</html>
