<?php
$_SERVER['PHP_SELF'] = 'login.php';
include 'c:/xampp/htdocs/raporkm/config/koneksi.php';
$res = mysqli_query($mysqli, 'SHOW TABLES');
while($row = mysqli_fetch_array($res)) {
    echo $row[0] . PHP_EOL;
}
?>
