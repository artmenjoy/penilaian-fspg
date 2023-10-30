<?php
  session_start();
  session_destroy();
  echo "<script>alert('Anda telah Logout dari Sisfo Penilaian FSPG'); window.location = 'index.php'</script>";
?>