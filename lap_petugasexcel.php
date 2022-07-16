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


$query = mysqli_query($koneksi, "SELECT * FROM ref_petugas");

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
<title>Laporan Petugas</title>
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
<h2>Laporan Data Petugas</h2>

<table border="1" cellpadding="0" cellspacing="0" align="center">

<tr>
<th>No. </th>
<th>Nama Petugas</th>
<th>TTL</th>
<th>Alamat</th>
<th>Jabatan</th>
<th>No WA</th>
<th>Status</th>


</tr>
';

$i = 1;
foreach ($query as $r) {

  $content .= '<tr>
  <td class="nomor">'. $i++ .'</td>
  <td>'.$r["nama_petugas"].'</td>
  <td>'.$r["tempat_lahir_petugas"].','.$r["tgl_lahir_petugas"].'</td>
  <td>'.$r["alamat_petugas"].'</td>
  <td>'.$r["jabatan_petugas"].'</td>
  <td>'.$r["no_telp_petugas"].'</td>
  <td>'.$r["status_petugas"].'</td>';

  // if ($r["foto_petugas"] == "-") {
  //   $content .= '<td>-</td>';
  // }else{
  //   $content .= '<td><img src="http://localhost/posyandu/assets/dist/img/'.$r["foto_petugas"].'" width="80"></td>';

  // }

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



header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Lap_data_petugas.xls");



echo $content;

?>
