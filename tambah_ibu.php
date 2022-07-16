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
  $nik = $_POST["nik"];
  $alamat = $_POST["alamat"];
  $nowa = $_POST["nowa"];
  
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
      document.location.href='index.php?hal=ibu&aksi=tambah';
      </script>
      ";
    }else{
      move_uploaded_file($tmpfile, 'assets/dist/img/'.$namafile);
      $query = "INSERT INTO ref_ibu VALUES('','$nama','$nik','$alamat','$nowa', '$namafile')";

      mysqli_query($koneksi, $query);
      if (mysqli_affected_rows($koneksi) > 0) {
       echo "
       <script>
       alert('Data berhasil disimpan');
       document.location.href='index.php?hal=ibu';
       </script>
       ";
     }else{
      echo "
      <script>
      alert('Data gagal disimpan');
      document.location.href='index.php?hal=ibu';
      </script>
      ";
      
    }
  }
}else{
  $query = "INSERT INTO ref_ibu VALUES('','$nama','$nik','$alamat','$nowa', 'avatar4.png')";

  mysqli_query($koneksi, $query);
  if (mysqli_affected_rows($koneksi) > 0) {
   echo "
   <script>
   alert('Data berhasil disimpan');
   document.location.href='index.php?hal=ibu';
   </script>
   ";
 }else{
  echo "
  <script>
  alert('Data gagal disimpan');
  document.location.href='index.php?hal=ibu';
  </script>
  ";
  
}
}


}



?>

<h4 class="font-weight-bold">Halaman Tambah Ibu</h4>
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Tambah Data Ibu</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form method="post" action="" id="frmibu" enctype="multipart/form-data">
    <div class="card-body">
     <div class="form-group">
      <label for="nama">Nama Ibu</label>
      <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama">
    </div>
    <div class="form-group">
      <label for="nik">NIK Ibu</label>
      <input type="text" name="nik" id="nik" class="form-control" autocomplete="off" placeholder="Masukkan NIK Ibu">
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <input type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" placeholder="Masukkan Alamat Ibu">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="nowa">No WA</label>
          <input type="text" name="nowa" id="nowa" class="form-control" autocomplete="off" placeholder="Masukkan No WA Ibu">
          <small>*Pastikan No WA Aktif</small>
        </div>
      </div>
    </div>
    <img src="assets/dist/img/avatar3.png" width="100px" style="display:block;" class="img-preview mb-3">
    <div class="input-group">
      <input type="file" class="form-control tampil" name="foto" onchange="previewImage()">
      <div class="input-group-append">
        <div class="input-group-text">
          <span class="fas fa-folder"></span>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
    <button type="submit" class="btn btn-info" name="tambah">Simpan</button>
    <button type="reset" class="btn btn-danger">Reset</button>
    <a href="index.php?hal=ibu" class="btn btn-success">Kembali</a>
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
</script>
 -->