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

$datafoto = mysqli_query($koneksi, "SELECT * FROM ref_petugas WHERE id_petugas='$id'");
$datafoto2 = mysqli_fetch_assoc($datafoto);
$foto = $datafoto2['foto_petugas'];


if (file_exists("assets/dist/img/$foto") != 'avatar4.png') {
	@unlink("assets/dist/img/$foto");
}

$query = "DELETE FROM ref_petugas WHERE id_petugas='$id'";

mysqli_query($koneksi, $query);

if (mysqli_affected_rows($koneksi) > 0) {
  echo "
  <script>
  alert('Data berhasil dihapus');
  document.location.href='index.php?hal=petugas';
  </script>
  ";
}else{
  echo "
  <script>
  alert('Data gagal dihapus');
  document.location.href='index.php?hal=petugas';
  </script>
  ";

}

?>