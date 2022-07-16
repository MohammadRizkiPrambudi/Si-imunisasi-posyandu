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
  $tempat = $_POST["tempat"];
  $tanggal = $_POST["tanggal"];
  $jk = $_POST["jk"];
  $nik_ibu = $_POST["nik_ibu"];
  $nama_ibu = $_POST["nama_ibu"];
  $alamat = $_POST["alamat"];
  $nowa = $_POST["nowa"];


  $ceknik    = mysqli_num_rows (mysqli_query($koneksi, "SELECT  * FROM ref_anak WHERE nik_anak='$nik' OR nik_ibu ='$nik_ibu'"));


  if ($ceknik > 0) {
    echo "
    <script>
    alert('NIK Anak / Ibu sudah terdaftar ');
    document.location.href='index.php?hal=anak&aksi=tambah';
    </script>
    ";
  }else{

    $query = "INSERT INTO ref_anak VALUES('','$nama','$nik','$tempat','$tanggal', '$jk', '$nik_ibu', '$nama_ibu', '$alamat', '$nowa')";

    $simpan = mysqli_query($koneksi, $query);

    if ($simpan) {
      echo "
      <script>
      alert('Data berhasil disimpan');
      document.location.href='index.php?hal=anak';
      </script>
      ";
    }else{
      echo "
      <script>
      alert('Data gagal disimpan');
      document.location.href='index.php?hal=anak';
      </script>
      ";
    }
  }

}



?>

<h4 class="font-weight-bold">Halaman Tambah Anak</h4>
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Tambah Data Anak</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form method="post" action="" id="frmanak">
    <div class="card-body">
      <div class="form-group">
        <label for="nik">NIK Anak</label>
        <input type="text" name="nik" id="nik" class="form-control" autocomplete="off" placeholder="Masukkan NIK">
      </div>
      <div class="form-group">
        <label for="nama">Nama Anak</label>
        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="tempat">Tempat Lahir</label>
            <input type="text" name="tempat" id="tempat" class="form-control" autocomplete="off" placeholder="Masukkan Tempat Lahir Anak">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="tanggal">Tanggal Lahir</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" autocomplete="off" placeholder="Masukkan Tanggal Lahir Anak">
          </div>
        </div>
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
      <div class="form-group">
        <label for="nik_ibu">NIK Ibu</label>
        <input type="text" name="nik_ibu" id="nik_ibu" class="form-control" autocomplete="off" placeholder="Masukkan NIK Ibu">
      </div>
      <div class="form-group">
        <label for="nama_ibu">Nama Ibu</label>
        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" autocomplete="off" placeholder="Masukkan Nama">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" autocomplete="off" placeholder="Masukkan Alamat Ibu"></textarea>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="nowa">No WA</label>
            <input type="text" name="nowa" id="nowa" class="form-control" autocomplete="off" placeholder="Masukkan No WA Ibu">
            <small>*Pastikan No WA Aktif dan nomer dimulai dari 62</small>
          </div>
        </div>
      </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-info" name="tambah">Simpan</button>
      <button type="reset" class="btn btn-danger">Reset</button>
      <a href="index.php?hal=anak" class="btn btn-success">Kembali</a>
    </div>
  </form>
</div>
<!-- /.card -->
<!-- jquery-validation -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="assets/plugins/jquery-validation/additional-methods.min.js"></script>

<!-- <script type="text/javascript">
  $('#frmanak').validate({
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