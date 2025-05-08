<?php
  session_start();
  session_destroy();
  echo "<script>alert('Anda telah keluar dari halaman Tata Usaha'); window.location = '../'</script>";
?>