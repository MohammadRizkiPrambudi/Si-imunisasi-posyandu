<?php  

session_start();

session_destroy();

session_unset();

echo "
<script>
window.location.href='login.php';
</script>
";



?>