<?php  

if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}

include 'koneksi.php';

if (isset($_GET["id"])) {
  $id_anak = $_GET["id"];
  if ($_GET["id"] == "") {
    echo "
    <script>
    alert('Oops ID kosong');
    document.location.href='index.php?hal=penimbangan';
    </script>
    ";
  }
}else{
  echo "
  <script>
  alert('Oops tidak ada ID yang dipilih ');
  document.location.href='index.php?hal=penimbangan';
  </script>
  ";
}

$tgl_penimbangan = "";
$tb_peranak = NULL;
$query = mysqli_query($koneksi, "SELECT * FROM ref_anak, ref_penimbangan WHERE ref_anak.id_anak = ref_penimbangan.id_anak AND ref_anak.id_anak = $id_anak");

$data = mysqli_query($koneksi, "SELECT * FROM ref_anak WHERE id_anak = $id_anak");
$pecah = mysqli_fetch_assoc($data);


foreach ($query as  $value) {
  $tanggal= $value["tgl_penimbangan"];
  $tgl_penimbangan .= "'$tanggal'". ", ";

  $tb=$value['tb_penimbangan'];
  $tb_peranak .= "$tb". ", ";
}


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



?>



<h4 class="font-weight-bold text-center">Grafik Perkembangan Tinggi Badan <?= $pecah["nama_anak"]; ?></h4>
<p class="text-center">Tanggal Lahir : <?= format_indo($pecah["tgl_lahir_anak"]); ?> || Umur : <?= $usia; ?> </p>


<a href="index.php?hal=penimbangan&aksi=penimbanganperanak&id=<?= $id_anak ?>" class="btn btn-success"><i class="fas fa-chevron-left mr-2"></i>Kembali</a>
<button type="submit" class="btn btn-danger" name="cetak" id="cetak" onclick="PrintImage()"><i class="fas fa-print mr-2"></i>Cetak</button> 


<div>
  <canvas id="myChart" style="min-height: 500px; height: 500px; max-height: 500px; max-width: 100%;"></canvas>
</div>


<!-- chart-js -->
<script src="assets/plugins/chart.js/Chart.bundle.js"></script>
<script>

  var speedCanvas = document.getElementById("myChart");

  Chart.defaults.global.defaultFontFamily = "Lato";
  Chart.defaults.global.defaultFontSize = 18;

  var speedData = {
    labels: [<?= $tgl_penimbangan; ?>],
    datasets: [{
      label: "Perkembangan TB Anak",
      data: [<?= $tb_peranak; ?>],
      borderColor: 'orange',
      backgroundColor: 'transparent'
    }]
  };

  var chartOptions = {
    legend: {
      display: true,
      position: 'top',
      labels: {
        boxWidth: 80,
        fontColor: 'black'

      }
    }
  };

  var lineChart = new Chart(speedCanvas, {
    type: 'line',
    data: speedData,
    options: chartOptions
  });
</script>

<script type="text/javascript">
  function PrintImage() {
    var canvas = document.getElementById("myChart");
    var win = window.open();
    win.document.write("<h3>Grafik Perkembangan Panjang Badan <?= $pecah['nama_anak']; ?></h3>");
    win.document.write("<br><img src='" + canvas.toDataURL() + "'/>");
    win.print();
    win.location.reload();

  }
</script>