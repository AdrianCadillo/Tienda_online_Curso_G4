<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tienda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset("dist/css/estilos.css")}}">
  {{---CSS SWEETALERT 2----}}
  <link rel="stylesheet" href="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.css">
  <link rel="stylesheet" href="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.min.css">
 
</head>
<body>
    @include(component("nav_tienda")) 
   <div class="container-fluid">
    
    @include(component("pagar")) 
     
   </div>
 
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<!--- SDK DE PAYPAL -->
<script src="https://www.paypal.com/sdk/js?client-id=AfVBIjJfb-KupWJDIW6lOtzSoRm_OJicZcesHM9B0kPblORrqvRMcPSLvrjn8s14xcLoFuTgP2qr2YY2&currency=USD">
</script>
{{--- SWEET ALERT 2---}}
<script src="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
<script src="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.js"></script>
<script src="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
<script>
var TOKEN = "{{ $this->Csrf() }}";
var URL_BASE = "{{ env('BASE_URL') }}";
 paypal.Buttons({
    style: {
    layout: 'horizontal',
    color:  'gold',
    shape:  'pill',
   
  },
  createOrder:function(data,actions)
  {
    return actions.order.create({
        purchase_units:[{
            amount:{
                value:"{{$TotalCompra}}"
            }
        }]
    })
  },
  onCancel:function(data)
  {
    alert("ACABADE CANCELAR EL ID DE LA TRANSACCIÓN : "+data.orderID)
  },
  onApprove:function(data,actions){
    actions.order.capture().then(function(detalle_de_la_compra){
       /// obtenemos la fecha de la transacción
       let FechaTransaccion = detalle_de_la_compra.create_time;
       FechaTransaccion = FechaTransaccion.split('T');
       let FechaCompra = FechaTransaccion[0];
       let HoraCompra = FechaTransaccion[1].split("Z")[0];
       let FechaCompraRegistrada = FechaCompra +" "+HoraCompra;
       /// id de la transacción
       let TransaccionId = detalle_de_la_compra.id;
       /// estado de la compra
       let EstadoCompra = detalle_de_la_compra.status;
       /// correo
       let Correo = detalle_de_la_compra.payer.email_address;
       let Cliente = detalle_de_la_compra.payer.name.given_name+" "+detalle_de_la_compra.payer.name.surname;
       /// cliente id
       let IdCliente = detalle_de_la_compra.payer.payer_id;

       RegistrarCompra(
        TransaccionId,FechaCompraRegistrada,EstadoCompra,Correo,
        Cliente,IdCliente
       );
    });
  }
 }).render('#paypal_button');
 
 /** Método que realiza el registro a la tabla compra y detalle_compra*/
 function RegistrarCompra(
    transaccion_id_,fecha_,estado_,email_,cliente_,
    cliente_id_
 )
 {
    $.ajax({
     url:URL_BASE+"carrito/save_pagar",
     method:"POST",
     data:{
        _token:TOKEN,transaccion_id:transaccion_id_,
        fecha:fecha_,estado:estado_,email:email_,cliente:cliente_,
        cliente_id:cliente_id_
     },
     success:function(response)
     {
        response = JSON.parse(response);
       
        if(response.response === 'ok')
        {
            Swal.fire({
                title:"Mensaje del sistema!",
                text:"Su compra se ha completado correctamente.😀😀",
                icon:"success"
            }).then(function(){
                history.back();
            });
        }
        else
        {
            Swal.fire({
                title:"Mensaje del sistema!",
                text:"Error al registrar su compra😔",
                icon:"error"
            });
        }
     }
    });
 }
</script>
</body>
</html>