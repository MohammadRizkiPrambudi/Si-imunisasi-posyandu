<?php

session_start();


if(isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='index.php';
  </script>
  ";
}

include 'koneksi.php';

if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $query = mysqli_query($koneksi, "SELECT * FROM ref_petugas WHERE username='$username'");
  $data = mysqli_fetch_assoc($query);
  

  if ($data) {

    if ($password == $data["password"]) {
      if($data["level"]=="admin"){
        $_SESSION["login"] = true;
        $_SESSION["admin"]= true;
        $_SESSION["id"] = $data["id_petugas"];
        $_SESSION["username"] = $data["username"];
        $_SESSION["nama"] = $data["nama_petugas"];
        $_SESSION["foto"] = $data["foto_petugas"];
        $_SESSION["level"] = $data["level"];
        echo "
        <script>
        window.location.href='index.php';
        </script>
        ";
      }elseif($data["level"]=='kader'){
        $_SESSION["login"] = true;
        $_SESSION["kader"]= true;
        $_SESSION["id"] = $data["id_petugas"];
        $_SESSION["username"] = $data["username"];
        $_SESSION["nama"] = $data["nama_petugas"];
        $_SESSION["foto"] = $data["foto_petugas"];
        $_SESSION["level"] = $data["level"];
        echo "
        <script>
        window.location.href='index.php';
        </script>
        ";
      }

    }else{
      echo "
      <script>
      alert('Password anda salah');
      window.location.href='login.php';
      </script>
      ";
    }
    
  }else{
    echo "
    <script>
    alert('Username Anda Salah');
    window.location.href='login.php';
    </script>
    ";
    

  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SI POSYANDU</title>

  <!-- icon -->
  <link rel="icon" href="assets/dist/img/favicon.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <style type="text/css">
    .login-page{
      background-color: #00FFAB;
    }
  </style>

</head>
<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-success">
      <div class="card-header text-center">
        <img src="assets/dist/img/logo.png" width="120"><br>
        <a href="login.php" class="h1"><b>SI POSYANDU</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Silahkan login terlebih dahulu</p>
        <form action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-unlock"></span>
              </div>
            </div>
          </div>
          <div class="row">
           <div class="col">
            <button type="submit" class="btn btn-success btn-block" name="login">Login</button>
          </div> 
          <!-- /.col -->
          <div class="col">
            <button type="reset" class="btn btn-danger btn-block">Reset</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>


