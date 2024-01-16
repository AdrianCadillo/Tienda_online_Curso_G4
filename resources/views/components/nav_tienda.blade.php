<nav class="navbar navbar-expand-lg navbar-warning bg-warning">
    <div class="container-fluid">
      <a class="navbar-brand text-dark" href="{{route("tienda")}}"><b>Tienda</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav me-auto">
          <a class="nav-link active" aria-current="page" href="#"><b>Login <i class="fas fa-sign-in"></i></b></a>
        </div>
        <div class="nav-item  ml-auto">
          <div class="dropdown">
            <a href="{{route("carrito")}}" class="text-dark mx-xl-1 mx-lg-1 mx-md-1 m-0"><i class="fas fa-shopping-cart">( {{$this->CantidadProductosEnCarrito()}} )</i></a>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
             {{$this->ExistSession("user")?$this->DataUser()[0]->nombre_user:'Invitado'}}
            </button>
             
             <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              @if ($this->ExistSession("user"))
              <li><a class="dropdown-item" href="#">Mis compras</a></li>
              <li><a class="dropdown-item" href="logout" onclick="event.preventDefault(); document.getElementById('form_logout').submit()"><i class="fas fa-sign-out"></i> Cerrar sesión</a></li>
               <form action="{{route("cliente/logout")}}" method="post" id="form_logout" class="d-none">
               {{$this->InputCsrf()}}
              </form>
              @else 
              <li><a class="dropdown-item" href="{{route("login")}}"><i class="fas fa-sign-out"></i> Logín</a></li>
              @endif
            </ul>
          </div>
      </div> 
      </div>
    </div>
  </nav>
 