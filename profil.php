<?php  

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

include 'koneksi.php';

$id = $_SESSION["id"];

$profil = mysqli_query($koneksi, "SELECT * FROM ref_petugas WHERE id_petugas='$id'");

$pecah = mysqli_fetch_assoc($profil);
$datafoto = $pecah["foto_petugas"];

if (isset($_POST["ubah"])) {
  $nama = $_POST["nama"];
  $jabatan = $_POST["jabatan"];
  $jk = $_POST["jk"];
  $tempat = $_POST["tempat"];
  $tanggal = $_POST["tanggal"];
  $alamat = $_POST["alamat"];
  $nowa = $_POST["nowa"];
  $username = $_POST["username"];
  $fotolama = $_POST["fotolama"];
  
  $namafile = $_FILES["foto"]["name"];

  if ($namafile !="") {

    $tmpfile = $_FILES["foto"]["tmp_name"];

    $type1 = explode('.', $namafile );

    $type2 = $type1[1];


    $ekstensifoto = ["jpeg","jpg","png"];

    $namafile = "foto".time().'.'.$type2;

    if (!in_array($type2, $ekstensifoto)) {
      echo "
      <script>
      alert('Yang anda masukkan bukan gambar');
      document.location.href='index.php?hal=petugas&aksi=tambah';
      </script>
      ";
    }else{
      if (file_exists("assets/dist/img/$datafoto")) {
        @unlink("assets/dist/img/$datafoto");
      }
      move_uploaded_file($tmpfile, 'assets/dist/img/'.$namafile);

      $query = "UPDATE ref_petugas SET nama_petugas='$nama', jabatan_petugas='$jabatan', jk_petugas='$jk', tempat_lahir_petugas='$tempat',tgl_lahir_petugas='$tanggal', alamat_petugas='$alamat', no_telp_petugas='$nowa',foto_petugas='$namafile', username='$username' WHERE id_petugas='$id'";

      $ubah = mysqli_query($koneksi, $query);
      if ($ubah) {
       echo "
       <script>
       alert('Data berhasil diubah');
       document.location.href='index.php?hal=profil';
       </script>
       ";
     }else{
      echo "
      <script>
      alert('Data gagal diubah');
      document.location.href='index.php?hal=profil';
      </script>
      ";
      
    }
  }
}else{
  $query = "UPDATE ref_petugas SET nama_petugas='$nama', jabatan_petugas='$jabatan', jk_petugas='$jk', tempat_lahir_petugas='$tempat',tgl_lahir_petugas='$tanggal', alamat_petugas='$alamat', no_telp_petugas='$nowa',foto_petugas='$fotolama', username='$username' WHERE id_petugas='$id'";
  $ubah = mysqli_query($koneksi, $query);
  if ($ubah) {
   echo "
   <script>
   alert('Data berhasil diubah');
   document.location.href='index.php?hal=profil';
   </script>
   ";
 }else{
  echo "
  <script>
  alert('Data gagal diubah');
  document.location.href='index.php?hal=profil';
  </script>
  ";
  
}
}


}


if (isset($_POST["ubah-password"])) {

  $pass_lama = $_POST["pass_lama"];
  $username = $_POST['username'];

  $tampil = mysqli_query($koneksi, "SELECT * FROM ref_petugas WHERE username='$username' AND password='$pass_lama'");

  $data = mysqli_fetch_assoc($tampil);

  if ($data) {

    $pass_baru = $_POST["pass_baru"];
    $konfirmasi_pass = $_POST["konfirmasi_pass"];

    if ($pass_baru == $konfirmasi_pass) {
      $query = "UPDATE ref_petugas SET password ='$konfirmasi_pass' WHERE id_petugas='$id'";

      $ubah = mysqli_query($koneksi, $query);

      if ($ubah) {
        echo "
        <script>
        alert('Password Anda Berhasil Diubah, Silahkan Logout Untuk Mencobanya');
        document.location.href='index.php?hal=profil';
        </script>
        ";
      }
      

    }else{
      echo "
      <script>
      alert('Konfirmasi Password Tidak Sama');
      document.location.href='index.php?hal=profil';
      </script>
      ";
    }

  }else{
    echo "
    <script>
    alert('Password Lama Anda Salah');
    document.location.href='index.php?hal=profil';
    </script>
    ";
  }


}


?>

<h4 class="font-weight-bold">Halaman Profil</h4>
<div class="row">
  <div class="col-md-3">
    <!-- Profile Image -->
    <div class="card card-info card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <?php if ($pecah["foto_petugas"] == "-"): ?>
            <img class="profile-user-img img-fluid img-circle" src="assets/dist/img/default.png" alt="User profile picture">
            <?php else: ?>  
              <img class="profile-user-img img-fluid img-circle" src="assets/dist/img/<?= $pecah["foto_petugas"]; ?>" alt="User profile picture">
            <?php endif ?>
          </div>
          <h3 class="profile-username text-center"><?= $pecah["nama_petugas"]; ?></h3>
          <h5 class="text-muted text-center"><?= $pecah["jabatan_petugas"]; ?></h5>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="card card-info card-outline">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#profil" data-toggle="tab">Setting Profil</a></li>
            <li class="nav-item"><a class="nav-link" href="#password" data-toggle="tab">Ganti Password</a></li>      
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
           <div class="tab-pane active" id="profil">
            <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
              <div class="form-group row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="<?= $pecah["nama_petugas"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Nama" value="<?= $pecah["jabatan_petugas"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="tempat" class="col-sm-2 col-form-label">Tempat Lahir</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="tempat" name="tempat" placeholder="Tempat" value="<?= $pecah["tempat_lahir_petugas"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-10">
                  <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Tanggal" value="<?= $pecah["tgl_lahir_petugas"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="jk" value="L" <?php if ($pecah['jk_petugas'] == 'L'){ echo "checked";} ?>>
                    <label class="form-check-label">Laki-Laki</label>
                    <input class="form-check-input ml-2" type="checkbox" name="jk" value="P" <?php if ($pecah['jk_petugas'] == 'P'){ echo "checked";} ?>>
                    <label class="form-check-label ml-4">Perempuan</label>
                  </div> 
                </div>
              </div>
              <div class="form-group row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                  <textarea type="text" class="form-control" id="alamat" name="alamat" placeholder="Tempat"><?= $pecah["alamat_petugas"]; ?></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="nowa" class="col-sm-2 col-form-label">No WA</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nowa" name="nowa" placeholder="No WA" value="<?= $pecah["no_telp_petugas"]; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="username" id="username" placeholder="username" value="<?= $pecah["username"]; ?>">
                </div>
              </div>    
              <div class="form-group row">
                <label for="foto" class="col-sm-2 col-form-label">foto</label>
                <div class="col-sm-10">
                  <input type="hidden" name="fotolama" value="<?= $pecah["foto_petugas"]; ?>">
                  <input type="file" class="form-control" id="foto" name="foto" placeholder="foto">
                </div>
              </div>  
              <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                  <button type="submit" class="btn btn-danger" name="ubah">Submit</button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="password">
            <form class="form-horizontal" method="post" action="">
              <input type="hidden" name="username" value="<?= $pecah["username"]; ?>">
              <div class="form-group row">
                <label for="pass_lama" class="col-sm-2 col-form-label">Password Lama</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="pass_lama" id="pass_lama" placeholder="Password Lama" >
                </div>
              </div>   
              <div class="form-group row">
                <label for="pass_baru" class="col-sm-2 col-form-label">Password Baru</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="pass_baru" id="pass_baru" placeholder="Password Baru" >
                </div>
              </div>  
              <div class="form-group row">
                <label for="konfirmasi_pass" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control" name="konfirmasi_pass" id="konfirmasi_pass" placeholder="Konfirmasi Password" >
                </div>
              </div> 
              <div class="form-group row">
                <div class="offset-sm-2 col-sm-10">
                  <button type="submit" class="btn btn-danger" name="ubah-password">Submit</button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->