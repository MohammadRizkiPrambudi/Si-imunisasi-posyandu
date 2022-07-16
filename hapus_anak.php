<?php  

if(!isset($_SESSION['login'])){
	echo "
	<script>
	document.location.href='login.php';
	</script>
	";
}

include 'koneksi.php';

$id = $_GET["id"];

$queryhapus = "DELETE FROM ref_anak WHERE id_anak='$id'";
mysqli_query($koneksi, $queryhapus);
if (mysqli_affected_rows($koneksi) > 0) {
	echo "
	<script>
	alert('Data berhasil dihapus');
	</script>
	";
	header('Location: index.php?hal=anak');
}else{
	echo "
	<script>
	alert('Data gagal dihapus');
	</script>
	";
	header('Location: index.php?hal=anak');
}


?>