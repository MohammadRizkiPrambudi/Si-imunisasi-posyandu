<?php  

// ambil koneksi
include 'koneksi.php';

// mengambil data didatabase
$data = mysqli_query($koneksi, "SELECT * FROM ref_ibu");



?>

<h4 class="font-weight-bold">Halaman Ibu</h4>
<div class="card">
  <div class="card-header">
    <h2 class="card-title">Daftar Ibu</h2>
    <div class="float-right">
      <a href ="?hal=ibu&aksi=tambah" class="btn btn-info"><i class="fas fa-plus mr-2"></i>Tambah Data Ibu</a>
      <a href="lap_ibu.php" target="_blank"  class="btn btn-success" ><i class="fas fa-print mr-2"></i>Cetak Data Ibu</a>
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
            <th>Nama Ibu</th>
            <th>Alamat</th>
            <th>No Telp</th>
            <th>Foto</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php $no =1; ?>
          <?php foreach ($data as $result ): ?>
            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['nik_ibu']; ?></td>
              <td><?= $result['nama_ibu']; ?></td>
              <td><?= $result['alamat_ibu']; ?></td>
              <td><?= $result['no_telp_ibu']; ?></td>
              <td>
                <!-- <?php if ($result["foto_ibu"] == ""): ?>
                  <img src="https://via.placeholder.com/500x500.png?text=PAS+FOTO+IBU" style="width:80px;height:80px;">
                  <?php else : ?>
                    <img src="assets/dist/img/<?= $result["foto_ibu"]; ?>" width="80">
                    <?php endif ?> -->

                    <img src="assets/dist/img/<?= $result["foto_ibu"]; ?>" width="80">


                  </td>
                  <td>
                    <a href="?hal=ibu&aksi=edit&id=<?= $result['id_ibu'];?>" class="btn btn-primary btn-sm mb-1"  data-toggle="tooltip" data-placement="top" title="Edit Data"><i class="fas fa-edit"></i></a>  
                    <a href="hapus_ibu.php?id=<?= $result['id_ibu']; ?>" class="btn btn-danger btn-sm hapus"  data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="return confirm('Apakah data ini akan dihapus?')"><i class="fas fa-trash"></i></a>
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

