<?php  

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

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

  $tanggal = date('Y-m-d');
  $id_anak = $_POST["id_anak"];
  $id_petugas = $_POST["id_petugas"];
  $bb = $_POST["bb"];
  $tb = $_POST["tb"];
  $lk = $_POST["lk"];
  $perilaku = (count($_POST['perilaku']) > 0) ? implode('-', $_POST['perilaku']) : "";


  $simpan = "INSERT INTO ref_penimbangan VALUES('','$tanggal','$id_anak','$id_petugas','$bb','$tb', '$lk', '$perilaku')";

  mysqli_query($koneksi, $simpan);

  if (mysqli_affected_rows($koneksi) > 0) {
    echo "
    <script>
    alert('Data berhasil disimpan');
    document.location.href='index.php?hal=penimbangan&aksi=penimbanganperanak&id=$id_anak';
    </script>
    ";
  }else{
    echo "
    <script>
    alert('Data gagal disimpan');
    document.location.href='index.php?hal=penimbangan&aksi=penimbanganperanak&id=$id_anak';
    </script>
    ";
  }


}



?>

<h4 class="font-weight-bold">Halaman Tambah Penimbangan</h4>

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
    <h3 class="card-title">Penimbangan Anak</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form method="post" action="" id="frmanak">
    <div class="card-body">
      <input type="hidden" name="id_anak" value="<?= $pecah["id_anak"]; ?>">
      <div class="form-group">
        <label for="bb">BB Anak (KG)</label>
        <input type="text" name="bb" id="bb" class="form-control" autocomplete="off" placeholder="Masukkan BB anak">
      </div>
      <div class="form-group">
        <label for="tb">TB Anak (CM)</label>
        <input type="text" name="tb" id="tb" class="form-control" autocomplete="off" placeholder="Masukkan TB Anak" required>
      </div>

      <div class="form-group">
        <label for="lk">Lingkar Kepala</label>
        <input type="text" name="lk" id="lk" class="form-control" autocomplete="off" placeholder="Masukkan Lingkar Kepala Anak" required>
      </div>

      <div class="form-group">
        <label for="jk">Perilaku Anak</label><br>
        <?php if ($thn ==1) : ?>
          <p>Pada Usia 1 Tahun : </p>
          <input type="checkbox" name="perilaku[]" value="Berdiri dan berjalan berpegangan" class="mr-2">Berdiri dan berjalan berpegangan<br>
          <input type="checkbox" name="perilaku[]" value="Memegang benda kecil" class="mr-2">Memegang benda kecil<br>
          <input type="checkbox" name="perilaku[]" value="Meniru kata sederhana seperti ma..ma..pa..pa.." class="mr-2">Meniru kata sederhana seperti ma..ma..pa..pa..<br>
          <input type="checkbox" name="perilaku[]" value="Mengenal anggota keluarga" class="mr-2">Mengenal anggota keluarga<br>
          <input type="checkbox" name="perilaku[]" value="Takut pada orang yang belum dikenal" class="mr-2">Takut pada orang yang belum dikenal<br>
          <input type="checkbox" name="perilaku[]" value="Menunjuk apa yang diinginkan" class="mr-2">Menunjuk apa yang diinginkan<br>

          <?php elseif ($thn==2) : ?> 
            <p>Pada Umur 2 tahun : </p>
            <input type="checkbox" name="perilaku[]" value="Naik tangga dan berlari" class="mr-2" class="mr-2">Naik tangga dan berlari<br>
            <input type="checkbox" name="perilaku[]" value="Mencoret coret pensil pada kertas" class="mr-2">Mencoret coret pensil pada kertas<br>
            <input type="checkbox" name="perilaku[]" value="Dapat menunjuk 1 atau lebih bagian tubuhnya" class="mr-2">Dapat menunjuk 1 atau lebih bagian tubuhnya<br>
            <input type="checkbox" name="perilaku[]" value="Menyebut 3 sampai 6 kata" class="mr-2">Menyebut 3 sampai 6 kata<br>
            <input type="checkbox" name="perilaku[]" value="Memegang cangkir sendiri">Memegang cangkir sendiri<br>
            <input type="checkbox" name="perilaku[]" value="Belajar makan dan minum sendiri" class="mr-2">Belajar makan dan minum sendiri<br>


            <?php elseif ($thn==3) : ?> 
              <p>Pada Umur 3 tahun : </p>
              <input type="checkbox" name="perilaku[]" value="Mengayuh sepeda roda tiga" class="mr-2" >Mengayuh sepeda roda tiga<br>
              <input type="checkbox" name="perilaku[]" value="Berdiri diatas satu kaki tanpa berpegangan" class="mr-2">Berdiri diatas satu kaki tanpa berpegangan<br>
              <input type="checkbox" name="perilaku[]" value="Bicara dengan baik menggunakan 2 kata" class="mr-2">Bicara dengan baik menggunakan 2 kata<br>
              <input type="checkbox" name="perilaku[]" value="Mengenal 2-4 warna" class="mr-2">Mengenal 2-4 warna<br>
              <input type="checkbox" name="perilaku[]" value="Menyebut nama" class="mr-2">Menyebut nama<br>
              <input type="checkbox" name="perilaku[]" value="Menggambar garis lurus" class="mr-2">Menggambar garis lurus<br>
              <input type="checkbox" name="perilaku[]" value="Bermain dengan teman" class="mr-2">Bermain dengan teman<br>
              <input type="checkbox" name="perilaku[]" value="Melepas pakaiannya sendiri" class="mr-2">Melepas pakaiannya sendiri<br>
              <input type="checkbox" name="perilaku[]" value="Mengenakan baju sendiri" class="mr-2">Mengenakan baju sendiri<br>


              <?php elseif ($thn==4) : ?> 
                <p>Pada Usia 4 sampai 5 Tahun : </p>
                <input type="checkbox" name="perilaku[]" value="Melompat-lompat 1 kaki, menari dan berjalan lurus" class="mr-2">Melompat-lompat 1 kaki, menari dan berjalan lurus<br>
                <input type="checkbox" name="perilaku[]" value="Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)" class="mr-2">Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)<br>
                <input type="checkbox" name="perilaku[]" value="mengammbar tanda silang dan lingkaran" class="mr-2">mengammbar tanda silang dan lingkaran<br>
                <input type="checkbox" name="perilaku[]" value="Menangkap bola kecil dengan kedua tangan" class="mr-2">Menangkap bola kecil dengan kedua tangan<br>
                <input type="checkbox" name="perilaku[]" value="Menjawab pertanyaan dengan kata kata yang benar" class="mr-2">Menjawab pertanyaan dengan kata kata yang benar<br>
                <input type="checkbox" name="perilaku[]" value="Menyebut angka, menghitung jari" class="mr-2">Menyebut angka, menghitung jari<br>
                <input type="checkbox" name="perilaku[]" value="Bicaranya mudah dimengerti" class="mr-2">Bicaranya mudah dimengerti<br>
                <input type="checkbox" name="perilaku[]" value="Berpakaian sendiri tandpa dibantu" class="mr-2">Berpakaian sendiri tanpa dibantu<br>
                <input type="checkbox" name="perilaku[]" value="Mengancing baju atau pakaian boneka" class="mr-2">Mengancing baju atau pakaian boneka<br>
                <input type="checkbox" name="perilaku[]" value="Menggosok gigi tanpa bantuan" class="mr-2">Menggosok gigi tanpa bantuan<br>


                <?php elseif ($thn==5) : ?> 
                  <p>Pada Usia 4 sampai 5 Tahun : </p>
                  <input type="checkbox" name="perilaku[]" value="Melompat-lompat 1 kaki, menari dan berjalan lurus" class="mr-2">Melompat-lompat 1 kaki, menari dan berjalan lurus<br>
                  <input type="checkbox" name="perilaku[]" value="Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)" class="mr-2">Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)<br>
                  <input type="checkbox" name="perilaku[]" value="mengammbar tanda silang dan lingkaran" class="mr-2">mengammbar tanda silang dan lingkaran<br>
                  <input type="checkbox" name="perilaku[]" value="Menangkap bola kecil dengan kedua tangan" class="mr-2">Menangkap bola kecil dengan kedua tangan<br>
                  <input type="checkbox" name="perilaku[]" value="Menjawab pertanyaan dengan kata kata yang benar" class="mr-2">Menjawab pertanyaan dengan kata kata yang benar<br>
                  <input type="checkbox" name="perilaku[]" value="Menyebut angka, menghitung jari" class="mr-2">Menyebut angka, menghitung jari<br>
                  <input type="checkbox" name="perilaku[]" value="Bicaranya mudah dimengerti" class="mr-2">Bicaranya mudah dimengerti<br>
                  <input type="checkbox" name="perilaku[]" value="Berpakaian sendiri tandpa dibantu" class="mr-2">Berpakaian sendiri tanpa dibantu<br>
                  <input type="checkbox" name="perilaku[]" value="Mengancing baju atau pakaian boneka" class="mr-2">Mengancing baju atau pakaian boneka<br>
                  <input type="checkbox" name="perilaku[]" value="Menggosok gigi tanpa bantuan" class="mr-2">Menggosok gigi tanpa bantuan<br>                             

                  <?php elseif ($thn==6) : ?> 
                    <p>Pada usia 6 Tahun : </p>
                    <input type="checkbox" name="perilaku[]" value="Berjalan lurus" class="mr-2" >Berjalan lurus<br>
                    <input type="checkbox" name="perilaku[]" value="Berdiri dengan 1 kaki selama 11 detik" class="mr-2">Berdiri dengan 1 kaki selama 11 detik<br>
                    <input type="checkbox" name="perilaku[]" value="Menangkap bola kecil dengan kedua tangan" class="mr-2">Menangkap bola kecil dengan kedua tangan<br>
                    <input type="checkbox" name="perilaku[]" value="Menggambar segi empat" class="mr-2">Menggambar segi empat<br>
                    <input type="checkbox" name="perilaku[]" value="Mengerti arti lawan kata" class="mr-2">Mengerti arti lawan kata<br>
                    <input type="checkbox" name="perilaku[]" value="Menghitung angka 1-10" class="mr-2">Menghitung angka 1-10<br>
                    <input type="checkbox" name="perilaku[]" value="Mengenal warna" class="mr-2">Mengenal warna<br>
                    <input type="checkbox" name="perilaku[]" value="Mengikuti aturan permainan" class="mr-2">Mengikuti aturan permainan<br>
                    <input type="checkbox" name="perilaku[]" value="Berpakaian sendiri tanpa dibantu" class="mr-2">Berpakaian sendiri tanpa dibantu<br>


                    <?php elseif ($bln==1) : ?> 
                      <p>Pada Umur 1 Bulan sampai 3 Bulan</p>
                      <input type="checkbox" name="perilaku[]" value="Menatap ke ibu" class="mr-2">Menatap ke ibu<br>
                      <input type="checkbox" name="perilaku[]" value="mengeluarkan suara 0..0.." class="mr-2">mengeluarkan suara 0..0..<br>
                      <input type="checkbox" name="perilaku[]" value="tersenyum" class="mr-2">tersenyum<br>
                      <input type="checkbox" name="perilaku[]" value="Menggerakan tangan dan kaki" class="mr-2">Menggerakan tangan dan kaki<br>
                      <input type="checkbox" name="perilaku[]" value="Mengangkat kepala tegak ketika tengkurap" class="mr-2">Mengangkat kepala tegak ketika tengkurap<br>
                      <input type="checkbox" name="perilaku[]" value="tertawa" class="mr-2">tertawa<br>
                      <input type="checkbox" name="perilaku[]" value="Menggerakan kepala ke kiri dan kanan" class="mr-2">Menggerakan kepala ke kiri dan kanan<br>
                      <input type="checkbox" name="perilaku[]" value="Membalas tersenyum ketika diajak tersenyum" class="mr-2">Membalas tersenyum ketika diajak tersenyum<br>
                      <input type="checkbox" name="perilaku[]" value="Mengoceh" class="mr-2">Mengoceh<br>


                      <?php elseif ($bln==2) : ?> 
                        <p>Pada Umur 1 Bulan sampai 3 Bulan</p>
                        <input type="checkbox" name="perilaku[]" value="Menatap ke ibu" class="mr-2">Menatap ke ibu<br>
                        <input type="checkbox" name="perilaku[]" value="mengeluarkan suara 0..0.." class="mr-2">mengeluarkan suara 0..0..<br>
                        <input type="checkbox" name="perilaku[]" value="tersenyum" class="mr-2">tersenyum<br>
                        <input type="checkbox" name="perilaku[]" value="Menggerakan tangan dan kaki" class="mr-2">Menggerakan tangan dan kaki<br>
                        <input type="checkbox" name="perilaku[]" value="Mengangkat kepala tegak ketika tengkurap" class="mr-2">Mengangkat kepala tegak ketika tengkurap<br>
                        <input type="checkbox" name="perilaku[]" value="tertawa" class="mr-2">tertawa<br>
                        <input type="checkbox" name="perilaku[]" value="Menggerakan kepala ke kiri dan kanan" class="mr-2">Menggerakan kepala ke kiri dan kanan<br>
                        <input type="checkbox" name="perilaku[]" value="Membalas tersenyum ketika diajak tersenyum" class="mr-2">Membalas tersenyum ketika diajak tersenyum<br>
                        <input type="checkbox" name="perilaku[]" value="Mengoceh" class="mr-2">Mengoceh<br>


                        <?php elseif ($bln==3) : ?> {
                        <p>Pada Umur 1 Bulan sampai 3 Bulan</p>
                        <input type="checkbox" name="perilaku[]" value="Menatap ke ibu" class="mr-2">Menatap ke ibu<br>
                        <input type="checkbox" name="perilaku[]" value="mengeluarkan suara 0..0.." class="mr-2">mengeluarkan suara 0..0..<br>
                        <input type="checkbox" name="perilaku[]" value="tersenyum" class="mr-2">tersenyum<br>
                        <input type="checkbox" name="perilaku[]" value="Menggerakan tangan dan kaki" class="mr-2">Menggerakan tangan dan kaki<br>
                        <input type="checkbox" name="perilaku[]" value="Mengangkat kepala tegak ketika tengkurap" class="mr-2">Mengangkat kepala tegak ketika tengkurap<br>
                        <input type="checkbox" name="perilaku[]" value="tertawa" class="mr-2">tertawa<br>
                        <input type="checkbox" name="perilaku[]" value="Menggerakan kepala ke kiri dan kanan" class="mr-2">Menggerakan kepala ke kiri dan kanan<br>
                        <input type="checkbox" name="perilaku[]" value="Membalas tersenyum ketika diajak tersenyum" class="mr-2">Membalas tersenyum ketika diajak tersenyum<br>
                        <input type="checkbox" name="perilaku[]" value="Mengoceh" class="mr-2">Mengoceh<br>


                        <?php elseif ($bln==4):  ?> {
                        <p>Pada Umur 4 Bulan sampai 6 Bulan</p>
                        <input type="checkbox" name="perilaku[]" value="Berbalik dari telungkup ke telentang" class="mr-2" >Berbalik dari telungkup ke telentang<br>
                        <input type="checkbox" name="perilaku[]" value="Mempertahankan posisi kepala tetap tegak" class="mr-2">Mempertahankan posisi kepala tetap tegak<br>
                        <input type="checkbox" name="perilaku[]" value="Meraih benda yang ada di sekitarnya" class="mr-2">Meraih benda yang ada di sekitarnya<br>
                        <input type="checkbox" name="perilaku[]" value="Menirukan Bunyi" class="mr-2">Menirukan Bunyi<br>
                        <input type="checkbox" name="perilaku[]" value="Mengenggam Mainan" class="mr-2">Mengenggam Mainan<br>
                        <input type="checkbox" name="perilaku[]" value="Tersenyum ketika melihat mainan/ gambar yang menarik" class="mr-2">Tersenyum ketika melihat mainan/ gambar yang menarik<br>



                        <?php elseif ($bln==5) : ?> 
                          <p>Pada Umur 4 Bulan sampai 6 Bulan</p>
                          <input type="checkbox" name="perilaku[]" value="Berbalik dari telungkup ke telentang" class="mr-2" >Berbalik dari telungkup ke telentang<br>
                          <input type="checkbox" name="perilaku[]" value="Mempertahankan posisi kepala tetap tegak" class="mr-2">Mempertahankan posisi kepala tetap tegak<br>
                          <input type="checkbox" name="perilaku[]" value="Meraih benda yang ada di sekitarnya" class="mr-2">Meraih benda yang ada di sekitarnya<br>
                          <input type="checkbox" name="perilaku[]" value="Menirukan Bunyi" class="mr-2">Menirukan Bunyi<br>
                          <input type="checkbox" name="perilaku[]" value="Mengenggam Mainan" class="mr-2">Mengenggam Mainan<br>
                          <input type="checkbox" name="perilaku[]" value="Tersenyum ketika melihat mainan/ gambar yang menarik" class="mr-2">Tersenyum ketika melihat mainan/ gambar yang menarik<br>

                          <?php elseif ($bln==6) : ?>
                            <p>Pada Umur 4 Bulan sampai 6 Bulan</p>
                            <input type="checkbox" name="perilaku[]" value="Berbalik dari telungkup ke telentang" class="mr-2" >Berbalik dari telungkup ke telentang<br>
                            <input type="checkbox" name="perilaku[]" value="Mempertahankan posisi kepala tetap tegak" class="mr-2">Mempertahankan posisi kepala tetap tegak<br>
                            <input type="checkbox" name="perilaku[]" value="Meraih benda yang ada di sekitarnya" class="mr-2">Meraih benda yang ada di sekitarnya<br>
                            <input type="checkbox" name="perilaku[]" value="Menirukan Bunyi" class="mr-2">Menirukan Bunyi<br>
                            <input type="checkbox" name="perilaku[]" value="Mengenggam Mainan" class="mr-2">Mengenggam Mainan<br>
                            <input type="checkbox" name="perilaku[]" value="Tersenyum ketika melihat mainan/ gambar yang menarik" class="mr-2">Tersenyum ketika melihat mainan/ gambar yang menarik<br>

                            <?php elseif ($bln==7) : ?> 
                              <p>Pada Umur 7 Bulan</p>
                              <input type="checkbox" name="perilaku[]" value="Merambat" class="mr-2">Merambat<br>
                              <input type="checkbox" name="perilaku[]" value="ma..ma..da..da.." class="mr-2">Mengucapkan ma..ma..da..da..<br>
                              <input type="checkbox" name="perilaku[]" value="Meraih Benda sebesar kacang" class="mr-2">Meraih Benda sebesar kacang<br>
                              <input type="checkbox" name="perilaku[]" value="Mencari benda/mainan yang dijatuhkan" class="mr-2">Mencari benda/mainan yang dijatuhkan<br>
                              <input type="checkbox" name="perilaku[]" value="Bermain tepuk tangan atau ciluk-ba" class="mr-2">Bermain tepuk tangan atau ciluk-ba<br>
                              <input type="checkbox" name="perilaku[]" value="Makan kue/ biskuit sendiri" class="mr-2">Makan kue/ biskuit sendiri<br>
                              <input type="checkbox" name="perilaku[]" value="Berdiri dan berjalan berpegangan" class="mr-2">Berdiri dan berjalan berpegangan<br>
                              <input type="checkbox" name="perilaku[]" value="Memegang benda kecil" class="mr-2">Memegang benda kecil<br>
                              <input type="checkbox" name="perilaku[]" value="Meniru kata sederhana seperti ma..ma.. pa..pa.." class="mr-2">Meniru kata sederhana seperti ma..ma.. pa..pa..<br>
                              <input type="checkbox" name="perilaku[]" value="Mengenal anggota keluarga" class="mr-2">Mengenal anggota keluarga<br>
                              <input type="checkbox" name="perilaku[]" value="Takut pada orang yang belum dikenal" class="mr-2">Takut pada orang yang belum dikenal<br>
                              <input type="checkbox" name="perilaku[]" value="Menunjuk apa yang diinginkan" class="mr-2">Menunjuk apa yang diinginkan<br>

                              <?php else : ?>

                                <p>Pada Umur 0 Bulan sampai 3 Bulan</p>
                                <input type="checkbox" name="perilaku[]" value="Menatap ke ibu" class="mr-2">Menatap ke ibu<br>
                                <input type="checkbox" name="perilaku[]" value="mengeluarkan suara 0..0.." class="mr-2">mengeluarkan suara 0..0..<br>
                                <input type="checkbox" name="perilaku[]" value="tersenyum" class="mr-2">tersenyum<br>
                                <input type="checkbox" name="perilaku[]" value="Menggerakan tangan dan kaki" class="mr-2">Menggerakan tangan dan kaki<br>
                                <input type="checkbox" name="perilaku[]" value="Mengangkat kepala tegak ketika tengkurap" class="mr-2">Mengangkat kepala tegak ketika tengkurap<br>
                                <input type="checkbox" name="perilaku[]" value="tertawa" class="mr-2">tertawa<br>
                                <input type="checkbox" name="perilaku[]" value="Menggerakan kepala ke kiri dan kanan" class="mr-2">Menggerakan kepala ke kiri dan kanan<br>
                                <input type="checkbox" name="perilaku[]" value="Membalas tersenyum ketika diajak tersenyum" class="mr-2">Membalas tersenyum ketika diajak tersenyum<br>
                                <input type="checkbox" name="perilaku[]" value="Mengoceh" class="mr-2">Mengoceh<br>
                              <?php endif; ?>          
                            </div>
                            <div class="form-group">
                              <label for="petugas">Nama petugas</label>
                              <select class="form-control" id="id_petugas" name="id_petugas" style="width: 100%">
                                <?php 
                                $id_petugas= $_SESSION["id"];
                                $data_petugas = mysqli_query($koneksi, "SELECT * FROM ref_petugas WHERE status_petugas='Aktif' "); 
                                ?>
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

