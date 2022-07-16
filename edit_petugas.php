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
    document.location.href='index.php?hal=petugas';
    </script>
    ";
  }
}else{
  echo "
  <script>
  alert('Oops tidak ada ID yang dipilih ');
  document.location.href='index.php?hal=petugas';
  </script>
  ";
}

$ambildata = mysqli_query($koneksi, "SELECT * FROM ref_petugas WHERE id_petugas='$id'");
$pecah = mysqli_fetch_assoc($ambildata);
$datafoto = $pecah["foto_petugas"];


if (isset($_POST["ubah"])) {
  $nama = $_POST["nama"];
  $jabatan = $_POST["jabatan"];
  $jk = $_POST["jk"];
  $tempat = $_POST["tempat"];
  $tanggal = $_POST["tanggal"];
  $alamat = $_POST["alamat"];
  $nowa = $_POST["nowa"];
  $status = $_POST["status"];
  $fotolama = $_POST["fotolama"];
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
      if (file_exists("assets/dist/img/$datafoto")) {
        @unlink("assets/dist/img/$datafoto");
      }
      move_uploaded_file($tmpfile, 'assets/dist/img/'.$namafile);
      $ubah = mysqli_query($koneksi, "UPDATE ref_petugas SET nama_petugas='$nama', jabatan_petugas='$jabatan', jk_petugas='$jk', tempat_lahir_petugas='$tempat',tgl_lahir_petugas='$tanggal', alamat_petugas='$alamat', no_telp_petugas='$nowa',foto_petugas='$namafile', status_petugas='$status', level= '$level' WHERE id_petugas='$id'");
      if ($ubah) {
       echo "
       <script>
       alert('Data berhasil diubah');
       document.location.href='index.php?hal=petugas';
       </script>
       ";
     }else{
      echo "
      <script>
      alert('Data gagal diubah');
      document.location.href='index.php?hal=petugas';
      </script>
      ";
      
    }
  }
}else{
  $ubah = mysqli_query($koneksi, "UPDATE ref_petugas SET nama_petugas='$nama', jabatan_petugas='$jabatan', jk_petugas='$jk', tempat_lahir_petugas='$tempat',tgl_lahir_petugas='$tanggal', alamat_petugas='$alamat', no_telp_petugas='$nowa',foto_petugas='$fotolama', status_petugas='$status', level= '$level' WHERE id_petugas='$id'");
  if ($ubah) {
   echo "
   <script>
   alert('Data berhasil diubah');
   document.location.href='index.php?hal=petugas';
   </script>
   ";
 }else{
  echo "
  <script>
  alert('Data gagal diubah');
  document.location.href='index.php?hal=petugas';
  </script>
  ";
  
}
}


}



?>

<h4 class="font-weight-bold">Halaman Edit Petugas</h4>
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Edit Data Petugas</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <?php foreach ($ambildata as $value) : ?>
    <form method="post" action="" id="frmpetugas" enctype="multipart/form-data">
      <div class="card-body">
       <div class="form-group">
        <label for="nama">Nama Petugas</label>
        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama" value="<?= $value["nama_petugas"]; ?>">
      </div>
      <div class="form-group">
        <label for="jabatan">Jabatan Petugas</label>
        <input type="text" name="jabatan" id="jabatan" class="form-control" autocomplete="off" placeholder="Masukkan Jabatan" value="<?= $value["jabatan_petugas"]; ?>">
      </div>
      <div class="form-group">
        <label for="jk">Jenis Kelamin</label>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="jk" value="L" <?php if ($value["jk_petugas"] == "L") { echo "checked";} ?>>
          <label class="form-check-label">Laki-Laki</label>
          <input class="form-check-input ml-2" type="checkbox" name="jk" value="P" <?php if ($value["jk_petugas"] == "P") { echo "checked";} ?>>
          <label class="form-check-label ml-4">Perempuan</label>
        </div>                
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="tempat">Tempat Lahir</label>
            <input type="text" name="tempat" id="tempat" class="form-control" autocomplete="off" placeholder="Masukkan Tempat Lahir" value="<?= $value["tempat_lahir_petugas"]; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="tanggal">Tanggal Lahir</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" autocomplete="off" placeholder="Masukkan Tanggal Lahir" value="<?= $value["tgl_lahir_petugas"]; ?>">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" placeholder="Masukkan Alamat" value="<?= $value["alamat_petugas"]; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="nowa">No Wa</label>
            <input type="text" name="nowa" id="nowa" class="form-control" autocomplete="off" placeholder="Masukkan No WA" value="<?= $value["no_telp_petugas"]; ?>">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="nama">Status Aktif</label>
        <select class="form-control" id="status" name="status" style="width: 100%">
          <option>--Silahkan Pilih--</option>
          <option <?php if ($value["status_petugas"]=="Aktif") { echo "selected";} ?>>Aktif</option>
          <option <?php if ($value["status_petugas"]=="Tidak") { echo "selected";} ?>>Tidak</option>
        </select>
      </div>
      <?php if ($value["foto_petugas"] == "-"): ?>
        <img src="https://via.placeholder.com/500x500.png?text=PAS+FOTO+PETUGAS" style="width:80px;height:80px;">
        <?php else : ?>
          <img src="assets/dist/img/<?= $value["foto_petugas"]; ?>" width="100px" style="display:block;" class="img-preview mb-3">
        <?php endif ?>
        <div class="input-group">
          <input type="file" class="form-control tampil" name="foto" onchange="previewImage()">
          <input type="hidden" name="fotolama" value="<?= $value["foto_petugas"]; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-folder"></span>
            </div>
          </div>
        </div>
        <div class="form-group mt-2">
          <label for="nama">Level</label>
          <select class="form-control" id="level" name="level" style="width: 100%">
            <option>--Silahkan Pilih--</option>
            <option <?php if ($value["level"]=="admin") { echo "selected";} ?> value="admin">Admin</option>
            <option <?php if ($value["level"]=="kader") { echo "selected";} ?> value="kader">Kader</option>
          </select>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-info" name="ubah">Simpan</button>
        <button type="reset" class="btn btn-danger">Reset</button>
        <a href="index.php?hal=petugas" class="btn btn-success">Kembali</a>
      </div>
    </form>
  <?php endforeach; ?>
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
