<br>
@if (isset($Productos))
     @if (count($Productos) > 0)
     <div class="row">
       @foreach ($Productos as $producto)
            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
             <div class="card my-1">
               <div class="card-header">
                {{$producto->nombre_producto}}
               </div>   

               <form action="{{route('carrito/addCart')}}" method="post">
                {{$this->InputCsrf()}}
                <div class="card-body">
                 <div class="row">
                    <div class="col-12">
                        <img src="{{asset("dist/foto/".$producto->foto)}}" alt=""
                        style="height:210px;" class="img-fluid">
                    </div>
                    <div class="col-12 my-2">
                        <span><h4>Precio : {{number_format($producto->precio,2,',',' ')}} <b>USD</b></h4></span>
                        <input type="hidden" value="{{$producto->id_producto}}" name="producto_id">
                    </div>
                 </div>
                </div>
                <div class="card-footer">
                    <button class="btn_success">Añadir al carrito <i class="fas fa-shopping-cart"></i></button>
                </div>
               </form>
             </div>    
            </div>   
       @endforeach
    </div>  
      @else 
      <div class="alert alert-warning"><b>No hay productos para mostrar</b></div>
     @endif
@else
<div class="alert alert-danger"><b>No existe la variable Producto</b></div>
@endif