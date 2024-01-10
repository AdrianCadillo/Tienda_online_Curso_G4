<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title_page')</title>

  {{-- CSS PARA DATATABLE ---}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset("plugins/fontawesome-free/css/all.min.css")}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset("dist/css/adminlte.min.css")}}">

  {{---CSS SWEETALERT 2----}}
  <link rel="stylesheet" href="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.css">
  <link rel="stylesheet" href="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.min.css">
 
   
  @yield('css')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
   @include(component("nav"))
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->

  @include(component("aside"))
  <!-- Content Wrapper. Contains page content -->
  @include(component("wrapper"))
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
   
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  @include(component("footer"))

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

{{--- LIBRERIA PARA DATATABLE ----}}
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
 {{--- SWEET ALERT 2---}}
 <script src="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.all.js"></script>
 <script src="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
 <script src="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.js"></script>
 <script src="{{env('BASE_URL')}}node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
 {{--AXIOS--}}
 <script src="{{env('BASE_URL')}}node_modules/axios/dist/axios.min.js"></script>
 @yield('js')
</body>
</html>
