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

// mengambil data didatabase
$data = mysqli_query($koneksi, "SELECT * FROM ref_anak, ref_imunisasi, ref_vaksin, ref_petugas WHERE ref_anak.id_anak = ref_imunisasi.id_anak AND ref_vaksin.id_vaksin = ref_imunisasi.id_vaksin AND ref_petugas.id_petugas = ref_imunisasi.id_petugas");

function format_indo($date)
{
  $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

  $tahun = substr($date, 0, 4);               
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $result = $tgl . "-" . $BulanIndo[(int)$bulan-1]. "-". $tahun;
  return($result);
}





?>

<h4 class="font-weight-bold">Halaman Imunisasi</h4>
<div class="card">
  <div class="card-header">
    <h2 class="card-title">Daftar Anak Yang Sudah Imunisasi</h2>
    <div class="float-right">
      <a href ="?hal=pelaksanaan&aksi=grafik_imunisasi" class="btn btn-danger"><i class="fas fa-chart-bar mr-2"></i>Grafik Imunisasi</a>
      <button class="btn btn-success" data-target="#print" data-toggle="modal"><i class="fas fa-print mr-2"></i>Cetak Data Imunisasi</button>
      <!-- <div class="btn-group">
        <button type="button" class="btn btn-success"><i class="fas fa-print mr-2"></i>Cetak Data Berdasarkan</button>
        <button type="button" class="btn btn-danger dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" role="menu">
          <button class="dropdown-item"></button>
        </div>
      </div> -->
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
            <th>NIK</th>
            <th>Nama Anak</th>
            <th>Tanggal Imunisasi</th>
            <th>Nama Vaksin</th>
            <th>Petugas</th>
          </tr>
        </thead>
        <tbody>
          <?php $no =1; ?>
          <?php foreach ($data as $result ): ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['nik_anak']; ?></td>
              <td><?= $result['nama_anak']; ?></td>
              <td><?= format_indo($result['tgl_imunisasi']); ?></td>
              <td><?= $result['nama_vaksin']; ?></td>
              <td><?= $result['nama_petugas']; ?></td>
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
        <h5 class="modal-title" id="exampleModalLabel">Cetak Data Imunisasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="lap_imunisasipertanggal.php" target="_blank">
<!--           <div class="form-group">
            <label for="nama">Nama Anak</label>
            <input type="text" name="nama" id="nama" class="form-control">
          </div> -->
          <div class="form-group">
            <label for="tglawal">Tanggal Awal</label>
            <input type="date" name="tglawal" id="tglawal" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="tglakhir">Tanggal Akhir</label>
            <input type="date" name="tglakhir" id="tglakhir" class="form-control" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-sm" name="print"><i class="fas fa-print mr-2"></i>Cetak Per Periode</button>
            <a class="btn btn-success btn-sm" onclick="window.open('lap_imunisasi.php','mywindow', 'width=900px, height=800px')"><i class="fas fa-print mr-2"></i>Cetak Semua</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>