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
    document.location.href='index.php?hal=ibu';
    </script>
    ";
  }
}else{
  echo "
  <script>
  alert('Oops tidak ada ID yang dipilih ');
  document.location.href='index.php?hal=ibu';
  </script>
  ";
}


$ambildata = mysqli_query($koneksi, "SELECT * FROM ref_ibu WHERE id_ibu = '$id'");

$pecah = mysqli_fetch_assoc($ambildata);
$datafoto = $pecah["foto_ibu"];


if (isset($_POST["ubah"])) {
  $nama = $_POST["nama"];
  $nik = $_POST["nik"];
  $alamat = $_POST["alamat"];
  $nowa = $_POST["nowa"];
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
      document.location.href='index.php?hal=ibu&aksi=edit&id=$id';
      </script>
      ";
    }else{
      if (file_exists("assets/dist/img/$datafoto") != "avatar3.png") {
        @unlink("assets/dist/img/$datafoto");
      }
      move_uploaded_file($tmpfile, 'assets/dist/img/'.$namafile);
      $ubah = mysqli_query($koneksi, "UPDATE ref_ibu SET nama_ibu='$nama',nik_ibu='$nik', alamat_ibu='$alamat', no_telp_ibu='$nowa', foto_ibu='$namafile' WHERE id_ibu='$id'");
      if ($ubah) {
       echo "
       <script>
       alert('Data berhasil diubah');
       document.location.href='index.php?hal=ibu';
       </script>
       ";
     }else{
      echo "
      <script>
      alert('Data gagal diubah');
      document.location.href='index.php?hal=ibu';
      </script>
      ";
      
    }
  }
}else{
  $ubah = mysqli_query($koneksi, "UPDATE ref_ibu SET nama_ibu='$nama',nik_ibu='$nik', alamat_ibu='$alamat', no_telp_ibu='$nowa', foto_ibu='$fotolama' WHERE id_ibu='$id'" );
  if ($ubah) {
   echo "
   <script>
   alert('Data berhasil diubah');
   document.location.href='index.php?hal=ibu';
   </script>
   ";
 }else{
  echo "
  <script>
  alert('Data gagal diubah');
  document.location.href='index.php?hal=ibu';
  </script>
  ";
  
}
}


}



?>

<h4 class="font-weight-bold">Halaman Edit ibu</h4>
<div class="card card-danger">
  <div class="card-header">
    <h3 class="card-title">Edit Data ibu</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <?php foreach ($ambildata as $value): ?>
    <form method="post" action="" id="frmibu" enctype="multipart/form-data">
      <div class="card-body">
       <div class="form-group">
        <label for="nama">Nama ibu</label>
        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" placeholder="Masukkan Nama" value="<?= $value["nama_ibu"]; ?>" required>
      </div>
      <div class="form-group">
        <label for="nik">NIK ibu</label>
        <input type="text" name="nik" id="nik" class="form-control" autocomplete="off" placeholder="Masukkan NIK ibu" value="<?= $value["nik_ibu"]; ?>">
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control" autocomplete="off" placeholder="Masukkan Tempat Lahir Anak" value="<?= $value["alamat_ibu"]; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="nowa">No WA</label>
            <input type="text" name="nowa" id="nowa" class="form-control" autocomplete="off" placeholder="Masukkan No WA" value="<?= $value["no_telp_ibu"]; ?>">
          </div>
        </div>
      </div>
      <?php if ($value["foto_ibu"] == "") : ?>
        <img src="https://via.placeholder.com/500x500.png?text=PAS+FOTO+IBU" style="width:100px; height:100px;">
        <?php else : ?>
          <img src="assets/dist/img/<?= $value["foto_ibu"]; ?>" width="100px" style="display:block;" class="img-preview mb-3">
        <?php endif; ?>  
        <div class="input-group">
          <input type="file" class="form-control tampil" name="foto" onchange="previewImage()">
          <input type="hidden" name="fotolama" value="<?= $value["foto_ibu"]; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-folder"></span>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
        <button type="submit" class="btn btn-info" name="ubah">Simpan</button>
        <button type="reset" class="btn btn-danger">Reset</button>
        <a href="index.php?hal=ibu" class="btn btn-success">Kembali</a>
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
