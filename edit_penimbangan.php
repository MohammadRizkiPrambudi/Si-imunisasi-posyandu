<?php  

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

include 'koneksi.php';

$id_anak = $_GET["id_anak"];
$id_penimbangan = $_GET["id_penimbangan"];

// mengambil data didatabase
$data = mysqli_query($koneksi, "SELECT * FROM ref_anak WHERE id_anak='$id_anak'");
$pecah = mysqli_fetch_assoc($data);

$penimbangan = mysqli_query($koneksi, "SELECT * FROM ref_penimbangan WHERE id_penimbangan='$id_penimbangan'");

$pecahpenimbangan = mysqli_fetch_assoc($penimbangan);

$dataperilaku=explode('-', $pecahpenimbangan['perilaku']);



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



if (isset($_POST["ubah"])) {

  $tanggal = $_POST["tanggal"];
  $id_anak = $_POST["id_anak"];
  $id_petugas = $_POST["id_petugas"];
  $bb = $_POST["bb"];
  $tb = $_POST["tb"];
  $lk = $_POST["lk"];
  $perilaku = (count($_POST['perilaku']) > 0) ? implode('-', $_POST['perilaku']) : "";

  $ubah =  mysqli_query($koneksi, "UPDATE ref_penimbangan SET tgl_penimbangan='$tanggal', id_anak='$id_anak', id_petugas='$id_petugas', bb_penimbangan='$bb', tb_penimbangan='$tb', lingkar_kepala='$lk', perilaku='$perilaku' WHERE id_penimbangan='$id_penimbangan'");

  if ($ubah) {
    echo "
    <script>
    alert('Data berhasil diubah');
    document.location.href='index.php?hal=penimbangan&aksi=penimbanganperanak&id=$id_anak';
    </script>
    ";
  }else{
    echo "
    <script>
    alert('Data gagal diubah');
    document.location.href='index.php?hal=penimbangan&aksi=penimbanganperanak&id=$id_anak';
    </script>
    ";
  }

}


?>

<h4 class="font-weight-bold">Halaman Ubah Penimbangan</h4>

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
  <?php foreach ($penimbangan as $value): ?>
    <form method="post" action="" id="frmanak">
      <div class="card-body">
        <input type="hidden" name="id_anak" value="<?= $value["id_anak"]; ?>">
        <input type="hidden" name="id_penimbangan" value="<?= $value["id_penimbangan"]; ?>">
        <div class="form-group">
          <label for="tanggal">Tanggal Penimbangan</label>
          <input type="date" name="tanggal" id="tanggal" class="form-control" autocomplete="off" placeholder="Masukkan Tanggal Penimbangan" value="<?= $value["tgl_penimbangan"]; ?>">
        </div>
        <div class="form-group">
          <label for="bb">BB Anak (KG)</label>
          <input type="text" name="bb" id="bb" class="form-control" autocomplete="off" placeholder="Masukkan BB anak" value="<?= $value["bb_penimbangan"]; ?>">
        </div>
        <div class="form-group">
          <label for="tb">TB Anak (CM)</label>
          <input type="text" name="tb" id="tb" class="form-control" autocomplete="off" placeholder="Masukkan TB Anak" value="<?= $value["tb_penimbangan"]; ?>">
        </div>

        <div class="form-group">
          <label for="lk">Lingkar Kepala</label>
          <input type="text" name="lk" id="lk" class="form-control" autocomplete="off" placeholder="Masukkan Lingkar Kepala Anak" value="<?= $value["lingkar_kepala"]; ?>">
        </div>

        <div class="form-group">
          <label for="jk">Perilaku Anak</label><br>
          <?php if ($thn ==1) : ?>
            <p>Pada Usia 1 Tahun : </p>
            <input type="checkbox" name="perilaku[]" value="Berdiri dan berjalan berpegangan" class="mr-2" <?php if (in_array("Berdiri dan berjalan berpegangan", $dataperilaku)) echo "checked";?>>Berdiri dan berjalan berpegangan<br>
            <input type="checkbox" name="perilaku[]" value="Memegang benda kecil" class="mr-2" <?php if (in_array("Memegang benda kecil", $dataperilaku)) echo "checked";?>>Memegang benda kecil<br>
            <input type="checkbox" name="perilaku[]" value="Meniru kata sederhana seperti ma..ma..pa..pa.." class="mr-2" <?php if (in_array("Meniru kata sederhana seperti ma..ma..pa..pa..", $dataperilaku)) echo "checked";?>>Meniru kata sederhana seperti ma..ma..pa..pa..<br>
            <input type="checkbox" name="perilaku[]" value="Mengenal anggota keluarga" class="mr-2" <?php if (in_array("Mengenal anggota keluarga", $dataperilaku)) echo "checked";?>>Mengenal anggota keluarga<br>
            <input type="checkbox" name="perilaku[]" value="Takut pada orang yang belum dikenal" class="mr-2"  <?php if (in_array("Takut pada orang yang belum dikenal", $dataperilaku)) echo "checked";?>>Takut pada orang yang belum dikenal<br>
            <input type="checkbox" name="perilaku[]" value="Menunjuk apa yang diinginkan" class="mr-2" <?php if (in_array("Menunjuk apa yang diinginkan", $dataperilaku)) echo "checked";?> >Menunjuk apa yang diinginkan<br>
            
            <?php elseif ($thn==2) : ?> 
              <p>Pada Umur 2 tahun : </p>
              <input type="checkbox" name="perilaku[]" value="Naik tangga dan berlari" class="mr-2" class="mr-2" <?php if (in_array("Naik tangga dan berlari", $dataperilaku)) echo "checked";?> >Naik tangga dan berlari<br>
              <input type="checkbox" name="perilaku[]" value="Mencoret coret pensil pada kertas" class="mr-2" <?php if (in_array("Mencoret coret pensil pada kertas", $dataperilaku)) echo "checked";?>>Mencoret coret pensil pada kertas<br>
              <input type="checkbox" name="perilaku[]" value="Dapat menunjuk 1 atau lebih bagian tubuhnya" class="mr-2" <?php if (in_array("Dapat menunjuk 1 atau lebih bagian tubuhnya", $dataperilaku)) echo "checked";?> >Dapat menunjuk 1 atau lebih bagian tubuhnya<br>
              <input type="checkbox" name="perilaku[]" value="Menyebut 3 sampai 6 kata" class="mr-2" <?php if (in_array("Menyebut 3 sampai 6 kata", $dataperilaku)) echo "checked";?>>Menyebut 3 sampai 6 kata<br>
              <input type="checkbox" name="perilaku[]" value="Memegang cangkir sendiri" <?php if (in_array("Memegang cangkir sendiri", $dataperilaku)) echo "checked";?>>Memegang cangkir sendiri<br>
              <input type="checkbox" name="perilaku[]" value="Belajar makan dan minum sendiri" class="mr-2" <?php if (in_array("Belajar makan dan minum sendiri", $dataperilaku)) echo "checked";?>>Belajar makan dan minum sendiri<br>
              
              
              <?php elseif ($thn==3) : ?> 
                <p>Pada Umur 3 tahun : </p>
                <input type="checkbox" name="perilaku[]" value="Mengayuh sepeda roda tiga" class="mr-2" <?php if (in_array("Mengayuh sepeda roda tiga", $dataperilaku)) echo "checked";?> >Mengayuh sepeda roda tiga<br>
                <input type="checkbox" name="perilaku[]" value="Berdiri diatas satu kaki tanpa berpegangan" class="mr-2" <?php if (in_array("Berdiri diatas satu kaki tanpa berpegangan", $dataperilaku)) echo "checked";?>>Berdiri diatas satu kaki tanpa berpegangan<br>
                <input type="checkbox" name="perilaku[]" value="Bicara dengan baik menggunakan 2 kata" class="mr-2" <?php if (in_array("Bicara dengan baik menggunakan 2 kata", $dataperilaku)) echo "checked";?>>Bicara dengan baik menggunakan 2 kata<br>
                <input type="checkbox" name="perilaku[]" value="Mengenal 2-4 warna" class="mr-2" <?php if (in_array("Mengenal 2-4 warna", $dataperilaku)) echo "checked";?>>Mengenal 2-4 warna<br>
                <input type="checkbox" name="perilaku[]" value="Menyebut nama" class="mr-2" <?php if (in_array("Menyebut nama", $dataperilaku)) echo "checked";?>>Menyebut nama<br>
                <input type="checkbox" name="perilaku[]" value="Menggambar garis lurus" class="mr-2" <?php if (in_array("Menggambar garis lurus", $dataperilaku)) echo "checked";?> >Menggambar garis lurus<br>
                <input type="checkbox" name="perilaku[]" value="Bermain dengan teman" class="mr-2" <?php if (in_array("Bermain dengan teman", $dataperilaku)) echo "checked";?>>Bermain dengan teman<br>
                <input type="checkbox" name="perilaku[]" value="Melepas pakaiannya sendiri" class="mr-2" <?php if (in_array("Melepas pakaiannya sendiri", $dataperilaku)) echo "checked";?> >Melepas pakaiannya sendiri<br>
                <input type="checkbox" name="perilaku[]" value="Mengenakan baju sendiri" class="mr-2" <?php if (in_array("Mengenakan baju sendiri", $dataperilaku)) echo "checked";?>>Mengenakan baju sendiri<br>
                

                <?php elseif ($thn==4) : ?> 
                  <p>Pada Usia 4 sampai 5 Tahun : </p>
                  <input type="checkbox" name="perilaku[]" value="Melompat-lompat 1 kaki, menari dan berjalan lurus" class="mr-2" <?php if (in_array("Melompat-lompat 1 kaki, menari dan berjalan lurus", $dataperilaku)) echo "checked";?>>Melompat-lompat 1 kaki, menari dan berjalan lurus<br>
                  <input type="checkbox" name="perilaku[]" value="Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)" class="mr-2" <?php if (in_array("Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)", $dataperilaku)) echo "checked";?> >Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)<br>
                  <input type="checkbox" name="perilaku[]" value="mengammbar tanda silang dan lingkaran" class="mr-2" <?php if (in_array("mengammbar tanda silang dan lingkaran", $dataperilaku)) echo "checked";?>>mengammbar tanda silang dan lingkaran<br>
                  <input type="checkbox" name="perilaku[]" value="Menangkap bola kecil dengan kedua tangan" class="mr-2" <?php if (in_array("Menangkap bola kecil dengan kedua tangan", $dataperilaku)) echo "checked";?>>Menangkap bola kecil dengan kedua tangan<br>
                  <input type="checkbox" name="perilaku[]" value="Menjawab pertanyaan dengan kata kata yang benar" class="mr-2" <?php if (in_array("Menjawab pertanyaan dengan kata kata yang benar", $dataperilaku)) echo "checked";?>>Menjawab pertanyaan dengan kata kata yang benar<br>
                  <input type="checkbox" name="perilaku[]" value="Menyebut angka, menghitung jari" class="mr-2" <?php if (in_array("Menyebut angka, menghitung jari", $dataperilaku)) echo "checked";?>>Menyebut angka, menghitung jari<br>
                  <input type="checkbox" name="perilaku[]" value="Bicaranya mudah dimengerti" class="mr-2" <?php if (in_array("Bicaranya mudah dimengerti", $dataperilaku)) echo "checked";?>>Bicaranya mudah dimengerti<br>
                  <input type="checkbox" name="perilaku[]" value="Berpakaian sendiri tandpa dibantu" class="mr-2" <?php if (in_array("Berpakaian sendiri tandpa dibantu", $dataperilaku)) echo "checked";?>>Berpakaian sendiri tanpa dibantu<br>
                  <input type="checkbox" name="perilaku[]" value="Mengancing baju atau pakaian boneka" class="mr-2" <?php if (in_array("Mengancing baju atau pakaian boneka", $dataperilaku)) echo "checked";?>>Mengancing baju atau pakaian boneka<br>
                  <input type="checkbox" name="perilaku[]" value="Menggosok gigi tanpa bantuan" class="mr-2" <?php if (in_array("Menggosok gigi tanpa bantuan", $dataperilaku)) echo "checked";?>>Menggosok gigi tanpa bantuan<br>

                  
                  <?php elseif ($thn==5) : ?> 
                    <p>Pada Usia 4 sampai 5 Tahun : </p>
                    <input type="checkbox" name="perilaku[]" value="Melompat-lompat 1 kaki, menari dan berjalan lurus" class="mr-2" <?php if (in_array("Melompat-lompat 1 kaki, menari dan berjalan lurus", $dataperilaku)) echo "checked";?>>Melompat-lompat 1 kaki, menari dan berjalan lurus<br>
                    <input type="checkbox" name="perilaku[]" value="Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)" class="mr-2" <?php if (in_array("Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)", $dataperilaku)) echo "checked";?> >Menggambar orang 3 bagian (Kepala, Badan, tangan/kaki)<br>
                    <input type="checkbox" name="perilaku[]" value="mengammbar tanda silang dan lingkaran" class="mr-2" <?php if (in_array("mengammbar tanda silang dan lingkaran", $dataperilaku)) echo "checked";?>>mengammbar tanda silang dan lingkaran<br>
                    <input type="checkbox" name="perilaku[]" value="Menangkap bola kecil dengan kedua tangan" class="mr-2" <?php if (in_array("Menangkap bola kecil dengan kedua tangan", $dataperilaku)) echo "checked";?>>Menangkap bola kecil dengan kedua tangan<br>
                    <input type="checkbox" name="perilaku[]" value="Menjawab pertanyaan dengan kata kata yang benar" class="mr-2" <?php if (in_array("Menjawab pertanyaan dengan kata kata yang benar", $dataperilaku)) echo "checked";?>>Menjawab pertanyaan dengan kata kata yang benar<br>
                    <input type="checkbox" name="perilaku[]" value="Menyebut angka, menghitung jari" class="mr-2" <?php if (in_array("Menyebut angka, menghitung jari", $dataperilaku)) echo "checked";?>>Menyebut angka, menghitung jari<br>
                    <input type="checkbox" name="perilaku[]" value="Bicaranya mudah dimengerti" class="mr-2" <?php if (in_array("Bicaranya mudah dimengerti", $dataperilaku)) echo "checked";?>>Bicaranya mudah dimengerti<br>
                    <input type="checkbox" name="perilaku[]" value="Berpakaian sendiri tandpa dibantu" class="mr-2" <?php if (in_array("Berpakaian sendiri tandpa dibantu", $dataperilaku)) echo "checked";?>>Berpakaian sendiri tanpa dibantu<br>
                    <input type="checkbox" name="perilaku[]" value="Mengancing baju atau pakaian boneka" class="mr-2" <?php if (in_array("Mengancing baju atau pakaian boneka", $dataperilaku)) echo "checked";?>>Mengancing baju atau pakaian boneka<br>
                    <input type="checkbox" name="perilaku[]" value="Menggosok gigi tanpa bantuan" class="mr-2" <?php if (in_array("Menggosok gigi tanpa bantuan", $dataperilaku)) echo "checked";?>>Menggosok gigi tanpa bantuan<br>                             

                    <?php elseif ($thn==6) : ?> 
                      <p>Pada usia 6 Tahun : </p>
                      <input type="checkbox" name="perilaku[]" value="Berjalan lurus" class="mr-2" <?php if (in_array("Berjalan lurus", $dataperilaku)) echo "checked";?>>Berjalan lurus<br>
                      <input type="checkbox" name="perilaku[]" value="Berdiri dengan 1 kaki selama 11 detik" class="mr-2" <?php if (in_array("Berdiri dengan 1 kaki selama 11 detik", $dataperilaku)) echo "checked";?>>Berdiri dengan 1 kaki selama 11 detik<br>
                      <input type="checkbox" name="perilaku[]" value="Menangkap bola kecil dengan kedua tangan" class="mr-2" <?php if (in_array("Menangkap bola kecil dengan kedua tangan", $dataperilaku)) echo "checked";?>>Menangkap bola kecil dengan kedua tangan<br>
                      <input type="checkbox" name="perilaku[]" value="Menggambar segi empat" class="mr-2" <?php if (in_array("Menggambar segi empat", $dataperilaku)) echo "checked";?>>Menggambar segi empat<br>
                      <input type="checkbox" name="perilaku[]" value="Mengerti arti lawan kata" class="mr-2" <?php if (in_array("Mengerti arti lawan kata", $dataperilaku)) echo "checked";?>>Mengerti arti lawan kata<br>
                      <input type="checkbox" name="perilaku[]" value="Menghitung angka 1-10" class="mr-2" <?php if (in_array("Menghitung angka 1-10", $dataperilaku)) echo "checked";?>>Menghitung angka 1-10<br>
                      <input type="checkbox" name="perilaku[]" value="Mengenal warna" class="mr-2" <?php if (in_array("Mengenal warna", $dataperilaku)) echo "checked";?>>Mengenal warna<br>
                      <input type="checkbox" name="perilaku[]" value="Mengikuti aturan permainan" class="mr-2" <?php if (in_array("Mengikuti aturan permainan", $dataperilaku)) echo "checked";?>>Mengikuti aturan permainan<br>
                      <input type="checkbox" name="perilaku[]" value="Berpakaian sendiri tanpa dibantu" class="mr-2" <?php if (in_array("Berpakaian sendiri tanpa dibantu", $dataperilaku)) echo "checked";?>>Berpakaian sendiri tanpa dibantu<br>
                      
                      
                      <?php elseif ($bln==1) : ?> 
                        <p>Pada Umur 1 Bulan sampai 3 Bulan</p>
                        <input type="checkbox" name="perilaku[]" value="Menatap ke ibu" class="mr-2" <?php if (in_array("Menatap ke ibu", $dataperilaku)) echo "checked";?>>Menatap ke ibu<br>
                        <input type="checkbox" name="perilaku[]" value="Mengeluarkan suara 0..0.." class="mr-2" <?php if (in_array("Mengeluarkan suara 0..0..", $dataperilaku)) echo "checked";?> >Mengeluarkan suara 0..0..<br>
                        <input type="checkbox" name="perilaku[]" value="Tersenyum" class="mr-2"<?php if (in_array("Tersenyum", $dataperilaku)) echo "checked";?>>Tersenyum<br>
                        <input type="checkbox" name="perilaku[]" value="Menggerakan tangan dan kaki" class="mr-2" <?php if (in_array("Menggerakan tangan dan kaki", $dataperilaku)) echo "checked";?>>Menggerakan tangan dan kaki<br>
                        <input type="checkbox" name="perilaku[]" value="Mengangkat kepala tegak ketika tengkurap" class="mr-2" <?php if (in_array("Mengangkat kepala tegak ketika tengkurap", $dataperilaku)) echo "checked";?>>Mengangkat kepala tegak ketika tengkurap<br>
                        <input type="checkbox" name="perilaku[]" value="Tertawa" class="mr-2" <?php if (in_array("Tertawa", $dataperilaku)) echo "checked";?> >Tertawa<br>
                        <input type="checkbox" name="perilaku[]" value="Menggerakan kepala ke kiri dan kanan" class="mr-2" <?php if (in_array("Menggerakan kepala ke kiri dan kanan", $dataperilaku)) echo "checked";?>>Menggerakan kepala ke kiri dan kanan<br>
                        <input type="checkbox" name="perilaku[]" value="Membalas tersenyum ketika diajak tersenyum" class="mr-2" <?php if (in_array("Membalas tersenyum ketika diajak tersenyum", $dataperilaku)) echo "checked";?>>Membalas tersenyum ketika diajak tersenyum<br>
                        <input type="checkbox" name="perilaku[]" value="Mengoceh" class="mr-2" <?php if (in_array("Mengoceh", $dataperilaku)) echo "checked";?>>Mengoceh<br>
                        

                        <?php elseif ($bln==2) : ?> 
                          <p>Pada Umur 1 Bulan sampai 3 Bulan</p>
                          <input type="checkbox" name="perilaku[]" value="Menatap ke ibu" class="mr-2" <?php if (in_array("Menatap ke ibu", $dataperilaku)) echo "checked";?>>Menatap ke ibu<br>
                          <input type="checkbox" name="perilaku[]" value="Mengeluarkan suara 0..0.." class="mr-2" <?php if (in_array("Mengeluarkan suara 0..0..", $dataperilaku)) echo "checked";?> >Mengeluarkan suara 0..0..<br>
                          <input type="checkbox" name="perilaku[]" value="Tersenyum" class="mr-2"<?php if (in_array("Tersenyum", $dataperilaku)) echo "checked";?>>Tersenyum<br>
                          <input type="checkbox" name="perilaku[]" value="Menggerakan tangan dan kaki" class="mr-2" <?php if (in_array("Menggerakan tangan dan kaki", $dataperilaku)) echo "checked";?>>Menggerakan tangan dan kaki<br>
                          <input type="checkbox" name="perilaku[]" value="Mengangkat kepala tegak ketika tengkurap" class="mr-2" <?php if (in_array("Mengangkat kepala tegak ketika tengkurap", $dataperilaku)) echo "checked";?>>Mengangkat kepala tegak ketika tengkurap<br>
                          <input type="checkbox" name="perilaku[]" value="Tertawa" class="mr-2" <?php if (in_array("Tertawa", $dataperilaku)) echo "checked";?> >Tertawa<br>
                          <input type="checkbox" name="perilaku[]" value="Menggerakan kepala ke kiri dan kanan" class="mr-2" <?php if (in_array("Menggerakan kepala ke kiri dan kanan", $dataperilaku)) echo "checked";?>>Menggerakan kepala ke kiri dan kanan<br>
                          <input type="checkbox" name="perilaku[]" value="Membalas tersenyum ketika diajak tersenyum" class="mr-2" <?php if (in_array("Membalas tersenyum ketika diajak tersenyum", $dataperilaku)) echo "checked";?>>Membalas tersenyum ketika diajak tersenyum<br>
                          <input type="checkbox" name="perilaku[]" value="Mengoceh" class="mr-2" <?php if (in_array("Mengoceh", $dataperilaku)) echo "checked";?>>Mengoceh<br>


                          <?php elseif ($bln==3) : ?> {
                          <p>Pada Umur 1 Bulan sampai 3 Bulan</p>
                          <input type="checkbox" name="perilaku[]" value="Menatap ke ibu" class="mr-2" <?php if (in_array("Menatap ke ibu", $dataperilaku)) echo "checked";?>>Menatap ke ibu<br>
                          <input type="checkbox" name="perilaku[]" value="Mengeluarkan suara 0..0.." class="mr-2" <?php if (in_array("Mengeluarkan suara 0..0..", $dataperilaku)) echo "checked";?> >Mengeluarkan suara 0..0..<br>
                          <input type="checkbox" name="perilaku[]" value="Tersenyum" class="mr-2"<?php if (in_array("Tersenyum", $dataperilaku)) echo "checked";?>>Tersenyum<br>
                          <input type="checkbox" name="perilaku[]" value="Menggerakan tangan dan kaki" class="mr-2" <?php if (in_array("Menggerakan tangan dan kaki", $dataperilaku)) echo "checked";?>>Menggerakan tangan dan kaki<br>
                          <input type="checkbox" name="perilaku[]" value="Mengangkat kepala tegak ketika tengkurap" class="mr-2" <?php if (in_array("Mengangkat kepala tegak ketika tengkurap", $dataperilaku)) echo "checked";?>>Mengangkat kepala tegak ketika tengkurap<br>
                          <input type="checkbox" name="perilaku[]" value="Tertawa" class="mr-2" <?php if (in_array("Tertawa", $dataperilaku)) echo "checked";?> >Tertawa<br>
                          <input type="checkbox" name="perilaku[]" value="Menggerakan kepala ke kiri dan kanan" class="mr-2" <?php if (in_array("Menggerakan kepala ke kiri dan kanan", $dataperilaku)) echo "checked";?>>Menggerakan kepala ke kiri dan kanan<br>
                          <input type="checkbox" name="perilaku[]" value="Membalas tersenyum ketika diajak tersenyum" class="mr-2" <?php if (in_array("Membalas tersenyum ketika diajak tersenyum", $dataperilaku)) echo "checked";?>>Membalas tersenyum ketika diajak tersenyum<br>
                          <input type="checkbox" name="perilaku[]" value="Mengoceh" class="mr-2" <?php if (in_array("Mengoceh", $dataperilaku)) echo "checked";?>>Mengoceh<br>


                          <?php elseif ($bln==4):  ?> {
                          <p>Pada Umur 4 Bulan sampai 6 Bulan</p>
                          <input type="checkbox" name="perilaku[]" value="Berbalik dari telungkup ke telentang" class="mr-2" <?php if (in_array("Berbalik dari telungkup ke telentang", $dataperilaku)) echo "checked";?>>Berbalik dari telungkup ke telentang<br>
                          <input type="checkbox" name="perilaku[]" value="Mempertahankan posisi kepala tetap tegak" class="mr-2" <?php if (in_array("Mempertahankan posisi kepala tetap tegak", $dataperilaku)) echo "checked";?> >Mempertahankan posisi kepala tetap tegak<br>
                          <input type="checkbox" name="perilaku[]" value="Meraih benda yang ada di sekitarnya" class="mr-2" <?php if (in_array("Meraih benda yang ada di sekitarnya", $dataperilaku)) echo "checked";?>>Meraih benda yang ada di sekitarnya<br>
                          <input type="checkbox" name="perilaku[]" value="Menirukan Bunyi" class="mr-2" <?php if (in_array("Menirukan Bunyi", $dataperilaku)) echo "checked";?>>Menirukan Bunyi<br>
                          <input type="checkbox" name="perilaku[]" value="Mengenggam Mainan" class="mr-2" <?php if (in_array("Mengenggam Mainan", $dataperilaku)) echo "checked";?>>Mengenggam Mainan<br>
                          <input type="checkbox" name="perilaku[]" value="Tersenyum ketika melihat mainan/ gambar yang menarik" class="mr-2" <?php if (in_array("Tersenyum ketika melihat mainan/ gambar yang menarik", $dataperilaku)) echo "checked";?>>Tersenyum ketika melihat mainan/ gambar yang menarik<br>
                          
                          

                          <?php elseif ($bln==5) : ?> 
                            <p>Pada Umur 4 Bulan sampai 6 Bulan</p>
                            <input type="checkbox" name="perilaku[]" value="Berbalik dari telungkup ke telentang" class="mr-2" <?php if (in_array("Berbalik dari telungkup ke telentang", $dataperilaku)) echo "checked";?>>Berbalik dari telungkup ke telentang<br>
                            <input type="checkbox" name="perilaku[]" value="Mempertahankan posisi kepala tetap tegak" class="mr-2" <?php if (in_array("Mempertahankan posisi kepala tetap tegak", $dataperilaku)) echo "checked";?> >Mempertahankan posisi kepala tetap tegak<br>
                            <input type="checkbox" name="perilaku[]" value="Meraih benda yang ada di sekitarnya" class="mr-2" <?php if (in_array("Meraih benda yang ada di sekitarnya", $dataperilaku)) echo "checked";?>>Meraih benda yang ada di sekitarnya<br>
                            <input type="checkbox" name="perilaku[]" value="Menirukan Bunyi" class="mr-2" <?php if (in_array("Menirukan Bunyi", $dataperilaku)) echo "checked";?>>Menirukan Bunyi<br>
                            <input type="checkbox" name="perilaku[]" value="Mengenggam Mainan" class="mr-2" <?php if (in_array("Mengenggam Mainan", $dataperilaku)) echo "checked";?>>Mengenggam Mainan<br>
                            <input type="checkbox" name="perilaku[]" value="Tersenyum ketika melihat mainan/ gambar yang menarik" class="mr-2" <?php if (in_array("Tersenyum ketika melihat mainan/ gambar yang menarik", $dataperilaku)) echo "checked";?>>Tersenyum ketika melihat mainan/ gambar yang menarik<br>


                            <?php elseif ($bln==6) : ?>
                              <p>Pada Umur 4 Bulan sampai 6 Bulan</p>
                              <input type="checkbox" name="perilaku[]" value="Berbalik dari telungkup ke telentang" class="mr-2" <?php if (in_array("Berbalik dari telungkup ke telentang", $dataperilaku)) echo "checked";?>>Berbalik dari telungkup ke telentang<br>
                              <input type="checkbox" name="perilaku[]" value="Mempertahankan posisi kepala tetap tegak" class="mr-2" <?php if (in_array("Mempertahankan posisi kepala tetap tegak", $dataperilaku)) echo "checked";?> >Mempertahankan posisi kepala tetap tegak<br>
                              <input type="checkbox" name="perilaku[]" value="Meraih benda yang ada di sekitarnya" class="mr-2" <?php if (in_array("Meraih benda yang ada di sekitarnya", $dataperilaku)) echo "checked";?>>Meraih benda yang ada di sekitarnya<br>
                              <input type="checkbox" name="perilaku[]" value="Menirukan Bunyi" class="mr-2" <?php if (in_array("Menirukan Bunyi", $dataperilaku)) echo "checked";?>>Menirukan Bunyi<br>
                              <input type="checkbox" name="perilaku[]" value="Mengenggam Mainan" class="mr-2" <?php if (in_array("Mengenggam Mainan", $dataperilaku)) echo "checked";?>>Mengenggam Mainan<br>
                              <input type="checkbox" name="perilaku[]" value="Tersenyum ketika melihat mainan/ gambar yang menarik" class="mr-2" <?php if (in_array("Tersenyum ketika melihat mainan/ gambar yang menarik", $dataperilaku)) echo "checked";?>>Tersenyum ketika melihat mainan/ gambar yang menarik<br>
                              
                              <?php elseif ($bln==7) : ?> 
                                <p>Pada Umur 7 Bulan</p>
                                <input type="checkbox" name="perilaku[]" value="Merambat" class="mr-2" <?php if (in_array("Merambat", $dataperilaku)) echo "checked";?>>Merambat<br>
                                <input type="checkbox" name="perilaku[]" value="Ma..ma..da..da.." class="mr-2" <?php if (in_array("Ma..ma..da..da..", $dataperilaku)) echo "checked";?>>Mengucapkan ma..ma..da..da..<br>
                                <input type="checkbox" name="perilaku[]" value="Meraih Benda sebesar kacang" class="mr-2" <?php if (in_array("Meraih Benda sebesar kacang ", $dataperilaku)) echo "checked";?>>Meraih Benda sebesar kacang<br>
                                <input type="checkbox" name="perilaku[]" value="Mencari benda/mainan yang dijatuhkan" class="mr-2" <?php if (in_array("Mencari benda/mainan yang dijatuhkan", $dataperilaku)) echo "checked";?> >Mencari benda/mainan yang dijatuhkan<br>
                                <input type="checkbox" name="perilaku[]" value="Bermain tepuk tangan atau ciluk-ba" class="mr-2" <?php if (in_array("Bermain tepuk tangan atau ciluk-ba", $dataperilaku)) echo "checked";?>>Bermain tepuk tangan atau ciluk-ba<br>
                                <input type="checkbox" name="perilaku[]" value="Makan kue/ biskuit sendiri" class="mr-2" <?php if (in_array("Makan kue/ biskuit sendiri", $dataperilaku)) echo "checked";?>>Makan kue/ biskuit sendiri<br>
                                <input type="checkbox" name="perilaku[]" value="Berdiri dan berjalan berpegangan" class="mr-2" <?php if (in_array("Berdiri dan berjalan berpegangan", $dataperilaku)) echo "checked";?>>Berdiri dan berjalan berpegangan<br>
                                <input type="checkbox" name="perilaku[]" value="Memegang benda kecil" class="mr-2" <?php if (in_array("Memegang benda kecil", $dataperilaku)) echo "checked";?>>Memegang benda kecil<br>
                                <input type="checkbox" name="perilaku[]" value="Meniru kata sederhana seperti ma..ma.. pa..pa.." class="mr-2" <?php if (in_array("Meniru kata sederhana seperti ma..ma.. pa..pa..", $dataperilaku)) echo "checked";?>>Meniru kata sederhana seperti ma..ma.. pa..pa..<br>
                                <input type="checkbox" name="perilaku[]" value="Mengenal anggota keluarga" class="mr-2" <?php if (in_array("Mengenal anggota keluarga", $dataperilaku)) echo "checked";?>>Mengenal anggota keluarga<br>
                                <input type="checkbox" name="perilaku[]" value="Takut pada orang yang belum dikenal" class="mr-2" <?php if (in_array("Takut pada orang yang belum dikenal", $dataperilaku)) echo "checked";?>>Takut pada orang yang belum dikenal<br>
                                <input type="checkbox" name="perilaku[]" value="Menunjuk apa yang diinginkan" class="mr-2" <?php if (in_array("Menunjuk apa yang diinginkan", $dataperilaku)) echo "checked";?>>Menunjuk apa yang diinginkan<br>
                                
                                <?php else : ?>
                                  <p>Pada Umur 0 Bulan sampai 3 Bulan</p>
                                  <input type="checkbox" name="perilaku[]" value="Menatap ke ibu" class="mr-2" <?php if (in_array("Menatap ke ibu", $dataperilaku)) echo "checked";?>>Menatap ke ibu<br>
                                  <input type="checkbox" name="perilaku[]" value="Mengeluarkan suara 0..0.." class="mr-2" <?php if (in_array("Mengeluarkan suara 0..0..", $dataperilaku)) echo "checked";?> >Mengeluarkan suara 0..0..<br>
                                  <input type="checkbox" name="perilaku[]" value="Tersenyum" class="mr-2"<?php if (in_array("Tersenyum", $dataperilaku)) echo "checked";?>>Tersenyum<br>
                                  <input type="checkbox" name="perilaku[]" value="Menggerakan tangan dan kaki" class="mr-2" <?php if (in_array("Menggerakan tangan dan kaki", $dataperilaku)) echo "checked";?>>Menggerakan tangan dan kaki<br>
                                  <input type="checkbox" name="perilaku[]" value="Mengangkat kepala tegak ketika tengkurap" class="mr-2" <?php if (in_array("Mengangkat kepala tegak ketika tengkurap", $dataperilaku)) echo "checked";?>>Mengangkat kepala tegak ketika tengkurap<br>
                                  <input type="checkbox" name="perilaku[]" value="Tertawa" class="mr-2" <?php if (in_array("Tertawa", $dataperilaku)) echo "checked";?> >Tertawa<br>
                                  <input type="checkbox" name="perilaku[]" value="Menggerakan kepala ke kiri dan kanan" class="mr-2" <?php if (in_array("Menggerakan kepala ke kiri dan kanan", $dataperilaku)) echo "checked";?>>Menggerakan kepala ke kiri dan kanan<br>
                                  <input type="checkbox" name="perilaku[]" value="Membalas tersenyum ketika diajak tersenyum" class="mr-2" <?php if (in_array("Membalas tersenyum ketika diajak tersenyum", $dataperilaku)) echo "checked";?>>Membalas tersenyum ketika diajak tersenyum<br>
                                  <input type="checkbox" name="perilaku[]" value="Mengoceh" class="mr-2" <?php if (in_array("Mengoceh", $dataperilaku)) echo "checked";?>>Mengoceh<br>
                                <?php endif; ?>
        <!-- <div class="form-check">
          <input class="mr-2" type="checkbox" name="jk" value="L">
          <label class="form-check-label">Laki-Laki</label>
          <input class="mr-2 ml-2" type="checkbox" name="jk" value="P">
          <label class="form-check-label ml-4">Perempuan</label>
        </div>     -->            
      </div>
      <div class="form-group">
        <label for="petugas">Nama petugas</label>
        <select class="form-control" id="id_petugas" name="id_petugas" style="width: 100%">
          <?php $data_petugas = mysqli_query($koneksi, "SELECT * FROM ref_petugas WHERE status_petugas='Aktif'"); ?>
          <?php foreach($data_petugas as $nama) : ?>
            <option value="<?= $nama['id_petugas']; ?>" <?php if ($value["id_petugas"] == $nama["id_petugas"]){echo "selected";} ?>><?= $nama["nama_petugas"]; ?></option>
          <?php endforeach; ?>
          
        </select>
      </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <button type="submit" class="btn btn-info" name="ubah">Simpan</button>
      <button type="reset" class="btn btn-danger">Reset</button>
      <a href="index.php?hal=anak" class="btn btn-success">Kembali</a>
    </div>
  </form>
<?php endforeach ?>
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