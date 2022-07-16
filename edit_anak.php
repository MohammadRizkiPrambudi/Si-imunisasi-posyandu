<?php  

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

date_default_timezone_set('Asia/Jakarta');

include 'koneksi.php';

if (isset($_GET["id"])) {
  $id = $_GET["id"];
  if ($_GET["id"] == "") {
    echo "
    <script>
    alert('Oops ID kosong ');
    document.location.href='index.php?hal=anak';
    </script>
    ";
  }
}else{
  echo "
  <script>
  alert('Oops tidak ada ID yang dipilih ');
  document.location.href='index.php?hal=anak';
  </script>
  ";
}


$ambildata = mysqli_query($koneksi, "SELECT * FROM ref_anak WHERE id_anak = '$id'");

if (isset($_POST["ubah"])) {
  $nama = $_POST["nama"];
  $nik = $_POST["nik"];
  $tempat = $_POST["tempat"];
  $tanggal = $_POST["tanggal"];
  $jk = $_POST["jk"];
  $nik_ibu = $_POST["nik_ibu"];
  $nama_ibu = $_POST["nama_ibu"];
  $alamat = $_POST["alamat"];
  $nowa = $_POST["nowa"];



  $update = mysqli_query($koneksi, "UPDATE ref_anak SET nama_anak = '$nama', nik_anak='$nik',tempat_lahir_anak='$tempat', tgl_lahir_anak='$tanggal', jk_anak='$jk', nik_ibu='$nik_ibu', nama_ibu = '$nama_ibu', alamat_ibu='$alamat', no_telp_ibu = '$nowa' WHERE id_anak ='$id'");


  if ($update) {
    echo "
    <script>
    alert('Data berhasil diubah');
    document.location.href='index.php?hal=anak';
    </script>
    ";
  }else{
    echo "
    <script>
    alert('Data gagal diubah');
    document.location.href='index.php?hal=anak';
    </script>
    ";
  }


}



?>

<h4 class="font-weight-bold">Halaman Edit Anak</h4>
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Edit Data Anak</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <?php foreach ($ambildata as $value): ?>
    <form method="post" action="" id="frmanak">
      <div class="card-body">
       <div class="form-group">
        <label for="nama">Nama Anak</label>
        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama" value="<?= $value["nama_anak"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="nik">NIK Anak</label>
        <input type="text" name="nik" id="nik" class="form-control" autocomplete="off" placeholder="Masukkan NIK Anak" value="<?= $value["nik_anak"]; ?>">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="tempat">Tempat Lahir</label>
            <input type="text" name="tempat" id="tempat" class="form-control" autocomplete="off" placeholder="Masukkan Tempat Lahir Anak" value="<?= $value["tempat_lahir_anak"]; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="tanggal">Tanggal Lahir</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" autocomplete="off" placeholder="Masukkan Tanggal Lahir Anak" value="<?= $value["tgl_lahir_anak"]; ?>">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="jk">Jenis Kelamin</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="jk" value="L" <?php if ($value['jk_anak'] == 'L'){ echo "checked";} ?>>
          <label class="form-check-label">Laki-Laki</label>
          <input class="form-check-input ml-2" type="checkbox" name="jk" value="P" <?php if ($value['jk_anak'] == 'P'){ echo "checked";} ?>>
          <label class="form-check-label ml-4">Perempuan</label>
        </div>                
      </div>
      <div class="form-group">
        <label for="nik_ibu">NIK Ibu</label>
        <input type="text" name="nik_ibu" id="nik_ibu" class="form-control" autocomplete="off" placeholder="Masukkan NIK Ibu" value="<?= $value["nik_ibu"]; ?>">
      </div>
      <div class="form-group">
        <label for="nama_ibu">Nama Ibu</label>
        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" autocomplete="off" placeholder="Masukkan Nama" value="<?= $value["nama_ibu"]; ?>">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" autocomplete="off" placeholder="Masukkan Alamat Ibu"><?= $value["alamat_ibu"]; ?></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="nowa">No WA</label>
            <input type="text" name="nowa" id="nowa" class="form-control" autocomplete="off" placeholder="Masukkan No WA Ibu" value="<?= $value["no_telp_ibu"]; ?>">
            <small>*Pastikan No WA Aktif dan nomer dimulai dari 62</small>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-info" name="ubah">Simpan</button>
        <button type="reset" class="btn btn-danger">Reset</button>
        <a href="index.php?hal=anak" class="btn btn-success">Kembali</a>
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
</script> -->
