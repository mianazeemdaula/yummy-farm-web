
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SHOUKAT HOSPITAL | Report</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body>
<div class="wrapper col-md-11" style="margin:auto;">
  <!-- Main content -->
  <section class="">
    <!-- title row -->
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <h4 class="page-header">
          <i class="fas fa-hospital"></i>SHOUKAT SURGICAL HOSPITAL
        </h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <h6 class="page-header">
          GOVERNMENT COLONY OKARA MAIN ROAD, DEPALPUR
        </h6>
      </div>
    </div>
    <div class="row">
      <div class="col-12 d-flex justify-content-center">
        <h6 class="page-header">
          044-4542324
        </h6>
      </div>
    </div>
    <div class="p-2">
      @yield('content')
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript"> 
  window.addEventListener("load", window.print());
</script>
</body>
</html>
