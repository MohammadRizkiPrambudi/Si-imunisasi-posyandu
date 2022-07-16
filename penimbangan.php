<?php  

// ambil koneksi
include 'koneksi.php';

// mengambil data didatabase
$data = mysqli_query($koneksi, "SELECT * FROM ref_anak");



?>

<h4 class="font-weight-bold">Halaman penimbangan</h4>
<div class="card">
  <div class="card-header">
    <h2 class="card-title">Daftar Nama Anak</h2>
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
              <td>
                <a href="?hal=penimbangan&aksi=penimbanganperanak&id=<?= $result['id_anak'];?>" class="btn btn-primary btn-sm mb-1"  data-toggle="tooltip" data-placement="top" title="Lihat Data penimbangan <?= $result["nama_anak"]; ?>"><i class="fas fa-eye"></i></a>  
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

