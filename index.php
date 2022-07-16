<?php 
session_start(); 

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

ob_start();

// mengatur menu aktif

$hal = @$_GET['hal'];

if ($hal == '') {
  $hAktif = 'active';
}elseif ($hal == 'anak') {
  $masteraktif1='menu-open';
  $masteraktif2='active';
  $aAktif = 'active';
}elseif ($hal == 'penimbangan') {
  $peAktif = 'active';
}elseif ($hal == 'rangking') {
  $peAktif = 'active';
}elseif ($hal=='vaksin') {
  $masteraktif1='menu-open';
  $masteraktif2='active';
  $vAktif = 'active';
}elseif ($hal=='profil') {
  $proAktif = 'active'; 
}elseif($hal=='petugas'){
  $masteraktif1='menu-open';
  $masteraktif2='active';
  $pAktif = 'active';
}elseif($hal=='jadwal'){
  $masteraktif2='menu-open';
  $masteraktif3='active';
  $jAktif = 'active';
}elseif($hal=='pelaksanaan'){
  $masteraktif2='menu-open';
  $masteraktif3='active';
  $pelAktif = 'active';
}elseif ($hal=='pemberitahuan') {
  $masteraktif2='menu-open';
  $masteraktif3='active';
  $pemAktif = 'active';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>POSYANDU</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="icon" href="assets/dist/img/favicon.ico">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Select2 -->
  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- dataTables -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bootstrap4.min.css"> -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="assets/plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index.php" class="nav-link text-dark">POSYANDU DESA DONOSARI KEC. ABC KAB. ABC</a>
        </li>
      </ul>
      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <div class="dropdown-divider"></div>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <span class="brand-text ml-4"><i class="fas fa-baby fa-lg text-danger mr-2"></i>POSYANDU</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <?php if ($_SESSION["foto"] == "-"): ?>
              <img src="assets/dist/img/default.png" class="img-circle elevation-2" alt="User Image">
              <?php else : ?>
                <img src="assets/dist/img/<?= $_SESSION["foto"]; ?>" class="img-circle elevation-2" alt="User Image">
              <?php endif ?>
            </div>
            <div class="info">
              <a href="#" class="d-block"><?= $_SESSION["nama"]; ?>
              <br>Login sebagai, <?= $_SESSION["level"]; ?>
            </a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
           <li class="nav-item">
            <a href="index.php" class="nav-link <?= $hAktif; ?>">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          
          <li class="nav-item <?= $masteraktif1; ?>">
            <a href="#" class="nav-link <?= $masteraktif2; ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Master Data
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview ml-3">
              <li class="nav-item">
                <a href="?hal=vaksin" class="nav-link <?= $vAktif; ?>">
                  <i class="nav-icon fas fa-vial"></i>
                  <p>
                    Vaksin
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?hal=anak" class="nav-link <?= $aAktif; ?>">
                  <i class="nav-icon fas fa-child"></i>
                  <p>
                    Anak
                  </p>
                </a>
              </li>
              <?php if ($_SESSION["level"] == 'admin'): ?>
                <li class="nav-item">
                  <a href="?hal=petugas" class="nav-link <?= $pAktif; ?>">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                      Petugas
                    </p>
                  </a>
                </li>
              <?php endif ?>
            </ul>
          </li>
          <li class="nav-item">
            <a href="?hal=penimbangan" class="nav-link <?= $peAktif; ?>">
              <i class="nav-icon fas fa-weight"></i>
              <p>
                Penimbangan
              </p>
            </a>
          </li>

          <li class="nav-item <?= $masteraktif2; ?>">
            <a href="#" class="nav-link <?= $masteraktif3; ?>">
              <i class="nav-icon fas fa-syringe"></i>
              <p>
                Imunisasi
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview ml-3">
              <li class="nav-item">
                <a href="?hal=jadwal" class="nav-link <?= $jAktif; ?>">
                  <i class="nav-icon fas fa-calendar"></i>
                  <p>
                    Jadwal Imunisasi
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?hal=pemberitahuan" class="nav-link <?= $pemAktif; ?>">
                  <i class="nav-icon fab fa-whatsapp"></i>
                  <p>
                    Pemberitahuan
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="?hal=pelaksanaan" class="nav-link <?= $pelAktif; ?>">
                  <i class="nav-icon fas fa-notes-medical"></i>
                  <p>
                    Pelaksanaan
                  </p>
                </a>
              </li>        
            </ul>
          </li>
          <li class="nav-item">
            <a href="?hal=profil" class="nav-link <?= $proAktif; ?>">
              <i class="nav-icon fas fa-user-secret"></i>
              <p>
                Profil
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link" data-toggle="modal" data-target="#logoutModal ">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">

      </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <?php 
        $hal = @$_GET['hal'];
        $aksi = @$_GET['aksi'];
        if($hal=='anak'){
          if ($aksi=='') {
            include 'anak.php';
          }elseif ($aksi=='tambah') {
            include 'tambah_anak.php';
          }elseif ($aksi=='edit') {
            include 'edit_anak.php';
          }
        }elseif($hal=='petugas'){
          if ($aksi=='') {
            include 'petugas.php';
          }elseif ($aksi=='tambah') {
            include 'tambah_petugas.php';
          }elseif ($aksi=='edit') {
            include 'edit_petugas.php';
          }elseif ($aksi=='print') {
            include 'lap_petugas.php';
          }
        }elseif($hal=='penimbangan'){
          if ($aksi=='') {
            include 'penimbangan.php';
          }elseif($aksi=='edit'){
            include 'edit_penimbangan.php';
          }elseif ($aksi=='penimbanganperanak') {
            include 'penimbanganperanak.php';
          }elseif ($aksi=='tambah') {
            include 'tambah_penimbangan.php';
          }elseif ($aksi=='grafik_bbperanak') {
            include 'grafik_bbperanak.php';
          }elseif ($aksi=='grafik_tbperanak') {
            include 'grafik_tbperanak.php';
          }elseif ($aksi=='grafik_lingkarkepalaperanak') {
            include 'grafik_lingkarkepalaperanak.php';
          }
        }elseif($hal=='vaksin'){
         if ($aksi == '') {
           include 'vaksin.php';
         }elseif($aksi=='tambah'){
          include 'tambah_vaksin.php';
        }elseif ($aksi=='edit') {
         include 'edit_vaksin.php';
       }
     }elseif($hal=='password'){
      include 'password.php';
    }elseif($aksi=='ubah'){
      include 'password.php';
    }elseif ($hal=='') {
      include 'home.php';
    }elseif ($hal=='jadwal') {
      if ($aksi == '') {
       include 'jadwal_imunisasi.php';
     }elseif($aksi=='jadwalperanak'){
      include 'jadwal_imunisasiperanak.php';
    }elseif ($aksi=='imunisasi') {
      include 'imunisasi.php';
    }
  }elseif ($hal=='pelaksanaan') {
    if ($aksi == '') {
     include 'pelaksanaan.php';
   }elseif ($aksi == 'grafik_imunisasi') {
     include 'grafik_imunisasi.php';
   }
 }elseif ($hal=='profil') {
  if ($aksi == '') {
   include 'profil.php';
 }
}elseif ($hal == 'pemberitahuan') {
  if ($aksi == '') {
   include 'pemberitahuan.php';
 }
}
?>

</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer text-center">
  <strong>Copyright &copy; <?= date ('Y'); ?>. RR </strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Apakah akan logout ?</h5>
      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
      </button>
    </div>
    <div class="modal-body">Jika akan logout pilih tombol logout</div>
    <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      <a class="btn btn-primary" href="logout.php">Logout</a>
    </div>
  </div>
</div>
</div>

<!-- jQuery -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
<!-- sweetalert -->
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- chart-js -->
<script src="assets/plugins/chart.js/Chart.bundle.js"></script>
<!-- datatables -->
<!-- <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script> -->
<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets/plugins/jszip/jszip.min.js"></script>
<script src="assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- myjs -->
<script src="assets/dist/js/myjs.js"></script>
<!-- Toastr -->
<script src="assets/plugins/toastr/toastr.min.js"></script>
<!-- select2 -->
<script src="assets/plugins/select2/js/select2.full.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
</body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#example1').DataTable( {
      pageLength: 5,
      lengthMenu: [5, 10, 20, 50, 100, 200, 500],
      responsive: true,
      autoWidth: false,
      lengthChange: true,
      buttons: [ 
      {
        extend: 'excelHtml5',
        title: 'Data Export E-BOOK Excel',
      },
      {
        extend: 'print',
        title: 'Data Export E-BOOK PDF',
        download : 'open'
      }
      ]
    } );
    
    table.buttons().container()
    .appendTo( '#example1_wrapper .col-md-6:eq(0)' );
  } );

</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#example, #example2').DataTable( {
      pageLength: 5,
      lengthMenu: [5, 10, 20, 50, 100, 200, 500],
      
    });
  });
</script>
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>

<script type="text/javascript">
  $(document).ready(function(){
   $('#id_petugas').select2();
 })
</script>
