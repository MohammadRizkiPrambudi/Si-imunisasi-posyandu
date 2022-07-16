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
  $usia = $_POST["usia"];

  $simpan = "INSERT INTO ref_vaksin VALUES('','$nama','$usia')";

  mysqli_query($koneksi, $simpan);

  if (mysqli_affected_rows($koneksi) > 0) {
    echo "
    <script>
    alert('Data berhasil disimpan');
    document.location.href='index.php?hal=vaksin';
    </script>
    ";
  }else{
    echo "
    <script>
    alert('Data gagal disimpan');
    document.location.href='index.php?hal=vaksin';
    </script>
    ";
  }


}



?>

<h4 class="font-weight-bold">Halaman Tambah Vaksin</h4>
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Tambah Vaksin</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form method="post" action="" id="frmvaksin">
    <div class="card-body">
     <div class="form-group">
      <label for="nama">Nama Vaksin</label>
      <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama Vaksin">
    </div>
    <div class="form-group">
      <label for="Usia">Usia Wajib</label>
      <input type="text" name="usia" id="usia" class="form-control" autocomplete="off" placeholder="Masukkan Usia Wajib" required>
    </div>
  </div>
  <!-- /.card-body -->
  <div class="card-footer">
    <button type="submit" class="btn btn-info" name="tambah">Simpan</button>
    <button type="reset" class="btn btn-danger">Reset</button>
    <a href="index.php?hal=vaksin" class="btn btn-success">Kembali</a>
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