<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();
error_reporting(E_ALL);
// error_reporting(0);
// ini_set('display_errors', 1);

$current_file = basename($_SERVER['PHP_SELF']);
if ($current_file != 'login.php') {
    // Memeriksa apakah sesi tidak ada atau jabatan bukan '2' atau '3'
    if (empty($_SESSION['id_user']) || empty($_SESSION['jabatan']) || 
        ($_SESSION['jabatan'] != '2' && $_SESSION['jabatan'] != '3')) {
        
        echo "
        <script>
        alert('Sesi anda Telah Habis atau Jabatan Tidak Sesuai. Silahkan login Kembali');
        window.location.href = '../';
        </script>";
        exit;
    }
}


require_once('fungsi_validasi.php');

$host = "localhost";
$user = "abdinega_abdira";
$pass = "abdinega_abdira";
$db = "abdinega_db_raporkm";

//Menggunakan objek mysqli untuk membuat koneksi dan menyimpanya dalam variabel $mysqli
$mysqli = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($mysqli->connect_error) {
die("Koneksi gagal: " . $mysqli->connect_error);
}

// buat variabel untuk validasi dari file fungsi_validasi.php
$val = new validasi;
//Membuat variabel yang menyimpan url website dan folder website
$url_website = "http://localhost:8080/template/rapor_km";
$folder_website = "/smkbisa";

//Menentukan timezone
// date_default_timezone_set('Asia/Singapore');

?>