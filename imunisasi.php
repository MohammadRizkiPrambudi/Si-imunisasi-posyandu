<?php  

include 'koneksi.php';

$id_anak = $_GET["id_anak"];
$id_vaksin = $_GET["id_vaksin"];

// mengambil data anak didatabase
$data_anak = mysqli_query($koneksi, "SELECT * FROM ref_anak WHERE id_anak='$id_anak'");
$pecah = mysqli_fetch_assoc($data_anak);


// mengambil data anak didatabase
$data_vaksin = mysqli_query($koneksi, "SELECT * FROM ref_vaksin WHERE id_vaksin='$id_vaksin'");
$pecah_vaksin = mysqli_fetch_assoc($data_vaksin);


function format_indo($date) {
  $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

  $tahun = substr($date, 0, 4);               
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $result = $tgl . "-" . $BulanIndo[(int)$bulan-1]. "-". $tahun;
  return($result);
}

// tanggal lahir
$tanggal_lahir = new DateTime($pecah['tgl_lahir_anak']);
// tanggal hari ini
$sekarang = new DateTime('today');


if ($tanggal_lahir > $sekarang) { 
  $thn = "0";
  $bln = "0";
  $tgl = "0";
}

$thn = date_diff($tanggal_lahir, $sekarang)->y;
$bln = date_diff($tanggal_lahir, $sekarang)->m;
$tgl =  date_diff($tanggal_lahir, $sekarang)->d;
$usia =  $thn." tahun ".$bln." bulan ".$tgl." hari";



if (isset($_POST["tambah"])) {

  $tanggal = $_POST["tanggal"];
  $id_vaksin = $_POST["id_vaksin"];
  $id_anak = $_POST["id_anak"];
  $id_petugas = $_POST["id_petugas"];


  $simpan = "INSERT INTO ref_imunisasi VALUES('','$tanggal','$id_vaksin','$id_anak','$id_petugas')";

  mysqli_query($koneksi, $simpan);

  if (mysqli_affected_rows($koneksi) > 0) {
    echo "
    <script>
    alert('Data berhasil disimpan');
    document.location.href='index.php?hal=jadwal&aksi=jadwalperanak&id=$id_anak';
    </script>
    ";
  }else{
    echo "
    <script>
    alert('Data gagal disimpan');
    document.location.href='index.php?hal=jadwal&aksi=jadwalperanak&id=$id_anak';
    </script>
    ";
  }


}



?>

<h4 class="font-weight-bold">Halaman Imunisasi</h4>

<table style="font-size: 17px;">
  <tr>
    <td>Nama</td>
    <td>:</td>
    <td><?= $pecah["nama_anak"]; ?></td>
  </tr>
  <tr>
    <td>Tanggal Lahir</td>
    <td>:</td>
    <td><?= format_indo($pecah["tgl_lahir_anak"]); ?></td>
  </tr>
  <tr>
    <td>Usia</td>
    <td>:</td>
    <td><?= $usia; ?></td>
  </tr>
</table>

<div class="card card-danger mt-2">
  <div class="card-header">
    <h3 class="card-title">Imunisasi Anak</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form method="post" action="" id="frmanak">
    <div class="card-body">
      <input type="hidden" name="id_anak" value="<?= $pecah["id_anak"]; ?>">
      <div class="form-group">
        <label for="tanggal">Tanggal Imunisasi</label>
        <input type="date" name="tanggal" id="tanggal" class="form-control" autocomplete="off" placeholder="Masukkan Tanggal Imunisasi">
      </div>
      <div class="form-group">

        <label for="vaksin">Nama Vaksin Imunisasi</label>
        <input type="hidden" name="id_vaksin" value="<?= $pecah_vaksin["id_vaksin"]; ?>">
        <input type="text" name="vaksin" id="vaksin" class="form-control" 
        autocomplete="off" placeholder="Nama Vaksin" readonly value="<?= $pecah_vaksin["nama_vaksin"]; ?>">
      </div>

      <div class="form-group">
        <label for="petugas">Nama petugas</label>
        <select class="form-control" id="id_petugas" name="id_petugas" style="width: 100%">
          <?php $data_petugas = mysqli_query($koneksi, "SELECT * FROM ref_petugas WHERE status_petugas='Aktif'"); ?>
          <?php foreach($data_petugas as $nama) : ?>
            <option value="<?= $nama['id_petugas']; ?>"><?= $nama["nama_petugas"]; ?></option>
          <?php endforeach; ?>
          
        </select>
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