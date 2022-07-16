<?php

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

ob_start();

include "koneksi.php";

if (isset($_GET["id"])) {
  $id = $_GET["id"];
  if ($_GET["id"] == "") {
    echo "
    <script>
    alert('Oops ID kosong');
    document.location.href='index.php?hal=jadwal';
    </script>
    ";
  }
}else{
  echo "
  <script>
  alert('Oops tidak ada ID yang dipilih ');
  document.location.href='index.php?hal=jadwal';
  </script>
  ";
}



  // mengambil data didatabase
$data = mysqli_query($koneksi, "SELECT * FROM ref_anak WHERE id_anak='$id'");
$pecah = mysqli_fetch_assoc($data);
$nama = $pecah["nama_anak"];
$nik = $pecah["nik_anak"];
$tempat = $pecah["tempat_lahir_anak"];
$tgl_lahir = $pecah["tgl_lahir_anak"];


$ref_vaksin = mysqli_query($koneksi, "SELECT * FROM ref_vaksin");



function format_indo($date) {
  $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

  $tahun = substr($date, 0, 4);               
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
  $result = $tgl . " " . $BulanIndo[(int)$bulan-1]. " ". $tahun;
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

$tanggal = date('Y-m-d');
$tanggalhari_ini = format_indo($tanggal);








require "assets/plugins/html2pdf/html2pdf.class.php";

$content = ob_get_clean();
$content .='
<!DOCTYPE html>
<html>
<head>
<title>Jadwal Imunisasi</title>
<style>
h1{
  margin-bottom:10px;
  text-align :center;
  margin-top:40px;
}
h2{
  text-align :center;
}
table{
  margin-top:30px;
}
table th{
  padding:13px;
  text-align : center;
}

table .nomor{
  text-align : center;
}

table td{
  padding:13px;
}
.tgl{
  font-size:14px;
  margin-top:50px;
  margin-left:500px;
}
.ttd{
  font-size:14px;
  margin-top:80px;
  margin-left:500px;
}
.nama{
  margin-left:150px;
}
</style>
</head>
<body>
<h1>POSYANDU DESA ABCD</h1>
<h2>Jadwal Imunisasi</h2>
<hr>
<p class="nama">Nama : '.$nama.'</p>
<p class="nama">NIK  : '.$nik.'</p>
<p class="nama">TTL  : '.$tempat.', '.format_indo($tgl_lahir).'</p>
<table border="1" cellpadding="0" cellspacing="0" align="center">

<tr>
<th>No. </th>
<th>Nama Vaksin</th>
<th>Tanggal Pelaksanaan</th>

</tr>
';

$i = 1;
foreach ($ref_vaksin as $r) {

  $tanggal_lahir = new DateTime($pecah['tgl_lahir_anak']);
  $usia_vaksin = $r["usia_vaksin"];
  $tanggal_pervaksin = date_modify($tanggal_lahir, "+$usia_vaksin days");
  $tanggal_vaksin = $tanggal_pervaksin ->format('Y-m-d');

  $jadwal_tanggal = format_indo($tanggal_vaksin);


  $content .= '<tr>
  <td class="nomor">'. $i++ .'</td>
  <td>'.$r["nama_vaksin"].'</td>
  <td>'.$jadwal_tanggal.'</td>
  </tr>
  ';

}


$content .= '
</table> 
<p class="tgl">Semarang, '.$tanggalhari_ini.'</p>
<p class="ttd">Petugas</p>
</body>
</html>
';

ob_end_clean();

$html2pdf = new Html2Pdf('P','A4','en'); 
$html2pdf->writeHTML($content);
$html2pdf->output('Jadwal Imunisasi.pdf');

?>
