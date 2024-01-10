<nav class="navbar navbar-expand-lg navbar-warning bg-warning">
    <div class="container-fluid">
      <a class="navbar-brand text-dark" href="tienda"><b>Tienda</b></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="#"><b>Login <i class="fas fa-sign-in"></i></b></a>
        </div>
      </div>
      <div class="nav-item ml-auto">
        <a href="{{route("carrito")}}" class="text-dark"><i class="fas fa-shopping-cart">( {{$this->CantidadProductosEnCarrito()}} )</i></a>
       </div>
    </div>
  </nav>
 