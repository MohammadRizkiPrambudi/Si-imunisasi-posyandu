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
$data = mysqli_query($koneksi, "SELECT * FROM ref_vaksin");




?>

<h4 class="font-weight-bold">Halaman Vaksin</h4>
<div class="card">
  <div class="card-header">
    <h2 class="card-title">Daftar Vaksin</h2>
    <div class="float-right">
      <a href ="?hal=vaksin&aksi=tambah" class="btn btn-info"><i class="fas fa-plus mr-2"></i>Tambah Data Vaksin</a>
      <button class="btn btn-success" onclick="window.open('lap_vaksin.php','mywindow', 'width=900px, height=800px')"><i class="fas fa-print mr-2"></i>Cetak Data Vaksin</button>
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
            <th>Nama Vaksin</th>
            <th>Usia Wajib</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no =1; ?>
          <?php foreach ($data as $result ): ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['nama_vaksin']; ?></td>
              <td><?= $result['usia_vaksin']; ?> Hari </td>
              <td>
                <a href="?hal=vaksin&aksi=edit&id=<?= $result['id_vaksin'];?>" class="btn btn-primary btn-sm mb-1"  data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fas fa-edit"></i></a>  
                <a href="hapus_vaksin.php?id=<?= $result['id_vaksin']; ?>" class="btn btn-danger btn-sm hapus"  data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="return confirm('Apakah data ini akan dihapus?')"><i class="fas fa-trash"></i></a>
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

