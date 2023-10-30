<?php
  session_start();
  session_destroy();
  echo "<script>alert('Anda telah Logout dari Sisfo Penilaian Wilayah Kalawat 1'); window.location = 'index.php'</script>";
?>