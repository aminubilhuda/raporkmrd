<?php
include 'token.php'; 
include '../../config/koneksi.php';
date_default_timezone_set("Asia/Bangkok");

// Ambil pengingat aktif
$sql = "SELECT waktu_pengingat, pesan FROM pengingat WHERE aktif = '1'";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pesan = $row['pesan'];
    $schedule = strtotime($row['waktu_pengingat']);

    // Ambil kontak pengguna
    $sql_kontak = "SELECT kontak FROM users";
    $result_kontak = $mysqli->query($sql_kontak);

    if ($result_kontak && $result_kontak->num_rows > 0) {
        $berhasil = [];
        $gagal = [];

        while ($row_kontak = $result_kontak->fetch_assoc()) {
            $target = $row_kontak['kontak'];
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10, // Set timeout
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'target' => $target,
                    'message' => $pesan,
                    'schedule' => $schedule,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $token,
                ),
            ));

            $response = curl_exec($curl);
            $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            if (curl_errno($curl) || $http_code != 200) {
                $error_msg = curl_error($curl) ?: "HTTP Code: $http_code";
                $gagal[] = $target;
                $status = "Gagal: $error_msg";

                // Simpan status pengiriman gagal
                $stmt = $mysqli->prepare("INSERT INTO laporan_wa (kontak, status_pengiriman) VALUES (?, ?)");
                $stmt->bind_param('ss', $target, $status);
                $stmt->execute();
                $stmt->close();
            } else {
                $response_data = json_decode($response, true);
                $status = isset($response_data['status']) && $response_data['status'] ? 'Berhasil' : 'Gagal';
                $berhasil[] = $target;

                // Simpan status pengiriman berhasil
                $stmt = $mysqli->prepare("INSERT INTO laporan_wa (kontak, status_pengiriman) VALUES (?, ?)");
                $stmt->bind_param('ss', $target, $status);
                $stmt->execute();
                $stmt->close();
            }

            curl_close($curl);
        }

        echo "<script>
            alert('Pesan berhasil dikirim ke: " . implode(", ", $berhasil) . "\\nPesan gagal dikirim ke: " . implode(", ", $gagal) . "');
            window.close();
        </script>";
    } else {
        echo "Tidak ada kontak yang ditemukan.";
    }
} else {
    echo "Tidak ada pengingat aktif yang perlu dikirim saat ini.";
}

$mysqli->close();
?>