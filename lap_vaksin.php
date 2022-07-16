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


$query = mysqli_query($koneksi, "SELECT * FROM ref_vaksin");

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




require "assets/plugins/html2pdf/html2pdf.class.php";

$content = ob_get_clean();
$content .='
<!DOCTYPE html>
<html>
<head>
<title>Laporan Data Vaksin</title>
<style>
h1{
  margin-bottom:20px;
  text-align :center;
  margin-top:40px;
}
table{
  margin-top:30px;
}
table th{
  padding:20px;
  text-align : center;
  width:100px;
}

table .nomor{
  text-align : center;
}

table td{
  padding:20px;
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
</style>
</head>
<body>
<h1>LAPORAN DATA VAKSIN</h1>
<hr>
<table border="1" cellpadding="0" cellspacing="0" align="center">

<tr>
<th>No. </th>
<th>Nama Vaksin</th>
<th>Usia Wajib</th>
</tr>
';

$i = 1;
foreach ($query as $r) {
  $content .= '<tr>
  <td class="nomor">'. $i++ .'</td>
  <td>'.$r["nama_vaksin"].'</td>
  <td>'.$r["usia_vaksin"].' Hari</td>
  </tr>
  ';
  
}


$content .= '
</table> 
<p class="tgl">Semarang, '.$tanggalhari_ini.'</p>
<p class="ttd">Operator</p>
</body>
</html>
';

ob_end_clean();

$html2pdf = new Html2Pdf('P','A4','en'); 
$html2pdf->writeHTML($content);
$html2pdf->output('Laporan data vaksin.pdf');

?>
