<?php
include 'token.php'; // Pastikan token telah didefinisikan dengan benar di file token.php
date_default_timezone_set("Asia/Bangkok");
// Koneksi ke database MySQL
$servername = "localhost";
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$dbname = "abdinega_db_raporkm"; // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Query untuk mengambil data pengingat dari database
$sql = "SELECT waktu_pengingat, pesan FROM pengingat WHERE aktif = '1'"; // Sesuaikan dengan struktur tabel dan kondisi Anda

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil hasil query (biasanya hanya satu pengingat yang aktif pada waktu tertentu)
    $row = $result->fetch_assoc();

    // Persiapkan data untuk dikirim ke API Fonnte
    $pesan = $row['pesan'];
    $schedule = strtotime($row['waktu_pengingat']); // Konversi waktu_pengingat ke UNIX timestamp

    // Query untuk mengambil semua kontak dari tabel user
    $sql_kontak = "SELECT kontak FROM users"; 
    $result_kontak = $conn->query($sql_kontak);

    if ($result_kontak->num_rows > 0) {
        while ($row_kontak = $result_kontak->fetch_assoc()) {
            $target = $row_kontak['kontak'];

            // Kirim pesan menggunakan API Fonnte
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $target, // Gunakan nomor penerima dari database
                    'message' => $pesan, // Gunakan pesan dari database
                    'schedule' => $schedule, // Gunakan waktu pengiriman dari database
                    'countryCode' => '62', // Opsional, sesuaikan kebutuhan
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token // Ganti $token dengan variabel token
                ),
            ));

            $response = curl_exec($curl);
            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
            }
            curl_close($curl);

            if (isset($error_msg)) {
                echo "Error: " . $error_msg;
            } else {
                echo "Pesan berhasil dikirim ke $target: " . $response;
            }
        }
    } else {
        echo "Tidak ada kontak yang ditemukan.";
    }
} else {
    echo "Tidak ada pengingat aktif yang perlu dikirim saat ini.";
}

// Tutup koneksi ke database
$conn->close();
?>