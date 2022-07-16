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

$datafoto = mysqli_query($koneksi, "SELECT * FROM ref_ibu WHERE id_ibu='$id'");
$datafoto2 = mysqli_fetch_assoc($datafoto);
$foto = $datafoto2['foto_ibu'];


if (file_exists("assets/dist/img/$foto")) {
	@unlink("assets/dist/img/$foto");
}

$query = "DELETE FROM ref_ibu WHERE id_ibu='$id'";

mysqli_query($koneksi, $query);

if (mysqli_affected_rows($koneksi) > 0) {
  echo "
  <script>
  alert('Data berhasil dihapus');
  document.location.href='index.php?hal=ibu';
  </script>
  ";
}else{
  echo "
  <script>
  alert('Data gagal dihapus');
  document.location.href='index.php?hal=ibu';
  </script>
  ";

}

?>