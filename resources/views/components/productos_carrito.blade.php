<br>
@if ($this->ExistSession("carrito") and count($this->getSession("carrito")) > 0)
@php
    $Importe = 0.00;$TotalImporte = 0.00;
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
            $TotalImporte+=$Importe;
        @endphp
         <tr>
            <td>
                <form action="{{route("carrito/quitar_de_la_cesta")}}" method="post" id="form_delete_producto_Carrito">{{-- [carrito][producto][cantidad]--}}
                    {{$this->InputCsrf()}}
                    <input type="hidden" value="{{$producto}}" name="producto_delete">
                    <button class="btn btn-danger" id="delete_producto"><i class="fas fa-trash-alt"></i></button>
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
     <tfoot>
        <tr>
            <td colspan="5">Total importe S/. </td>
            <td colspan="1" >{{number_format($TotalImporte,2,',',' ')}} <b>USD</b></td>
        </tr>
        <tr>
           <td colspan="6">
            @php
                $Value = $this->ExistSession("user") ? $this->getSession("user"):'';
                $Redirect = $this->ExistSession("user") ? 'carrito/checkout?id='.$Value."&&key=".hash_hmac("sha256",$Value,"curso"):'cliente/create_account';
            @endphp
            <a href="{{route($Redirect)}}" class="btn_success">Ir a pagar <i class="fas fa-shopping-cart"></i></a>
           </td>
        </tr>
     </tfoot>
</table>
@else 
<div class="alert alert-danger">
    <b>No hay productos añadidos al carrito
        <a href="{{route("tienda")}}" class="btn btn-primary"> <i class="fas fa-arrow-right"></i>Ir a compra</a>
    </b>
</div>
@endif