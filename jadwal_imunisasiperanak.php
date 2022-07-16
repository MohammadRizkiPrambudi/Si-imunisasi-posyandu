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

$id = $_GET["id"];

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


// echo date("d M Y", time()+60*60*24*60);



?>

<h4 class="font-weight-bold">Halaman Jadwal Imunisasi</h4>
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
    <h2 class="card-title">Jadwal Imunisasi</h2>
    <div class="float-right">
      <button class="btn btn-success" onclick="window.open('lap_jadwalimunisasi.php?id=<?= $pecah["id_anak"]; ?>','mywindow', 'width=900px, height=800px')"><i class="fas fa-print mr-2"></i>Cetak Jadwal Imunisasi</button>
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
            <th>Tanggal Pelaksanaan</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php $no =1; ?>
          <?php 
          $ref_vaksin = mysqli_query($koneksi, "SELECT * FROM ref_vaksin");              

          ?>
          <?php foreach ($ref_vaksin as $result) : ?>

            <tr>
              <td><?= $no; ?></td>
              <td><?= $result['nama_vaksin']; ?></td>
              <td>
                <?php 

                $tanggal_lahir = new DateTime($pecah['tgl_lahir_anak']);
                $usia_vaksin = $result["usia_vaksin"];
                $tanggal_pervaksin = date_modify($tanggal_lahir, "+$usia_vaksin days");
                $tanggal_vaksin = $tanggal_pervaksin ->format('Y-m-d');
              // echo $tanggal_vaksin;

                $jadwal_tanggal = $tanggal_vaksin;

                echo format_indo($jadwal_tanggal);

                ?>
              </td>
              <td class="text-center"> 
                <?php  
              // if ($tanggal_vaksin <= $tanggal_datang)
                $id_vaksin = $result["id_vaksin"];

                $data_imunisasi = mysqli_query($koneksi, "SELECT * FROM ref_imunisasi WHERE id_anak='$id' && id_vaksin='$id_vaksin'");

                $pecah_imunisasi = mysqli_fetch_assoc($data_imunisasi);

                $tanggal_datang = $pecah_imunisasi["tgl_imunisasi"];
                $tanggal_sekarang = date('Y-m-d');

                ?>
                <?php if ($tanggal_datang >= $tanggal_vaksin) : ?>
                  <p><span class="badge badge-success"><i class="fas fa-check mr-1"></i> Sudah Imunisasi</span></p>
                  <?php elseif($tanggal_vaksin == $tanggal_sekarang) : ?>
                    <a href="?hal=jadwal&aksi=imunisasi&id_anak=<?= $pecah["id_anak"]; ?>&id_vaksin=<?= $result["id_vaksin"]; ?>"><p><span class="badge badge-warning"><i class="fas fa-exclamation mr-1"></i> Sudah Saatnya Imunisasi</span></p></a>
                    <?php elseif ($tanggal_sekarang > $tanggal_vaksin) : ?>
                      <a href="?hal=jadwal&aksi=imunisasi&id_anak=<?= $pecah["id_anak"]; ?>&id_vaksin=<?= $result["id_vaksin"]; ?>"><p><span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Belum Imunisasi</span></p></a>
                      <?php else : ?>
                        <p><span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Belum Imunisasi</span></p>
                      <?php endif; ?>
                      <?php  
                      
                      $tgl_vaksin = new DateTime($tanggal_vaksin);

                      $tgl_konfirmasi_sementara = date_modify($tgl_vaksin, "-1 days");

                      $tgl_konfirmasi = $tgl_konfirmasi_sementara->format('Y-m-d');

                      $data_konfirmasi = mysqli_query($koneksi, "SELECT * FROM ref_anak WHERE id_anak = '$id'");
                      $pecah_konfirmasi = mysqli_fetch_assoc($data_konfirmasi);


                      $nohp = $pecah_konfirmasi["no_telp_ibu"];
                      $namaibu = $pecah_konfirmasi["nama_ibu"];
                      $namaanak = $pecah_konfirmasi["nama_anak"];

                      $nama_vaksin = $result["nama_vaksin"];

                      $tanggal_hariH =  format_indo($tanggal_vaksin);



                      ?>

                      <?php if ($tgl_konfirmasi == $tanggal_sekarang) : ?> 


                        <a href="https://api.whatsapp.com/send?phone=<?= $nohp; ?>&text=Pemberitahuan, Sdri <?= $namaibu; ?> bahwa anaknya yang bernama <?= $namaanak; ?> besok saatnya imunisasi <?= $nama_vaksin; ?> pada tanggal <?= $tanggal_hariH; ?>, silahkan datang pada tanggal tersebut. Terima kasih." target="_blank"><p><span class="badge badge-success"><i class="fab fa-whatsapp mr-1"></i>Pemberitahuan</span></p></a>

                      <?php endif; ?>
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

