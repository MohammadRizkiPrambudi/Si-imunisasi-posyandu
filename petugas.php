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
$data = mysqli_query($koneksi, "SELECT * FROM ref_petugas");

?>

<h4 class="font-weight-bold">Halaman Petugas</h4>
<div class="card">
  <div class="card-header">
    <h2 class="card-title">Daftar Petugas</h2>
    <div class="float-right">
      <a href ="?hal=petugas&aksi=tambah" class="btn btn-info"><i class="fas fa-plus mr-2"></i>Tambah Data Petugas</a>
      <div class="btn-group">
        <button type="button" class="btn btn-success"><i class="fas fa-print mr-2"></i>Cetak Data</button>
        <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
          <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" role="menu">
          <button class="dropdown-item" onclick="window.open('lap_petugas.php','mywindow', 'width=900px, height=800px')"><i class="far fa-file-pdf mr-2"></i>PDF</button>
          <a class="dropdown-item" href="lap_petugasexcel.php" target="_blank"><i class="far fa-file-excel mr-2"></i>Excel</a>
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
            <th>Nama Petugas</th>
            <th>Jabatan</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>No Telp</th>
            <th>Foto Petugas</th>
            <th>Status Aktif</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no =1; ?>
          <?php foreach ($data as $result ): ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['nama_petugas']; ?></td>
              <td><?= $result['jabatan_petugas']; ?></td>
              <td><?= $result['alamat_petugas']; ?></td>
              <td><?= $result['jk_petugas']; ?></td>
              <td><?= $result['no_telp_petugas']; ?></td>
              <td>
                <?php if ($result["foto_petugas"] == "-"): ?>
                  <p>-</p>
                  <?php else : ?>
                    <img src="assets/dist/img/<?= $result['foto_petugas']; ?>" width="80">
                  <?php endif ?>

                </td>
                <td><?= $result["status_petugas"]; ?></td>
                <td>
                  <a href="?hal=petugas&aksi=edit&id=<?= $result['id_petugas'];?>" class="btn btn-primary btn-sm mb-1"  data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fas fa-edit"></i></a>  
                  <a href="hapus_petugas.php?id=<?= $result['id_petugas']; ?>" class="btn btn-danger btn-sm hapus"  data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="return confirm('Apakah data ini akan dihapus?')"><i class="fas fa-trash"></i></a>
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

