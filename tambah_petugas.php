<?php  


if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

include 'koneksi.php';


if (isset($_POST["tambah"])) {
  $nama = $_POST["nama"];
  $jabatan = $_POST["jabatan"];
  $jk = $_POST["jk"];
  $tempat = $_POST["tempat"];
  $tanggal = $_POST["tanggal"];
  $alamat = $_POST["alamat"];
  $nowa = $_POST["nowa"];
  $status = $_POST["status"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $level = $_POST["level"];
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
      move_uploaded_file($tmpfile, 'assets/dist/img/'.$namafile);
      $query = "INSERT INTO ref_petugas VALUES('','$nama','$jabatan','$jk','$tempat','$tanggal','$alamat','$nowa', '$namafile', '$status')";

      mysqli_query($koneksi, $query);
      if (mysqli_affected_rows($koneksi) > 0) {
       echo "
       <script>
       alert('Data berhasil disimpan');
       document.location.href='index.php?hal=petugas';
       </script>
       ";
     }else{
      echo "
      <script>
      alert('Data gagal disimpan');
      document.location.href='index.php?hal=petugas';
      </script>
      ";
      
    }
  }
}else{
  $query = "INSERT INTO ref_petugas VALUES('','$nama','$jabatan','$jk','$tempat','$tanggal','$alamat','$nowa','', '$status')";

  mysqli_query($koneksi, $query);
  if (mysqli_affected_rows($koneksi) > 0) {
   echo "
   <script>
   alert('Data berhasil disimpan');
   document.location.href='index.php?hal=petugas';
   </script>
   ";
 }else{
  echo "
  <script>
  alert('Data gagal disimpan');
  document.location.href='index.php?hal=petugas';
  </script>
  ";
  
}
}


}



?>

<h4 class="font-weight-bold">Halaman Tambah Petugas</h4>
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Tambah Data Petugas</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form method="post" action="" id="frmpetugas" enctype="multipart/form-data">
    <div class="card-body">
     <div class="form-group">
      <label for="nama">Nama Petugas</label>
      <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama">
    </div>
    <div class="form-group">
      <label for="jabatan">Jabatan Petugas</label>
      <input type="text" name="jabatan" id="jabatan" class="form-control" autocomplete="off" placeholder="Masukkan Jabatan">
    </div>
    <div class="form-group">
      <label for="jk">Jenis Kelamin</label>
      <div class="custom-control custom-radio">
        <input class="custom-control-input custom-control-input-danger" type="radio" id="l" name="jk" value="L" checked>
        <label for="l" class="custom-control-label">Laki-Laki</label>
      </div>
      <div class="custom-control custom-radio">
        <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" id="p" name="jk" value="P">
        <label for="p" class="custom-control-label">Perempuan</label>
      </div>        
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="tempat">Tempat Lahir</label>
          <input type="text" name="tempat" id="tempat" class="form-control" autocomplete="off" placeholder="Masukkan Tempat Lahir">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="tanggal">Tanggal Lahir</label>
          <input type="date" name="tanggal" id="tanggal" class="form-control" autocomplete="off" placeholder="Masukkan Tanggal Lahir">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <input type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" placeholder="Masukkan Alamat">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="nowa">No Wa</label>
          <input type="text" name="nowa" id="nowa" class="form-control" autocomplete="off" placeholder="Masukkan No WA">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="nama">Status Aktif</label>
      <select class="form-control" id="status" name="status" style="width: 100%">
        <option>--Silahkan Pilih--</option>
        <option>Aktif</option>
        <option>Tidak</option>
      </select>
    </div>
    <img src="https://via.placeholder.com/500x500.png?text=PAS+FOTO+PETUGAS" width="100px" style="display:block;" class="img-preview mb-3">
    <div class="input-group">
      <input type="file" class="form-control tampil" name="foto" onchange="previewImage()">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-folder"></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" class="form-control" autocomplete="off" placeholder="Masukkan Username">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" class="form-control" autocomplete="off" placeholder="Masukkan Password">
    </div>
    <div class="form-group">
      <label for="nama">Level</label>
      <select class="form-control" id="status" name="status" style="width: 100%">
        <option>--Silahkan Pilih--</option>
        <option value="admin">Admin</option>
        <option value="kader">Kader</option>
      </select>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
    <button type="submit" class="btn btn-info" name="tambah">Simpan</button>
    <button type="reset" class="btn btn-danger">Reset</button>
    <a href="index.php?hal=petugas" class="btn btn-success">Kembali</a>
  </div>
</form>
</div>
<!-- /.card -->
<!-- jquery-validation -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/plugins/jquery-validation/additional-methods.min.js"></script>

<!-- <script type="text/javascript">
  $('#frmsiswa').validate({
  rules: {
    nama: {
      required : true,
    },
    nis: {
      required : true,
    },
    kelas: {
      required : true,
    },
  },
  messages: {
    nis: {
      required: "Form NIS harus diisi",
    },
    nama: {
      required: "Silahkan Isi Nama Siswa",
    },
    kelas: {
      required: "Silahkan Isi Kelas Siswa",
    },
  },
  errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
});
</script> -->
