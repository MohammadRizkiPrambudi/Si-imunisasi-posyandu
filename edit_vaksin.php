<?php  

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}


include 'koneksi.php';

if (isset($_GET["id"])) {
  $id = $_GET["id"];
  if ($_GET["id"] == "") {
    echo "
    <script>
    alert('Oops ID kosong ');
    document.location.href='index.php?hal=vaksin';
    </script>
    ";
  }
}else{
  echo "
  <script>
  alert('Oops tidak ada ID yang dipilih ');
  document.location.href='index.php?hal=vaksin';
  </script>
  ";
}


$ambildata = mysqli_query($koneksi, "SELECT * FROM ref_vaksin WHERE id_vaksin='$id'");

$pecah = mysqli_fetch_assoc($ambildata);

if (isset($_POST["ubah"])) {
  $nama = $_POST["nama"];
  $usia = $_POST["usia"];

  $ubah = mysqli_query($koneksi, "UPDATE ref_vaksin SET nama_vaksin='$nama', usia_vaksin='$usia' WHERE id_vaksin='$id'");

  if ($ubah) {
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

<h4 class="font-weight-bold">Halaman Edit Vaksin</h4>
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Edit Data Vaksin</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <?php foreach ($ambildata as $value) : ?>
    <form method="post" action="" id="frmvaksin">
      <div class="card-body">
       <div class="form-group">
        <label for="nama">Nama Vaksin</label>
        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama Vaksin" value="<?= $value["nama_vaksin"]; ?>">
      </div>
      <div class="form-group">
        <label for="Usia">Usia Wajib</label>
        <input type="text" name="usia" id="usia" class="form-control" autocomplete="off" placeholder="Masukkan Usia Wajib" required value="<?= $value["usia_vaksin"]; ?>">
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-info" name="ubah">Simpan</button>
      <button type="reset" class="btn btn-danger">Reset</button>
      <a href="index.php?hal=vaksin" class="btn btn-success">Kembali</a>
    </div>
  </form>
<?php endforeach ?>
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