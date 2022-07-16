<?php  


if(!isset($_SESSION['login'])){
  echo "
  <script>
  document.location.href='login.php';
  </script>
  ";
}


include 'koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM ref_vaksin WHERE id_vaksin='$id'";

mysqli_query($koneksi, $query);

if (mysqli_affected_rows($koneksi) > 0) {
  echo "
  <script>
  alert('Data berhasil dihapus');
  document.location.href='index.php?hal=vaksin';
  </script>
  ";
}else{
  echo "
  <script>
  alert('Data gagal dihapus');
  document.location.href='index.php?hal=vaksin';
  </script>
  ";

}

?>