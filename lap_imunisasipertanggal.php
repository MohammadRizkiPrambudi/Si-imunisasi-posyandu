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


if (isset($_POST["print"])) {

  $tglawal = $_POST["tglawal"];
  $tglakhir = $_POST["tglakhir"];

  $query = mysqli_query($koneksi, "SELECT * FROM ref_anak, ref_imunisasi, ref_vaksin, ref_petugas WHERE ref_anak.id_anak = ref_imunisasi.id_anak AND ref_vaksin.id_vaksin = ref_imunisasi.id_vaksin AND ref_petugas.id_petugas = ref_imunisasi.id_petugas AND tgl_imunisasi BETWEEN '$tglawal' AND '$tglakhir' GROUP BY tgl_imunisasi ASC");
  


  function format_indo($date)
  {
    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

    $tahun = substr($date, 0, 4);               
    $bulan = substr($date, 5, 2);
    $tgl   = substr($date, 8, 2);
    $result = $tgl . " " . $BulanIndo[(int)$bulan-1]. " ". $tahun;
    return($result);
  }

  $tanggal = date('Y-m-d');
  $tanggalhari_ini = format_indo($tanggal);
  $tanggal_awal = format_indo($tglawal);
  $tanggal_akhir = format_indo($tglakhir);


}









require "assets/plugins/html2pdf/html2pdf.class.php";

$content = ob_get_clean();
$content .='
<!DOCTYPE html>
<html>
<head>
<title>Laporan Imunisasi Pertanggal</title>
<style>
h1{
  margin-bottom:10px;
  text-align :center;
  margin-top:40px;
}

h2{
  text-align :center;
}

h5{
  text-align :center;
}

table{
  margin-top:30px;
}
table th{
  padding:15px;
  text-align : center;

}

table .nomor{
  text-align : center;
}

table td{
  padding:15px;
}
.tgl{
  font-size:14px;
  margin-top:50px;
  margin-left:850px;
}
.ttd{
  font-size:14px;
  margin-top:80px;
  margin-left:850px;
}
</style>
</head>
<body>
<h1>POSYANDU DESA ABCD</h1>
<h2>Laporan Data Pertanggal</h2>
<h5>Periode Tanggal '.$tanggal_awal.' Sampai '.$tanggal_akhir.'</h5>
<hr>
<table border="1" cellpadding="0" cellspacing="0" align="center">

<tr>
<th>No. </th>
<th>Tanggal Imunisasi</th>
<th>NIK</th>
<th>Nama Anak</th>
<th>Nama Vaksin</th>
<th>Petugas</th>


</tr>
';

$i = 1;
foreach ($query as $r) {

  $content .= '<tr>
  <td class="nomor">'. $i++ .'</td>
  <td>'.format_indo($r["tgl_imunisasi"]).'</td>
  <td>'.$r["nik_anak"].'</td>
  <td>'.$r["nama_anak"].'</td>
  <td>'.$r["nama_vaksin"].'</td>
  <td>'.$r["nama_petugas"].'</td>
  ';

  $content .= '</tr>
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
$html2pdf->output('Laporan data imunisasi.pdf');

?>
