<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ruang Absen</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="#"><b>Ruang</b>Absen</a>
  </div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item text-center">
        <h2>Selamat Datang</h2>
  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Silahkan login dengan akun Kamu
  </div>
  <div class="text-center">
    <a href="{{ url('login') }}">login</a>
  </div>
  <div class="lockscreen-footer text-center">
    Project Akhir <b><a href="https://orbitfutureacademy.id/" class="text-black">Orbit Future Academy</a></b><br>
    Kelompok Decode
  </div>
</div>
<!-- /.center -->

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
