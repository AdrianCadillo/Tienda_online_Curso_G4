<br>
 
@if ($this->ExistSession("carrito") and count($this->getSession("carrito")) > 0)
@php
    $Importe = 0.00;  $TotalImporte = 0.00;
@endphp
<div class="table-responsive">
    <table class="table table-bordered" id="tabla_carrito">
        <thead>
            <tr>
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
                <td colspan="4">Total importe S/. </td>
                <td colspan="1">{{number_format($TotalImporte,2,',',' ')}} <b>USD</b></td>
            </tr>
             
         </tfoot>
    </table>
</div>
<div class="row justify-content-center">
    <div class="col-xl-4 col-lg-4 col-md-5 col-12">
        <div id="paypal_button"></div>
    </div>
</div>
@else 
<div class="alert alert-danger">
    <b>No hay productos añadidos al carrito
        <a href="" class="btn btn-primary"> <i class="fas fa-arrow-right"></i>Ir a compra</a>
    </b>
</div>
@endif