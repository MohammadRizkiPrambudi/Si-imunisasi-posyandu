<?php  

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

// ambil koneksi
include 'koneksi.php';

if (isset($_GET["id"])) {
  $id = $_GET["id"];
  if ($_GET["id"] == "") {
    echo "
    <script>
    alert('Oops ID kosong ');
    document.location.href='index.php?hal=penimbangan';
    </script>
    ";
  }
}else{
  echo "
  <script>
  alert('Oops tidak ada ID yang dipilih ');
  document.location.href='index.php?hal=penimbangan';
  </script>
  ";
}

// mengambil data didatabase
$data = mysqli_query($koneksi, "SELECT * FROM ref_anak WHERE id_anak='$id'");
$pecah = mysqli_fetch_assoc($data);



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
$sekarang = new DateTime('today');

// tanggal hari ini
if ($tanggal_lahir > $sekarang) { 
  $thn = "0";
  $bln = "0";
  $tgl = "0";
}

$thn = date_diff($tanggal_lahir, $sekarang)->y;
$bln = date_diff($tanggal_lahir, $sekarang)->m;
$tgl =  date_diff($tanggal_lahir, $sekarang)->d;
$usia =  $thn." tahun ".$bln." bulan ".$tgl." hari";



?>

<h4 class="font-weight-bold">Halaman Penimbangan</h4>
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

<div class="card mt-2">
  <div class="card-header">
    <h2 class="card-title">Riwayat Penimbangan</h2>
    <div class="float-right">
      <a href ="?hal=penimbangan&aksi=tambah&id=<?= $pecah["id_anak"]; ?>" class="btn btn-info"><i class="fas fa-plus mr-2"></i>Tambah Data Penimbangan</a>
      <button class="btn btn-success" data-target="#print" data-toggle="modal"><i class="fas fa-print mr-2"></i>Cetak Data Penimbangan</button>
      <div class="btn-group">
        <button type="button" class="btn btn-danger"><i class="fas fa-chart-line mr-2"></i>Grafik Perkembangan Anak</button>
        <button type="button" class="btn btn-danger dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" role="menu">
          <a class="dropdown-item" href="?hal=penimbangan&aksi=grafik_bbperanak&id=<?= $pecah["id_anak"]; ?>">Berat Badan</a>
          <a class="dropdown-item" href="?hal=penimbangan&aksi=grafik_tbperanak&id=<?= $pecah["id_anak"];?>">Tinggi Badan</a>
          <a class="dropdown-item" href="?hal=penimbangan&aksi=grafik_lingkarkepalaperanak&id=<?= $pecah["id_anak"];?>">Lingkar Kepala</a>
        </div>
      </div>
    </div>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="table-responsive">
      <!-- style="white-space: nowrap;" -->
      <table id="example" class="table table-bordered" >
        <thead>
          <tr>
            <th>No</th>
            <th>Tanggal Penimbangan</th>
            <th>Petugas</th>
            <th>Berat Badan (KG)</th>
            <th>Tinggi Badan (CM)</th>
            <th>Lingkar Kepala (CM)</th>
            <th>Perikaku</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no =1; ?>
          <?php  

          $penimbanganperanak = mysqli_query($koneksi, "SELECT * FROM ref_penimbangan, ref_petugas WHERE ref_petugas.id_petugas = ref_penimbangan.id_petugas AND id_anak='$id'");

          ?>
          <?php foreach ($penimbanganperanak as $result ): ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= format_indo($result['tgl_penimbangan']); ?></td>
              <td><?= $result['nama_petugas']; ?></td>
              <td><?= $result['bb_penimbangan']; ?> KG</td>
              <td><?= $result['tb_penimbangan']; ?> CM</td>
              <td><?= $result['lingkar_kepala']; ?> CM</td>
              <td><?= $result["perilaku"]; ?></td>
              <td>
                <a href="?hal=penimbangan&aksi=edit&id_penimbangan=<?= $result['id_penimbangan'];?>&id_anak=<?= $result["id_anak"]; ?>" class="btn btn-primary btn-sm mb-1"  data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fas fa-edit"></i></a>  
              </td>
            </tr>
            <?php $no++; ?>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
<!-- /.card -->
<!-- modal print-->
<div class="modal fade" id="print" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cetak Data Penimbangan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="lap_penimbanganpertanggal.php" target="_blank">
          <div class="form-group">
            <input type="hidden" name="id_anak" value="<?= $pecah["id_anak"]; ?>">
            <label for="tglawal">Tanggal Awal</label>
            <input type="date" name="tglawal" id="tglawal" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="tglakhir">Tanggal Akhir</label>
            <input type="date" name="tglakhir" id="tglakhir" class="form-control" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-sm" name="print"><i class="fas fa-print mr-2"></i>Cetak Per Periode</button>
            <button class="btn btn-success btn-sm" onclick="window.open('lap_penimbangan.php?id=<?= $pecah["id_anak"]; ?>','mywindow', 'width=900px, height=800px')"><i class="fas fa-print mr-2"></i>Cetak Semua</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

