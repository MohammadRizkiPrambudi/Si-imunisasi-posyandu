<?php  

include 'koneksi.php';


$jumlah= NULL;

$nama_vaksin = mysqli_query($koneksi, "SELECT * FROM ref_vaksin");

$jumlah = mysqli_query($koneksi, "SELECT *, COUNT(*) AS total FROM ref_imunisasi GROUP BY id_vaksin");


?>


<h4 class="font-weight-bold">SELAMAT DATANG DI POSYANDU DESA ABCD</h4>

<h5>Pelaksanaan Imunisasi</h5>
<div>
  <canvas id="myChart"></canvas>
</div>


<!-- chart-js -->
<script src="assets/plugins/chart.js/Chart.bundle.js"></script>
<script>
  var ctx = document.getElementById("myChart");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
      <?php 
      

      foreach ($nama_vaksin as $value) {
        echo '"' . $value['nama_vaksin'] . '",';
      } ?>

      ],
      datasets: [{
        label: 'Grafik Pelaksanaan Imunisasi',
        data: [

        <?php 


        foreach ($jumlah as $value) {
          echo '"' . $value['total'] . '",';
        } ?>

        ],
        backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });
</script>