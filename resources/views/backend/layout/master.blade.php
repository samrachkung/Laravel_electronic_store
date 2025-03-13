<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Dashboard </title>

    @include('backend.layout.styleshop')
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
    @include('backend.layout.header')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
    @include('backend.layout.leftsidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    @yield('content')
    
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
    @include('backend.layout.footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
@include('backend.layout.jsshop')
</body>
</html>
