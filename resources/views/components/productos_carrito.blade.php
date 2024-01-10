<br>
@if ($this->ExistSession("carrito") and count($this->getSession("carrito")) > 0)
@php
    $Importe = 0.00
@endphp
<table class="table table-bordered" id="tabla_carrito">
    <thead>
        <tr>
            <th>Quitar</th>
            <th>Foto</th>
            <th>Cantidad</th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Importe</th>
        </tr>
    </thead>
     <tbody>
        @foreach ($this->getSession("carrito") as $producto=>$carrito)
        @php
            $Importe = $carrito["precio"] * $carrito["cantidad"];
        @endphp
         <tr>
            <td>
                <form action="{{route("carrito/quitar_de_la_cesta")}}" method="post">{{-- [carrito][producto][cantidad]--}}
                    {{$this->InputCsrf()}}
                    <input type="hidden" value="{{$producto}}" name="producto_delete">
                    <button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
            <td>
                <img src="{{asset("dist/foto/".$carrito["foto"])}}" alt="" style="width: 70px;height: 70px;">
            </td>
            <td>{{$carrito["cantidad"]}}</td>
            <td>{{$producto}}</td>
            <td>{{number_format($carrito["precio"],2,',',' ')}}</td>
            <td>{{number_format($Importe,2,',',' ')}} <b>USD</b></td>
         </tr>
        @endforeach
     </tbody>
</table>
@else 
<div class="alert alert-danger">
    <b>No hay productos añadidos al carrito</b>
</div>
@endif