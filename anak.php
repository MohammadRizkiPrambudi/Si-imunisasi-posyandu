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
$data = mysqli_query($koneksi, "SELECT * FROM ref_anak");

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

<h4 class="font-weight-bold">Halaman Anak</h4>
<div class="card">
  <div class="card-header">
    <h2 class="card-title">Daftar Anak</h2>
    <div class="float-right">
      <a href ="?hal=anak&aksi=tambah" class="btn btn-info"><i class="fas fa-plus mr-2"></i>Tambah Data Anak</a>
      <button class="btn btn-success" onclick="window.open('lap_anak.php','mywindow', 'width=900px, height=800px')"><i class="fas fa-print mr-2"></i>Cetak Data Anak</button>
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
            <th>TTL</th>
            <th>Usia</th>
            <th>Jenis Kelamin</th>
            <th>Nama Ibu</th>
            <th>Alamat</th>
            <th>No WA</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no =1; ?>
          <?php foreach ($data as $result ): ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['nik_anak']; ?></td>
              <td><?= $result['nama_anak']; ?></td>
              <td><?= $result["tempat_lahir_anak"]; ?>, <?= format_indo($result['tgl_lahir_anak']); ?></td>
              <?php  

              $tanggal_lahir = new DateTime($result['tgl_lahir_anak']);
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

              <td><?= $usia; ?></td>
              <td><?= $result['jk_anak']; ?></td>
              <td><?= $result["nama_ibu"]; ?></td>
              <td><?= $result["alamat_ibu"]; ?></td>
              <td><?= $result["no_telp_ibu"]; ?></td>
              <td>
                <a href="?hal=anak&aksi=edit&id=<?= $result['id_anak'];?>" class="btn btn-primary btn-sm mb-1"  data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fas fa-edit"></i></a>  
                <a href="hapus_anak.php?id=<?= $result['id_anak']; ?>" class="btn btn-danger btn-sm hapus"  data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="return confirm('Apakah data ini akan dihapus?')"><i class="fas fa-trash"></i></a>
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

