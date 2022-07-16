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


function format_indo($date) {
  $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

  $tahun = substr($date, 0, 4);               
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $result = $tgl . "-" . $BulanIndo[(int)$bulan-1]. "-". $tahun;
  return($result);
}


// echo date("d M Y", time()+60*60*24*60);





?>

<h4 class="font-weight-bold">Halaman Pemberitahuan Jadwal Imunisasi</h4>

<div class="card mt-2">
  <div class="card-header">
    <h2 class="card-title">Pemberitahuan Jadwal Imunisasi</h2>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="table-responsive">
      <!-- style="white-space: nowrap;" -->
      <table id="example" class="table table-bordered" >
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Anak</th>
            <th>Nama Vaksin</th>
            <th>Tanggal Pelaksanaan</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php $no =1; ?>
          <?php 
          $ref_vaksin = mysqli_query($koneksi, "SELECT * FROM ref_vaksin, ref_anak");
          $tanggal_vaksin = "";
          $tgl_konfirmasi = "";
          ?>

          <?php foreach ($ref_vaksin as $value) : ?> 

            <?php 

            $tanggal= new DateTime($value["tgl_lahir_anak"]);
            

            $usia_vaksin = $value["usia_vaksin"];

            $tanggal_pervaksin = date_modify($tanggal, "+$usia_vaksin days");
            $tanggal_vaksin = $tanggal_pervaksin ->format('Y-m-d');

            $tgl_vaksin = $tanggal_vaksin;
            $tgl_vaksinindo = format_indo($tgl_vaksin);

            $tanggal_hariini = date('Y-m-d');

            $tgl_konfirmasi_sementara = date_modify($tanggal, "-1 days");
            $tgl_konfirmasi = $tgl_konfirmasi_sementara->format('Y-m-d');

            ?>

            <?php if ($tanggal_hariini == $tgl_konfirmasi) : ?>

              <tr>

                <td><?= $no++ ?></td>
                <td><?= $value["nama_anak"]; ?></td>
                <td><?= $value['nama_vaksin']; ?></td>
                <td><?= $tgl_vaksinindo; ?></td>
                <td>
                  <?php 
                  $id_vaksin = $value["id_vaksin"];
                  $id_anak = $value["id_anak"];

                  $data_konfirmasi = mysqli_query($koneksi, "SELECT * FROM ref_anak WHERE id_anak = '$id_anak'");
                  $pecah_konfirmasi = mysqli_fetch_assoc($data_konfirmasi);

                  
                  $nohp = $pecah_konfirmasi["no_telp_ibu"];
                  $namaibu = $pecah_konfirmasi["nama_ibu"];
                  $namaanak = $pecah_konfirmasi["nama_anak"];

                  $nama_vaksin = $value["nama_vaksin"];


                  ?>

                  <!-- <a href="https://api.whatsapp.com/send?phone=<?= $nohp; ?>&text=Pemberitahuan, Sdri <?= $namaibu; ?> bahwa anaknya yang bernama <?= $namaanak; ?> besok saatnya imunisasi <?= $nama_vaksin; ?> pada tanggal <?= $tgl_vaksinindo; ?>, silahkan datang pada tanggal tersebut. Terima kasih." target="_blank"><p><span class="badge badge-success"><i class="fab fa-whatsapp mr-1"></i>Pemberitahuan</span></p></a> -->
                  <button class="btn btn-success btn-sm" onclick="window.open('https://api.whatsapp.com/send?phone=<?= $nohp; ?>&text=Pemberitahuan, Sdri <?= $namaibu; ?> bahwa anaknya yang bernama <?= $namaanak; ?> besok saatnya imunisasi <?= $nama_vaksin; ?> pada tanggal <?= $tgl_vaksinindo; ?>, silahkan datang pada tanggal tersebut. Terima kasih.','mywindow', 'width=900px, height=800px')" ><i class="fab fa-whatsapp mr-1"></i>Pemberitahuan</button>
                </td>

              </tr>

            <?php endif; ?>
            
          <?php endforeach ?>

        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
<!-- /.card -->

